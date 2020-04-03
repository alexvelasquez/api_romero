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
 * @Route("/api/states")
 */
class StateController extends FOSRestController
{


     /**
     * @Rest\Get("/{id}", name="states_list", defaults={"_format":"json"})
     * @SWG\Response(response=200,description="Devuelve todas las cuotas.")
     * @SWG\Response(response=400,description="Hubo un problema para recuperar las cuotas")
     * @SWG\Tag(name="Cuota")
     */
    public function getStates($id=null) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $states = [];
        try {
            $code = 200;  
            $states = is_null($id) ? $em->getRepository("App:State")->findAll() : $em->getRepository("App:State")->find($id);
            if (is_null($states)) {
                $code = 500;
                $message = "No hay Estados";
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = "Error al recuperar los estados - Error: {$ex->getMessage()}";
        }
        $response = [
            'code' => $code,
            'data' => $code == 200 ? $states : $message,
        ];
        return new Response($serializer->serialize($response, "json"));
    }    


    

}