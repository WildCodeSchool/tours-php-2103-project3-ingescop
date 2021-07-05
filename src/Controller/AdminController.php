<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Service;
use App\Form\ProjectType;
use App\Form\ServiceType;
use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Repository\ProjectRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/pro/new", name="newpro", methods={"GET","POST"})
     */
    public function newProfessionnal(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pro = new Professionnal();
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pro);
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/newprofessionnal.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),]);
    }

    /**
     * @Route("/service/new", name="newservice", methods={"GET","POST"})
     */
    public function newService(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/project/new", name="newproject", methods={"GET","POST"})
     */
    public function newProject(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/pro/edit/{id}", name="editpro", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function editProfessionnal(Request $request, Professionnal $pro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/editprofessionnal.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),]);
    }

    /**
     * @Route("/project/edit/{id}", name="editproject", methods={"GET","POST"}, requirements={"id": "\d+"})

     */
    public function editProject(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/edit_project.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/service/edit/{id}", name="editservice", methods={"GET","POST"}, requirements={"id": "\d+"})
    */
    public function editService(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/editservice.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/service/delete/{id}", name="deleteservice", methods={"POST"}, requirements={"id": "\d+"})
     */
    public function deleteService(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid("delete" . $service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute("admin_panelconfig");
    }

    /**
     * @Route("/pro/delete/{id}", name="deletepro", methods={"POST"}, requirements={"id": "\d+"})
     */
    public function deletePro(Request $request, Professionnal $pro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pro->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pro);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_panelconfig');
    }

    /**
     * @Route("/project/delete/{id}", name="deleteproject", methods={"POST"}, requirements={"id": "\d+"})
     */
    public function deleteProject(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            
            $entityManager->remove($project);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_panelconfig');
    }
}
