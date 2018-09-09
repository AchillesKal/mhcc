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

    public function testNoTitleFieldValidationError()
    {
        $testJob = [
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

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('validation_error', $jsonResponse["type"]);
        $this->assertEquals("Title should not be blank", $jsonResponse["errors"]["title"][0]);
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testMinCharactersTitleFieldValidationError()
    {
        $testJob = [
            "title" => "Tes",
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

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('validation_error', $jsonResponse["type"]);
        $this->assertEquals("Your title must be at least 5 characters long", $jsonResponse["errors"]["title"][0]);
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testMaxCharactersTitleFieldValidationError()
    {
        $testJob = [
            "title" => "Test Test Test Test Test Test Test Test Test Test Test Test",
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

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('validation_error', $jsonResponse["type"]);
        $this->assertEquals("Your title cannot be longer than 50 characters", $jsonResponse["errors"]["title"][0]);
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testNoZipcodeFieldValidationError()
    {
        $testJob = [
            "title" => "Test title",
            "city" => "Test city",
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

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('validation_error', $jsonResponse["type"]);
        $this->assertEquals("Zipcode should not be blank", $jsonResponse["errors"]["zipcode"][0]);
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testMinZipcodeFieldValidationError()
    {
        $testJob = [
            "title" => "Test title",
            "city" => "Test city",
            "zipcode" => "123",
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

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('validation_error', $jsonResponse["type"]);
        $this->assertEquals('Your zipcode should have exactly 5 characters', $jsonResponse["errors"]["zipcode"][0]);
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testMaxZipcodeFieldValidationError()
    {
        $testJob = [
            "title" => "Test title",
            "city" => "Test city",
            "zipcode" => "123123",
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

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('validation_error', $jsonResponse["type"]);
        $this->assertEquals('Your zipcode should have exactly 5 characters', $jsonResponse["errors"]["zipcode"][0]);
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testInvalidJson()
    {
        $invalidJson = '{ "title": "Testtitle"zipcode": "test_zip", "description": "test_description", "deliveryDate": "2018-09-05 19:30", "service": "402020" }';
        $this->client->request(
            'POST',
            '/api/jobs',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/son',
                'HTTP_ACCEPT' => 'application/json'
            ),
            $invalidJson
        );

        $response = $this->client->getResponse();
        $responseBody = $response->getContent();
        $jsonResponse = json_decode($responseBody, true);

        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertEquals(400, $response->getStatusCode());
    }
}