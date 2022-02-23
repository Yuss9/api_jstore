<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HelloController{
    //action que l'on veut realiser
    
    /**
     * @Route("/hello")
     */
    public function hello(): Response{
        return new Response("Hello World");
    }

    /**
     * @Route("/hello/{name}")
     */
    public function helloName($name) : Response{
        return  new Response("Hello ".$name);
    }



}

?>