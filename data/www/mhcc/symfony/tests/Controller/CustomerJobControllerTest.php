<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

class CustomerJobControllerTest extends WebTestCase
{
    public function testPOSTnewJob()
    {
        $data = [
          "title" => "Test title",
          "city" => "Test city",
          "zipcode" => "12345",
          "description" => "Test discription",
          "deliveryDate" => "2018-09-05 19:30",
          "service" => "1"
        ];

        /** @var Client */
        $client = static::createClient();

        $postData = json_encode($data);

        $client->request(
            'POST',
            '/jobs',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/son',
                'HTTP_ACCEPT' => 'application/json'
            ),
            $postData
        );

        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type',
            'application/json'
        ));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}