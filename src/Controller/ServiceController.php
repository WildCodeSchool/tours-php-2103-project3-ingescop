<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/services", name="services_")
*/

class ServiceController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        shuffle($services);
        return $this->render('services/list.html.twig', [
            'services' => $services
        ]);
    }

    /**
     * @Route("show/{id}", methods={"GET"}, name="show")
     */
    public function show(int $id, ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findOneById($id);
        return $this->render('services/show.html.twig', [
            'services' => $services
        ]);
    }
}
