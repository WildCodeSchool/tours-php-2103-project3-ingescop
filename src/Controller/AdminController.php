<?php

namespace App\Controller;

use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Repository\ProfessionnalRepository;
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
     * @Route("/", name="panelconfig", methods={"GET"})
     */
    public function list(ProjectRepository $projectRepository, ProfessionnalRepository $proRepository): Response
    {
        return $this->render('admin/panelconfig.html.twig', [
            'projects' => $projectRepository->findAll(),
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
            'form' => $form->createView(),]);
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
            'form' => $form->createView(),]);
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
