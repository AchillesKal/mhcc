<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    /**
    * @Route("/")
    */
    public function index()
    {
        return new Response(
            '<html><body>Works!!</body></html>'
        );
    }
}