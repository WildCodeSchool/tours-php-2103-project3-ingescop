<?php

namespace App\Controller;

use App\Form\ContactDataType;
use App\FormData\ContactData;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contactpro", name="contactpro")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactData();
        $form = $this->createForm(ContactDataType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new Email())
                ->from($data->getEmailAddress())
                ->to('s.sauvaget41000@gmail.com')
                ->subject('Vous avez reçu un nouveau mail')
                ->text('Send by : ' . $data->getEmailAddress() . \PHP_EOL .
                 $data->getMessage(), 'text/plain');
                 $mailer->send($message);

                 $this->addFlash("Success", 'Votre message à été envoyé avec succès !');
                 return $this->redirectToRoute('contactpro');
        }
        return $this->render('contact/contactpro.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
