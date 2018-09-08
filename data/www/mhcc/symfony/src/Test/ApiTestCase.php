<?php

namespace App\Test;

use App\Entity\Service;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\Mapping\ClassMetadata;

class ApiTestCase extends KernelTestCase
{
    private static $staticClient;

    protected $client;
    
    protected function setUp()
    {
        $kernel = static::bootKernel();
        self::$staticClient = $kernel->getContainer()->get('test.client');
        $this->client = self::$staticClient;
        $this->purgeDatabase();
    }

    private function purgeDatabase()
    {
        $purger = new ORMPurger($this->getService('doctrine.orm.entity_manager'));
        $purger->purge();
    }

    protected function getService($id)
    {
        return self::$kernel->getContainer()
            ->get($id);
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getService('doctrine.orm.entity_manager');
    }

    protected function createServices()
    {
        for($i = 1; $i <= 5; $i++) {
            $serviceName = "Test" . $i;
            $service = new Service();
            $service->setId($i);
            $service->setName($serviceName);
            $this->getEntityManager()->persist($service);

            // Enforce specified record ID.
            $metadata =  $this->getEntityManager()->getClassMetaData(get_class($service));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        }

        $this->getEntityManager()->flush();
    }

}