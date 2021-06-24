<?php

namespace App\Controller;

use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Repository\ProfessionnalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin", name="admin_")
*/
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="panelconfig")
     */
    public function listPro(ProfessionnalRepository $proRepository): Response
    {
        return $this->render('admin/panelconfig.html.twig', [
            'pro' => $proRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newpro", name="newpro", methods={"GET","POST"})
     */
    public function newprofessionnal(Request $request): Response
    {
        $pro = new Professionnal();
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pro);
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/newprofessionnal.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editpro", name="editpro", methods={"GET","POST"})
     */
    public function editprofessionnal(Request $request, Professionnal $pro): Response
    {
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/editprofessionnal.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="deletepro", methods={"POST"})
     */
    public function deleteProject(Request $request, Professionnal $pro): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_panelconfig');
    }
}
