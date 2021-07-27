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
     * function to contact the admin
     * @Route("/contact/us", name="contactus")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new ContactData();
        $form = $this->createForm(ContactUsType::class, $contact);
        $form->handleRequest($request);
        $adminEmail = $this->getParameter('app.admin_email');

        if ($form->isSubmitted() && $form->isValid() && is_string($adminEmail)) {
            $message = (new Email())
                ->from($contact->getEmailAddress())
                ->to($adminEmail)
                ->subject('Vous avez reçu un nouveau mail')
                ->text($contact->getMessage() . PHP_EOL . PHP_EOL . 'Envoyé par : ' . PHP_EOL .
                 $contact->getLastName() . PHP_EOL .
                 $contact->getFirstName() . PHP_EOL .
                 $contact->getPhoneNumber() . PHP_EOL .
                 $contact->getEmailAddress(), 'text/plain');
                 $mailer->send($message);

                 $this->addFlash("Success", ' Votre message à été envoyé avec succès !');
                 return $this->redirectToRoute('contactus');
        }
        return $this->render('contact_us/contactus.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
