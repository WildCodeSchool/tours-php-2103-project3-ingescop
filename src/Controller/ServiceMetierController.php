<?php

namespace App\Controller;

use App\Entity\ServiceMetier;
use App\Repository\ServiceMetierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/services", name="services_")
*/

class ServiceMetierController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(ServiceMetierRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        return $this->render('services/list.html.twig', [
            'services' => $services
        ]);
    }

    /**
     * @Route("show/{id}", methods={"GET"}, name="show")
     */
    public function show(int $id, ServiceMetierRepository $serviceRepository): Response
    {
        $service = $serviceRepository->findOneById($id);
        return $this->render('services/show.html.twig', [
            'service' => $service
        ]);
    }
}
