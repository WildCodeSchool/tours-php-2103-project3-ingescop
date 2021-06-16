<?php

namespace App\Controller;

use App\Form\ContactUsType;
use App\FormData\ContactData;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/contact/us", name="contactus")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new ContactData();
        $form = $this->createForm(ContactUsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new Email())
                ->from($contact->getEmailAddress())
                ->to('s.sauvaget41000@gmail.com')
                ->subject('Vous avez reçu un nouveau mail')
                ->text('Send by : ' . $contact->getEmailAddress() . \PHP_EOL .
                 $contact->getMessage(), 'text/plain');
                 $mailer->send($message);

                 $this->addFlash("Success", 'Votre message à été envoyé avec succès !');
                 return $this->redirectToRoute('contactus');
        }
        return $this->render('contact_us/contactus.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
