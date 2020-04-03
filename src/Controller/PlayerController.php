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

use App\Entity\Player;
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
 * @Route("/api/players")
 */
class PlayerController extends FOSRestController
{


     /**
     * @Rest\Get("/{id}", name="player_list", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los jugadores.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar los jugadores")
     * @SWG\Tag(name="Player")
     */
    public function getPlayers($id=null) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $players = [];
        try {
            $code = 200;  
            $players = is_null($id) ? $em->getRepository("App:Player")->findAll() : $em->getRepository("App:Player")->find($id);
            if (is_null($players)) {
                $code = 500;
                $message = "No hay jugadores";
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar los jugadores - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $players : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Put("/{id}", name="player_edit", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los jugadores.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar los jugadores")
     * 
     * @SWG\Parameter(name="name",in="body",type="string",description="name of the player",schema={})
     * @SWG\Parameter(name="last_name",in="body",type="string",description="last_name of the player",schema={})
     * @SWG\Parameter(name="dni",in="body",type="string",description="dni of the player",schema={})
     * @SWG\Parameter(name="birth_date",in="body",type="string",description="birth_date of the player",schema={})
     * @SWG\Parameter(name="category",in="body",type="string",description="category of the player",schema={})
     * @SWG\Tag(name="Player")
     */
    public function editPlayer(Request $request,$id){
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        try {
            $code = 200;
            $name = $request->request->get("name");
            $lastName = $request->request->get("last_name");
            $dni = !empty($request->request->get("dni")) ? $request->request->get("dni") : null;
            $birthDate = !empty($request->request->get("birth_date")) ? new \DateTime($request->request->get("birth_date")) : null;
            $phone =  !empty($request->request->get("phone")) ? $request->request->get("phone") : null;
            $category = !empty($request->request->get("category")) ? $em->getRepository("App:Category")->findOneBy(['description'=>$request->request->get("category")]) : null;
            if (!is_null($name) && !is_null($lastName) && !is_null($category)) {
                $player = $em->getRepository("App:Player")->find($id);
                $player->setName($name);
                $player->setlastName($lastName);
                $player->setDni($dni);
                $player->setBirthDate($birthDate);
                $player->setCategory($category);
                $player->setPhone($phone);
                $em->persist($player);
                $em->flush();
            }
            else{
                $code = 500;
                $message = "Error parametros incorrectos - Error: Algunos parametros son obligatorios";
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar los jugadores - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $player : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }
        /**
     * @Rest\Get("/category/{description}", name="player_for_category", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los jugadores por categorias.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar los jugadores")
     * @SWG\Tag(name="Player")
     */
    public function playersForCategories($description) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $players = [];
        try {
            $code = 200;
            $category =  !is_null($description) ? $em->getRepository("App:Category")->findOneBy(['description'=> ucfirst(strtolower($description))]) : null;
            if (is_null($category)) {
                $code = 500;
                $message = "Debe ingresar una categoria";
            }
            else{
                $players = $em->getRepository("App:Player")->findBy(['category'=>$category]);
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar los jugadores - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $players : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }


    /**
     * @Rest\Post("/add", name="player_add", defaults={"_format":"json"})
     * @SWG\Response(response=201,description="Board was added successfully")
     * @SWG\Response(response=500,description="An error was occurred trying to add new board")
     * @SWG\Parameter(name="name",in="body",type="string",description="name of the player",schema={})
     * @SWG\Parameter(name="last_name",in="body",type="string",description="last_name of the player",schema={})
     * @SWG\Parameter(name="dni",in="body",type="string",description="dni of the player",schema={})
     * @SWG\Parameter(name="birth_date",in="body",type="string",description="birth_date of the player",schema={})
     * @SWG\Parameter(name="category",in="body",type="string",description="category of the player",schema={})
     * @SWG\Parameter(name="phone",in="body",type="string",description="phone of the player",schema={})
     * @SWG\Tag(name="Player")
     */
    public function addPlayer(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $player = [];
        try {
           $code = 201;
           
           //data person
           $name = $request->request->get("name");
           $lastName = $request->request->get("last_name");
           $dni = !empty($request->request->get("dni")) ? $request->request->get("dni") : null;

           //fecha
           $birthDate = !empty($request->request->get("birth_date")) ? new \DateTime($request->request->get('birth_date')) : null;


           //category and other 
           $category = !empty($request->request->get("category")) ? $em->getRepository("App:Category")->findOneBy(['description'=>$request->request->get("category")]) : null;
           $phone = !empty($request->request->get("phone")) ? $request->request->get("phone") : null;
           
           if (!is_null($name) && !is_null($lastName) && !is_null($category)) {
               $player = new Player(ucwords($name),ucwords($lastName),$category,$birthDate,$dni,$phone);
               $em->persist($player);
               $em->flush();

           } else {
               $code = 500;
               $message = "Parameters invalid - Error: name, last name and category is required";
           }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Ha ocurrido un error al agregar un jugador - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'data' => $code == 201 ? $player : $message,
            'debug' => $request->request
        ];
        return new Response($serializer->serialize($response, "json"));
    }



    

}