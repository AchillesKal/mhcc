<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerJobController
{
    /**
    * @Route("/jobs", methods={"POST"})
    */
    public function newJob()
    {
        return new Response(
            '<html><body>Works!!</body></html>'
        );
    }
}