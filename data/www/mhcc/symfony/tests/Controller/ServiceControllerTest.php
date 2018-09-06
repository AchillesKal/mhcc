<?php

namespace App\Tests\Controller;

use App\Test\ApiTestCase;

class ServiceControllerTest extends ApiTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->createServices();
    }

    public function testListServices()
    {
        $this->client->request('GET', '/api/services');

        $responseBody = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey("services", $responseBody);
        $this->assertEquals(200,  $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseBody["services"][0]["id"]);
        $this->assertEquals("Test1", $responseBody["services"][0]["name"]);
    }
}