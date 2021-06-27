<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\ImagesProjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;

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
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('photoOne')->getData();
            $imageFile2 = $form->get('photoTwo')->getData();
            $imageFile3 = $form->get('photoThree')->getData();
            $imageArray = [$imageFile, $imageFile2, $imageFile3];
            $uploadService->upload($imageArray, $sluggerInterface, $project);
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
            $photoOne = $project->getPhotoOne();
            $photoTwo = $project->getPhotoTwo();
            $photoThree = $project->getPhotoThree();
            $photos = [];
            $photos = [$photoOne, $photoTwo, $photoThree];
            $uploadService->delete($photos);
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('photoOne')->getData();
            $imageFile2 = $form->get('photoTwo')->getData();
            $imageFile3 = $form->get('photoThree')->getData();
            $imageArray = [$imageFile, $imageFile2, $imageFile3];
            $uploadService->upload($imageArray, $sluggerInterface, $project);
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
        EntityManagerInterface $entityManager,
        ImagesProjectService $uploadService
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $photoOne = $project->getPhotoOne();
            $photoTwo = $project->getPhotoTwo();
            $photoThree = $project->getPhotoThree();
            $photos = [];
            $photos = [$photoOne, $photoTwo, $photoThree];
            $uploadService->delete($photos);
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_panelconfig');
    }
}
