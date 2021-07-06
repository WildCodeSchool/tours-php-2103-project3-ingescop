<?php

namespace App\Controller;

use App\Entity\Admin;
use App\FormData\PasswordData;
use App\Form\ResetPasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{
    /**
     * @Route("/resetPassword", name="reset-password")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $result = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if (!$user instanceof Admin) {
            throw $this->createAccessDeniedException('vous devez etre connecté');
        }
        $changePassword = new PasswordData();
        // rattachement du formulaire avec la class PasswordData
        $form = $this->createForm(ResetPasswordType::class, $changePassword);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newpwd = $form->get('Password')['first']->getData();
            $newEncodedPassword = $passwordEncoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);
            $result->flush();
            $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('password/index.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user
        ));
    }
}
