<?php

namespace App\Tests\Controller;

use App\Test\ApiTestCase;

class CustomerJobControllerTest extends ApiTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->createServices();
    }

    public function testPOSTnewJob()
    {
        $testJob = [
          "title" => "Test title",
          "city" => "Test city",
          "zipcode" => "12345",
          "description" => "Test discription",
          "deliveryDate" => "2018-09-05 19:30",
          "service" => "1"
        ];

        $testJobJson = json_encode($testJob);
        $this->client->request(
            'POST',
            '/api/jobs',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/son',
                'HTTP_ACCEPT' => 'application/json'
            ),
            $testJobJson
        );

        $this->assertTrue($this->client->getResponse()->headers->contains(
            'Content-Type',
            'application/json'
        ));

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }
}