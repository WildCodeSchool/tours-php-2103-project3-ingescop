<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferenceController extends AbstractController
{

    /**
     * @Route("/reference", name="reference")
     */
    public function reference(ProjectRepository $projectRepository): Response
    {
        $references = $projectRepository->findAll();
        return $this->render('reference/reference.html.twig', [
            'reference' => $references
            ]);
    }
}
