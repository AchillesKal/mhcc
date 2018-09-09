<?php

namespace App\Controller;

use App\Api\ApiProblem;
use App\Entity\CustomerJob;
use App\Form\CustomerJobType;
use App\Utils\FormErrorResolver;
use App\Api\ApiProblemException;
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
        if ($data === null) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            throw new ApiProblemException($apiProblem);
        }

        $newJob = new CustomerJob();
        $form = $formFactory->create(CustomerJobType::class, $newJob);
        $form->submit($data);
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $formErrorResolver->getFromErrors($form);

            $apiProblem = new ApiProblem(
                400,
                ApiProblem::TYPE_VALIDATION_ERROR
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