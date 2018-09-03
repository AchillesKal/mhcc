<?php

namespace App\Tests\Controller;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CustomerJobControllerTest extends TestCase
{

    public function testPOST()
    {
        $client = new Client();
        $response = $client->request('POST', "http://mhcc.loc/jobs");

        $this->assertEquals(201, $response->getStatusCode());
    }
}