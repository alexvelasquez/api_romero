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

use App\Entity\Category;
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
 * @Route("/api/category")
 */
class CategoryController extends FOSRestController
{


     /**
     * @Rest\Get("/{id}", name="category_list", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todos los jugadores.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar los jugadores")
     * @SWG\Tag(name="Category")
     */
    public function getCategories($id=null) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $categories = [];
        try {
            $code = 200;  
            $categories = is_null($id) ? $em->getRepository("App:Category")->findAll() : $em->getRepository("App:Category")->find($id);
            if (is_null($categories)) {
                $code = 500;
                $message = "No hay Categorias";
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
     * @Rest\Post("/add", name="category_add", defaults={"_format":"json"})
     * @SWG\Response(response=201,description="category was added successfully")
     * @SWG\Response(response=500,description="An error was occurred trying to add new category")
     * @SWG\Parameter(name="description",in="body",type="string",description="description of the Category",schema={})

     * @SWG\Tag(name="Category")
     */
    public function addCategory(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $category = [];
        try {
           $code = 201;           
           $description = $request->request->get("description",null);

           if (!is_null($description) ) {
               $category = new Category(ucfirst(strtolower($description)));
               $em->persist($category);
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
            'data' => $code == 201 ? $category : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }


    

}