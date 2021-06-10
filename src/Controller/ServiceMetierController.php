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
    public function list(ServiceMetierRepository $serviceMetierRepository): Response
    {
        $services = $serviceMetierRepository->findAll();
        return $this->render('services/list.html.twig', [
            'services' => $services
        ]);
    }
}
