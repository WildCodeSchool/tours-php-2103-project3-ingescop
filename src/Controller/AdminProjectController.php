<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Entity\Images;
use App\Service\ImagesProjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin", name="admin_")
 */

class AdminProjectController extends AbstractController
{
    /**
     * @Route("/project/new", name="newproject", methods={"GET","POST"})
     */
    public function newProject(
        Request $request,
        EntityManagerInterface $entityManager,
        ImagesProjectService $uploadService
    ): Response {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = [];
            $images[] = $form->get('mainPhoto')->getData();
            foreach ($form->get('images')->getData() as $picture) {
                $images[] = $picture;
            }
            $uploadService->upload($images, $project);
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash('succes', "La photo a bien été tranférée");
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/edit/{id}", name="editproject", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function editProject(
        Request $request,
        Project $project,
        EntityManagerInterface $entityManager,
        ImagesProjectService $uploadService
    ): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = [];
            $images[] = $form->get('mainPhoto')->getData();
            foreach ($form->get('images')->getData() as $picture) {
                $images[] = $picture;
            }
            $uploadService->edit($images, $project);
            $uploadService->upload($images, $project);
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),]);
    }

    /**
     * @Route("/project/delete/{id}", name="deleteproject", methods={"POST"}, requirements={"id": "\d+"})
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
            $this->addFlash("Valid", 'Le projet a bien été supprimé !');
        }

        return $this->redirectToRoute('admin_panelconfig');
    }

    /**
     * @Route("/project/{project_id}/delete/image/{image_id}", name="delete_project_image")
     * @ParamConverter("project", class="App\Entity\Project",
     * options={"mapping": {"project_id": "id"}}
     * )
     * @ParamConverter(
     * "image", class="App\Entity\Images",
     * options={"mapping": {"image_id": "id"}}
     * )
     */
    public function deleteImageProject(
        Request $request,
        Project $project,
        Images $image,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $deleteImg = $image->getName();
            if (is_string($this->getParameter('images_directory'))) {
                $imageName = $this->getParameter('images_directory') . '/' . $deleteImg;
                unlink($imageName);
            }
            $entityManager->remove($image);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_editproject', ['id' => $project->getId()]);
    }
}
