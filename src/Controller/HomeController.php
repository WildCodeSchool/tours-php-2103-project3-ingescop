<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Partner;
use App\Repository\AdminRepository;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * Home page
     * @Route("/", name="home")
     */
    public function index(PartnerRepository $partnerRepository): Response
    {

        return $this->render('home/index.html.twig', [
            'partners' => $partnerRepository->findAll()
        ]);
    }

    /**
     * Legal notice page
     * @Route("/notice", name="notice")
     */
    public function notice(): Response
    {
        return $this->render('home/notice.html.twig');
    }
}
