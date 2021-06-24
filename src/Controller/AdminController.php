<?php

namespace App\Controller;


use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
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
     * @Route("/", name="panelconfig", methods={"GET","POST"})
    */
    public function listService(ServiceRepository $serviceRepository, ProjectRepository $projectRepository): Response
    {

        return $this->render('admin/panelconfig.html.twig', [
            'services' => $serviceRepository->findAll(),
            'projects' => $projectRepository->findAll(),

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

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/new_project.html.twig', [
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

     /**
     * @Route("/{id}/deleteproject", name="deleteproject", methods={"POST"})
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
