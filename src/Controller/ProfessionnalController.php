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
    public function list(): Response
    {
        $professionnal = $this->getDoctrine()
            ->getRepository(Professionnal::class)
            ->findAll();
        return $this->render('professionnal/list.html.twig', ['professionnels' => $professionnal]);
    }
}
