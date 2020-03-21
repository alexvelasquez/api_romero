<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class DefaultController 
{
    /**
     * @Route("", name="default")
     */
    public function ping()
    {
        return new Response(
            '<html><body><h1>BIENVENIDO</h1></body></html>'
        );
    }
}