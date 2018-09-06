<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class ServiceController
{
    /**
     * @Route("/api/services", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of services",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Service::class, groups={"full"}))
     *     )
     * )
     * @SWG\Tag(name="Services")
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