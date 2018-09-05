<?php

namespace App\Controller;

use App\Entity\CustomerJob;

use App\Form\CustomerJobType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerJobController
{
    /**
    * @Route("/jobs", methods={"POST"})
    */
    public function newJob(Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);

        $newJob = new CustomerJob();
        $form = $formFactory->create(CustomerJobType::class, $newJob);
        $form->submit($data);

        if (!$form->isSubmitted() && !$form->isValid()) {
            return new JsonResponse("Not valid data");
        }

        $em->persist($newJob);
        $em->flush();

        return new JsonResponse("Works", 201);
    }
}