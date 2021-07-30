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
     * in this method, i create a form for contact the admin.
     * @Route("/contactpro", name="contactpro")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactData();
        $form = $this->createForm(ContactDataType::class, $data);
        $form->handleRequest($request);
        // the admin email is in service.yaml
        $adminEmail = $this->getParameter('app.admin_email');


        if ($form->isSubmitted() && $form->isValid() && is_string($adminEmail)) {
            $message = (new Email())
                ->from($data->getEmailAddress())
                ->to($adminEmail)
                ->subject('Vous avez reçu un nouveau mail de ' . $data->getLastName() . ' ' . $data->getFirstName())
                ->text($data->getMessage() . PHP_EOL . PHP_EOL . "Envoyez par : " . PHP_EOL . $data->getLastName() .
                 PHP_EOL . $data->getFirstName() . PHP_EOL . $data->getPhoneNumber() . PHP_EOL .
                  $data->getEmailAddress() . PHP_EOL, 'text/plain');
                $mailer->send($message);

                 $this->addFlash("Success", 'Votre message a été envoyé avec succès !');
                 return $this->redirectToRoute('contactpro');
        }
        return $this->render('contact/contactpro.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
