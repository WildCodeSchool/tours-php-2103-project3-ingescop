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
     * @Route("/", name="home")
     */
    public function index(
        PartnerRepository $partnerRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $manager,
        AdminRepository $adminRepository
    ): Response {
        $admin = $adminRepository->findAll();
        if (empty($admin)) {
            $firstAdmin = new Admin();
            $firstAdmin->setUsername('admin');
            $firstAdmin->setRoles(['ROLE_ADMIN']);
            $firstAdmin->setPassword($passwordEncoder->encodePassword(
                $firstAdmin,
                'patrickgarreau123@'
            ));

            $manager->persist($firstAdmin);
            $manager->flush();
        }

        return $this->render('home/index.html.twig', [
            'partners' => $partnerRepository->findAll()
        ]);
    }
}
