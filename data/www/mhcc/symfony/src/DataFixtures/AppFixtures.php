<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $defaultServices = [
          "804040" => "Sonstige Umzugsleistungen",
          "802030" => "Abtransport, Entsorgung und Entrümpelung",
          "411070" => "Fensterreinigung",
          "402020" => "Holzdielen schleifen",
          "108140" => "Kellersanierung"
        ];

        foreach ($defaultServices as $serviceId => $serviceName) {
            $service = new Service();
            $service->setId($serviceId);
            $service->setName($serviceName);
            $manager->persist($service);

            // Enforce specified record ID
            $metadata = $manager->getClassMetaData(get_class($service));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }

        $manager->flush();
    }
}
