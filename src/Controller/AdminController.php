<?php

namespace App\Controller;

use App\Repository\ProfessionnalRepository;
use App\Repository\ProjectRepository;
use App\Repository\PartnerRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="panelconfig", methods={"GET"})
     */
    public function list(
        ProjectRepository $projectRepository,
        ProfessionnalRepository $proRepository,
        ServiceRepository $serviceRepository,
        PartnerRepository $partnerRepository
    ): Response {

        return $this->render('admin/panelconfig.html.twig', [
            'services' => $serviceRepository->findAll(),
            'projects' => $projectRepository->findBy([], ['note' => 'DESC']),
            'pro' => $proRepository->findAll(),
            'partners' => $partnerRepository->findAll()
        ]);
    }
}
