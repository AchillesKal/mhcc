<?php

namespace App\Tests\Controller;

use App\Entity\Service;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Doctrine\ORM\Mapping\ClassMetadata;

class ServiceControllerTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        // Purge the database.
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        // Prepopulate test database with services.
        for($i = 1; $i <= 5; $i++) {
            $serviceName = "Test" . $i;
            $service = new Service();
            $service->setId($i);
            $service->setName($serviceName);
            $this->entityManager->persist($service);

            // Enforce specified record ID.
            $metadata = $this->entityManager->getClassMetaData(get_class($service));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        }

        $this->entityManager->flush();
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