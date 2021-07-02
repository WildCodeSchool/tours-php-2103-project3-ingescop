<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Repository\ProfessionnalRepository;
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
     * @Route("/", name="panelconfig", methods={"GET"})
     */
    public function list(
        ProjectRepository $projectRepository,
        ProfessionnalRepository $proRepository,
        ServiceRepository $serviceRepository
    ): Response {

        return $this->render('admin/panelconfig.html.twig', [
            'services' => $serviceRepository->findAll(),
            'projects' => $projectRepository->findAll(),
            'pro' => $proRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newpro", name="newpro", methods={"GET","POST"})
     */
    public function newProfessionnal(Request $request): Response
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
            'form' => $form->createView(),]);
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
     * @Route("/newproject", name="newproject", methods={"GET","POST"})
     */
    public function newProject(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute("admin_panelconfig");
        }

        return $this->render("admin/newservice.html.twig", [
            "project" => $project,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editpro", name="editpro", methods={"GET","POST"})
     */
    public function editProfessionnal(Request $request, Professionnal $pro): Response
    {
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/editprofessionnal.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),]);
    }

    /**
     * @Route("/{id}/editproject", name="editproject", methods={"GET","POST"})

     */
    public function editProject(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/edit_project.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
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

    /**
     * @Route("/{id}", name="deletepro", methods={"POST"})
     */
    public function deletePro(Request $request, Professionnal $pro): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pro);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_panelconfig');
    }

    /**
     * @Route("/{id}", name="deleteproject", methods={"POST"})
     */
    public function deleteProject(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_panelconfig');
    }
}
