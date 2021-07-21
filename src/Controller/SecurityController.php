<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use App\FormData\PasswordData;
use App\Form\ResetPasswordType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $manager,
        AdminRepository $adminRepository
    ): Response {
        $admin = $adminRepository->findAll();
        if (empty($admin)) {
            $firstAdmin = new Admin();
            $form = $this->createForm(AdminType::class, $firstAdmin);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($firstAdmin, $firstAdmin->getPassword());
                $firstAdmin->setPassword($password);
                $firstAdmin->setRoles(['ROLE_ADMIN']);
                $manager->persist($firstAdmin);
                $manager->flush();
                return $this->redirectToRoute('home');
            }
            return $this->render('registration/register.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('home');
    }

    /**
     * function for connection
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_panelconfig');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * function for deconnection
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank -
         it will be intercepted by the logout key on your firewall.');
    }

    /**
     * function to change password
     * @Route("/resetPassword", name="reset-password")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if (!$user instanceof Admin) {
            throw $this->createAccessDeniedException('vous devez etre connecté');
        }
        $changePassword = new PasswordData();
        // linking of the form with the PasswordData class
        $form = $this->createForm(ResetPasswordType::class, $changePassword);
        $form->handleRequest($request);
        $password = $form->get('oldPassword')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordEncoder->isPasswordValid($user, $password)) {
                $newpwd = $changePassword->getPassword();
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $newpwd);
                $user->setPassword($newEncodedPassword);
                $entityManager->flush();
                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('admin_panelconfig');
            }
        }
        return $this->render('password/index.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user
        ));
    }
}
