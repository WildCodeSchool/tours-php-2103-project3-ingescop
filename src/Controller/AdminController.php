<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\Images;
use App\Repository\ProjectRepository;
use App\Service\ImagesProjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        $projects = $projectRepository->findAll();
        return $this->render('admin/panelconfig.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/newproject", name="newproject", methods={"GET","POST"})
     */
    public function newProject(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $sluggerInterface,
        ImagesProjectService $uploadService
    ): Response {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = [];
            $images[] = $form->get('mainPhoto')->getData();
            $othersImages = $form->get('images')->getData();
            for ($i = 0; $i < count($othersImages); $i++) {
                $images[] = $othersImages[$i];
            }
            $uploadService->upload($images, $sluggerInterface, $project);
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash('succes', "La photo a bien été tranférée");
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
    public function editProject(
        Request $request,
        Project $project,
        EntityManagerInterface $entityManager,
        ImagesProjectService $uploadService,
        SluggerInterface $sluggerInterface
    ): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

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
    public function deleteProject(
        Request $request,
        Project $project,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $mainPhoto = $project->getMainPhoto();
            if (is_string($this->getParameter('images_directory'))) {
                $imageName = $this->getParameter('images_directory') . '/' . $mainPhoto;
                unlink($imageName);
            }
            $images = $project->getImages();
            if ($images !== null) {
                foreach ($images as $image) {
                    if (is_string($this->getParameter('images_directory'))) {
                        $imageName = $this->getParameter('images_directory') . '/' . $image->getName();
                        unlink($imageName);
                    }
                }
            }
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_panelconfig');
    }

    /**
     * @Route("/delete/image/{id}", name="project_delete_image", methods={"DELETE"})
     */
    public function deleteImage(
        Images $image,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            $name = $image->getName();
            if (is_string($this->getParameter('images_directory'))) {
                unlink($this->getParameter('images_directory') . '/' . $name);
                $entityManager->remove($image);
                $entityManager->flush();
            }
            return new JsonResponse(['succes' => 1]);
        } else {
            return new JsonResponse(['error' => 'invalide token'], 400);
        }
    }
}
