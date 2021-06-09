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
        $professionnal = $proRepository->findBy(array(), array('name' => 'ASC'));
        return $this->render('professionnal/list.html.twig', ['professionnels' => $professionnal]);
    }
}
