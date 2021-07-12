<?php

namespace App\Controller;

use App\Entity\Admin;
use App\FormData\PasswordData;
use App\Form\ResetPasswordType;
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
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank -
         it will be intercepted by the logout key on your firewall.');
    }

    /**
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
        // rattachement du formulaire avec la class PasswordData
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
