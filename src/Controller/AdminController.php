<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        SluggerInterface $sluggerInterface
    ): Response {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $directory = $this->getParameter('images_directory');
                    if (is_string($directory)) {
                        $imageFile->move(
                            $directory,
                            $newFilename
                        );
                    } else {
                        throw new HttpException(
                            500,
                            "Les paramètres du répertoire d'images sont invalides,
                        contacter les administrateurs du site"
                        );
                    }
                } catch (FileException $e) {
                    return $this->render('admin/new_project.html.twig', [
                        'form' => $form->createView(),
                        'error' => 'Une erreur a eu lieu lor de l\'upload du fichier, veuillez rééssayer'
                    ]);
                } catch (ServiceNotFoundException $e) {
                    throw $e;
                }
                $project->setPhotoOne($newFilename);
            }
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
}
