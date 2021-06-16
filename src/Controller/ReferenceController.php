<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/reference", name="reference_")
*/
class ReferenceController extends AbstractController
{

    /**
     * @Route("/list", name="list")
     */
    public function reference(ProjectRepository $projectRepository): Response
    {
        $references = $projectRepository->findBy(
            [],
            ['note' => 'DESC']
        );
        return $this->render('reference/list.html.twig', [
            'references' => $references
            ]);
    }

    /**
     * @Route("show/{id}", methods={"GET"}, name="show")
     */
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        $reference = $projectRepository->findOneById($id);
        return $this->render('reference/show.html.twig', [
            'reference' => $reference
        ]);
    }
}
