<?php

namespace App\Controller;

use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Repository\ProfessionnalRepository;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\PartnerRepository;
use App\Entity\Images;
use App\Service\FileUploaderService;
use App\Service\ImagesProjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        PartnerRepository $partnerRepository
    ): Response {
        return $this->render('admin/panelconfig.html.twig', [
            'projects' => $projectRepository->findAll(),
            'pro' => $proRepository->findAll(),
            'partners' => $partnerRepository->findAll()
        ]);
    }
}
