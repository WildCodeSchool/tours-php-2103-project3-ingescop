<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="panelconfig", methods={"GET","POST"})
    */
    public function listService(ServiceRepository $serviceRepository): Response
    {

        return $this->render('admin/panelconfig.html.twig', [
            'services' => $serviceRepository->findAll(),

        ]);
    }
    /**
     * @Route("/newservice", name="newservice", methods={"GET","POST"})
     */
    public function newService(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute("admin_panelconfig");
        }

        return $this->render("admin/newservice.html.twig", [
            "service" => $service,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editservice", methods={"GET","POST"})
     */
    public function editService(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/editservice.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="deleteservice", methods={"POST"})
     */
    public function deleteService(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid("delete" . $service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute("admin_panelconfig");
    }
}
