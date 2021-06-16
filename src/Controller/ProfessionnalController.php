<?php

namespace App\Controller;

use App\Entity\Professionnal;
use App\Repository\ProfessionnalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/pro", name="professionnal_")
*/

class ProfessionnalController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(ProfessionnalRepository $proRepository): Response
    {
        $professionnal = $proRepository->findAll();
        return $this->render('professionnal/list.html.twig', ['professionnels' => $professionnal]);
    }

    /**
     * @Route("show/{id}", methods={"GET"}, name="show")
     */
    public function show(int $id, ProfessionnalRepository $proRepository): Response
    {
        $pro = $proRepository->findOneById($id);
        return $this->render('professionnal/show.html.twig', [
            'profil' => $pro
        ]);
    }
}
