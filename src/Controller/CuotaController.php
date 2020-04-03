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
 * @Route("/api/cuotas")
 */
class CuotaController extends FOSRestController
{


     /**
     * @Rest\Get("/{id}", name="cuotas_list", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todas las cuotas.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las cuotas")
     * @SWG\Tag(name="Cuota")
     */
    public function getCuotas($id=null) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $categories = [];
        try {
            $code = 200;  
            $categories = is_null($id) ? $em->getRepository("App:Cuota")->findAll() : $em->getRepository("App:Cuota")->find($id);
            if (is_null($categories)) {
                $code = 500;
                $message = "No hay Cuotas";
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar las Categorias - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $categories : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Post("/add", name="cuota_add", defaults={"_format":"json"})
     * @SWG\Response(response=201,description="category was added successfully")
     * @SWG\Response(response=500,description="An error was occurred trying to add new category")
     * @SWG\Parameter(name="description",in="body",type="string",description="description of the Category",schema={})

     * @SWG\Tag(name="Cuota")
     */
    public function addCuota(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        try {
           $code = 201;           
           $date = new \DateTime($request->request->get("date"));

           if (!is_null($date) ) {
               $cuota = new Cuota($date);
               $em->persist($cuota);
               $em->flush();

           } else {
               $code = 500;
               $message = "Parametros incorrectos - Error: la descripción es obligatoria";
           }

        } catch (Exception $ex) {
            $code = 500;
            $message = "Ha ocurrido un error al agregar un jugador - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'data' => $code == 201 ? $cuota : $message,
        ];
        return new Response($serializer->serialize($cuota, "json"));
    }

    
     /**
     * @Rest\Get("/year/{anio}", name="cuotas_anio", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todas las cuotas por año.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las cuotas")
     * @SWG\Tag(name="Cuota")
     */
    public function getCuotasForYear($anio) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $cuotas = [];
        try {
            $code = 200;
            $fromDate = new \DateTime($anio.'-01-01'); 
            $endDate =  new \DateTime($anio.'-12-31');
            $cuotas =  $em->getRepository("App:Cuota")->findAllCuotaAnio($fromDate,$endDate);
            if (is_null($cuotas)) {
                $code = 204;
                $message = "No hay Cuotas";
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar las Categorias - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $cuotas : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Delete("/delete/{id}", name="delete_cuota", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todas las cuotas por año.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las cuotas")
     * @SWG\Tag(name="Cuota")
     */
    public function deleteCuota(Cuota $id) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        try {
            $code=200;
            $paymentsCouta =  $em->getRepository("App:Payment")->findBy(['cuota'=>$id]);
            foreach ($paymentsCouta as $value) {
                //remove all poyments of cuota
                $em->remove($value);
            }
            //delete cuouta
            $em->remove($id);
            $em->flush();
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al eliminar la cuota - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? 'Eliminado Correctamente' : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }
    
    


    

}