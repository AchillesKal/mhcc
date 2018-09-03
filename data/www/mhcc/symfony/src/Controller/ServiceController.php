<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController
{
    /**
    * @Route("/services", methods={"GET"})
    */
    public function listServices(ServiceRepository $serviceRepository)
    {
        $services = $serviceRepository->findAll();
        $data = array('services' => array());

        foreach ($services as $service) {
            $data['services'][] = $this->serializeService($service);
        }

        $response = new JsonResponse($data, 200);
        return $response;
    }

    private function serializeService(Service $service)
    {
        return array(
            'id' => $service->getId(),
            'name' => $service->getName(),
        );
    }
}