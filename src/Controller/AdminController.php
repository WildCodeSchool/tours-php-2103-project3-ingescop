<?php

namespace App\Controller;

use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Repository\ProfessionnalRepository;
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
use Symfony\Component\String\Slugger\SluggerInterface;

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
            $images = [];
            $images[] = $form->get('mainPhoto')->getData();
            $othersImages = $form->get('images')->getData();
            for ($i = 0; $i < count($othersImages); $i++) {
                $images[] = $othersImages[$i];
            }
            $uploadService->edit($images, $sluggerInterface, $project);
            $uploadService->upload($images, $sluggerInterface, $project);
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/edit_project.html.twig', [
            'project' => $project,
            'form' => $form->createView(),]);
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
}
