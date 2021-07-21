<?php

namespace App\Controller;

use App\Repository\ProfessionnalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/professionnal", name="professionnal_")
*/
class ProfessionnalController extends AbstractController
{
    /**
     * function to display the professional list
     * @Route("/list", name="list")
     */
    public function list(ProfessionnalRepository $proRepository): Response
    {
        $professionnal = $proRepository->findBy(array(), array('name' => 'ASC'));
        return $this->render('professionnal/list.html.twig', ['professionnels' => $professionnal]);
    }

    /**
     * function to display the detail of a professional
     * @Route("/show/{id}", methods={"GET"}, name="show")
     */
    public function show(int $id, ProfessionnalRepository $proRepository): Response
    {
        $pro = $proRepository->findOneById($id);
        return $this->render('professionnal/show.html.twig', [
            'pro' => $pro
        ]);
    }
}
