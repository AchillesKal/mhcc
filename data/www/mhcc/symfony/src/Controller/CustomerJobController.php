<?php

namespace App\Controller;

use App\Api\ApiProblem;
use App\Entity\CustomerJob;

use App\Form\CustomerJobType;
use App\Utils\FormErrorResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class CustomerJobController
{
    /**
    * @Route("/api/jobs", methods={"POST"})
    * @SWG\Response(
    *     response=200,
    *     description="Returns a list of services",
    *     @SWG\Schema(
    *         type="array",
    *         @SWG\Items(ref=@Model(type=CustomerJobType::class, groups={"full"}))
    *     )
    * )
    * @SWG\Tag(name="Jobs")
    */
    public function newJob(
        Request $request,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        FormErrorResolver $formErrorResolver
    )
    {
        $data = json_decode($request->getContent(), true);

        $newJob = new CustomerJob();
        $form = $formFactory->create(CustomerJobType::class, $newJob);
        $form->submit($data);
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $formErrorResolver->getFromErrors($form);

            $apiProblem = new ApiProblem(
                400,
                'validation_error',
                'There was a validation error'
            );
            $apiProblem->set('errors', $errors);

            $response = new JsonResponse($apiProblem->toArray(), $apiProblem->getStatusCode());
            $response->headers->set('Content-Type', 'application/problem+json');

            return $response;
        }

        $em->persist($newJob);
        $em->flush();

        return new JsonResponse("The job was successfully added.", 201);
    }
}