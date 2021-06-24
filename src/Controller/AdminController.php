<?php

namespace App\Controller;

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
    public function listProject(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/panelconfig.html.twig', [
            'projects' => $projectRepository->findAll(),
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

    /**
     * @Route("show/{id}", methods={"GET"}, name="show")
     */
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        $reference = $projectRepository->findOneById($id);
        $strongPoints = $reference->getStrongPoints();
        $strongPoints = explode('/', $strongPoints);
        array_shift($strongPoints);
        return $this->render('reference/show.html.twig', [
            'reference' => $reference,
            'strongPoints' => $strongPoints
        ]);
    }
}
