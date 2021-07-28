<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresentationController extends AbstractController
{
    /**
     * Qui sommes nous page
     * @Route("/presentation", name="presentation")
     */
    public function presentation(): Response
    {
        return $this->render('home/presentation.html.twig');
    }
}
