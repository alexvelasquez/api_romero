<?php
/**
 * ApiController.php
 *
 * API Controller
 *
 * @category   Controller
 * @package    MyKanban
 * @author     Francisco Ugalde
 * @copyright  2018 www.franciscougalde.com
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Cuota;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class ApiController
 *
 * @Route("/api/payments")
 */
class PaymentController extends FOSRestController
{


     /**
     * @Rest\Get("/{id}", name="payment_list", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todas las cuotas.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las cuotas")
     * @SWG\Tag(name="Payment")
     */
    public function getPayments($id=null) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $payments = [];
        try {
            $code = 200;  
            $payments = is_null($id) ? $em->getRepository("App:Payment")->findAll() : $em->getRepository("App:Cuota")->find($id);
            if (is_null($payments)) {
                $code = 500;
                $message = "No hay Cuotas";
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar las Categorias - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $payments : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Post("/add", name="payment_add", defaults={"_format":"json"})
     * @SWG\Response(response=201,description="category was added successfully")
     * @SWG\Response(response=500,description="An error was occurred trying to add new category")
     * @SWG\Parameter(name="description",in="body",type="string",description="description of the Category",schema={})

     * @SWG\Tag(name="payment")
     */
    public function addpayment(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        try {
           $code = 201;           
           $player =  $em->getRepository("App:Player")->find($request->request->get("player"));
           $cuota =  $em->getRepository("App:Cuota")->find($request->request->get("cuota"));
           $state= $em->getRepository("App:State")->findOneBy(['description'=>$request->request->get("state")]);
           $value = $request->request->get("value");
            
           if (!is_null($player) & !is_null($cuota) & !is_null($state) & !is_null($value)) {
               $payment = new Payment($player,$cuota,$state,$value);
               $em->persist($payment);
               $em->flush();

           } else {
               $code = 500;
               $message = "Parametros incorrectos - Error: Algunos campos son obligatorios";
           }

        } catch (Exception $ex) {
            $code = 500;
            $message = "Ha ocurrido un error al agregar un pago - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'data' => $code == 201 ? $payment : $message,
        ];
        return new Response($serializer->serialize($payment, "json"));
    }

    /**
     * @Rest\Put("/edit/{payment}", name="payment_edit", defaults={"_format":"json"})
     * @SWG\Response(response=201,description="category was added successfully")
     * @SWG\Response(response=500,description="An error was occurred trying to add new category")
     * @SWG\Parameter(name="description",in="body",type="string",description="description of the Category",schema={})

     * @SWG\Tag(name="payment")
     */
    public function editPayment(Request $request, Payment $payment) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        try {
            $code = 201;           
            $state= $em->getRepository("App:State")->findOneBy(['description'=>$request->request->get("state")]);
            $value = $request->request->get("value");
        
           if (!is_null($state) & !is_null($value)) {
               $payment->setState($state);
               $payment->setValue($payment->getValue() + $value);
               $em->persist($payment);
               $em->flush();

           } else {
               $code = 500;
               $message = "Parametros incorrectos - Error: Algunos campos son obligatorios";
           }

        } catch (Exception $ex) {
            $code = 500;
            $message = "Ha ocurrido un error al editars un pago - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'data' => $code == 201 ? $payment : $message,
        ];
        return new Response($serializer->serialize($payment, "json"));
    }

    /**
     * @Rest\Delete("/delete/{payment}", name="delete_payment", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todas las cuotas por año.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las cuotas")
     * @SWG\Tag(name="Cuota")
     */
    public function deletePayment(Payment $payment) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        try {
            $code=200;
            //delete cuouta
            $em->remove($payment);
            $em->flush();
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al eliminar el pago - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? 'Eliminado Correctamente' : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }
    
    
    
    /**
     * @Rest\Get("/cuota/{cuota}", name="payment_for_cuota", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los jugadores por categorias.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar los jugadores")
     * @SWG\Tag(name="Player")
     */
    public function playersPaymentForCategories(Request $request,Cuota $cuota) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $payments = [];
        try {
            $code = 200;
            $description = $request->query->get('category');
            $category =  !is_null($description) ? $em->getRepository("App:Category")->findOneBy(['description'=> ucfirst(strtolower($description))]) : null;
            if (is_null($category)) {
                $code = 500;
                $message = "Debe ingresar una categoria";
            }
            else{
                $payments = $em->getRepository("App:Payment")->findAllPaymentCategory($category,$cuota);

            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar los jugadores - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $payments : $message,
        ];
        return new Response($serializer->serialize($payments, "json"));
    }
        /**
     * @Rest\Get("/not/cuota/{cuota}", name="payment_for_not_cuota", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los jugadores por categorias.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar los jugadores")
     * @SWG\Tag(name="Player")
     */
    public function playersNotPaymentForCategories(Request $request,Cuota $cuota) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $players = [];
        try {
            $code = 200;
            $description = $request->query->get('category');
            $category =  !is_null($description) ? $em->getRepository("App:Category")->findOneBy(['description'=> ucfirst(strtolower($description))]) : null;
            if (is_null($category)) {
                $code = 500;
                $message = "Debe ingresar una categoria";
            }
            else{
                $players = $em->getRepository("App:Payment")->findAllNotPaymentCategory($category,$cuota);

            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar los jugadores - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $players : $message,
        ];
        return new Response($serializer->serialize($players, "json"));
    }

    /**
     * @Rest\Get("/values/generals", name="players_generals", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los valores generales.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las valores")
     * @SWG\Tag(name="Cuota")
     */
    public function getValues() {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $data = [];
        try {
            $code = 200;  
            $totalPlayers = $em->getRepository("App:Player")->findAllCount();

            $paymentPlayers = $em->getRepository("App:Payment")->findAllCountPayment();
            $notPaymentPlayers = $em->getRepository("App:Payment")->findAllCountNotPayment();
            $valueTotal =  $em->getRepository("App:Payment")->findAllTotalValue();
            
            $data['total_players']= $totalPlayers;
            $data['payment_players']= $paymentPlayers;
            $data['not_payment_players']= $notPaymentPlayers;
            $data['total_values']= number_format($valueTotal, 2, ',', '.');

        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar las Categorias - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $data : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }

}
