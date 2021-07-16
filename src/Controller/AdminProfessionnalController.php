<?php

namespace App\Controller;

use App\Entity\Professionnal;
use App\Form\ProfessionnalType;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminProfessionnalController extends AbstractController
{
    /**
     * @Route("/pro/new", name="newpro", methods={"GET","POST"})
     */
    public function newprofessionnal(
        Request $request,
        FileUploaderService $uploadProfessionnal,
        EntityManagerInterface $entityManager
    ): Response {
        $pro = new Professionnal();
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageData = $form->get('profilPhoto')->getData();
            if ($imageData !== null) {
                $newImageName = $uploadProfessionnal->upload($imageData);
                $pro->setProfilPhoto($newImageName);
            }
            $entityManager->persist($pro);
            $entityManager->flush();

            $this->addFlash('succes', "La photo a bien été tranférée");
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/professionnal/new.html.twig', [
            'pro' => $pro,
            'formPro' => $form->createView(),]);
    }

    /**
     * @Route("/pro/edit/{id}", name="editpro", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function editprofessionnal(
        Request $request,
        Professionnal $pro,
        EntityManagerInterface $entityManager,
        FileUploaderService $uploadProfessionnal
    ): Response {
        $form = $this->createForm(ProfessionnalType::class, $pro);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageData = $form->get('profilPhoto')->getData();
            $image = $pro->getProfilPhoto();
            if ($imageData !== null) {
                if ($image !== null) {
                    if (is_string($this->getParameter('images_directory'))) {
                        $imageName = $this->getParameter('images_directory') . '/' . $pro->getProfilPhoto();
                        unlink($imageName);
                    }
                }
                $newImageName = $uploadProfessionnal->upload($imageData);
                $pro->setProfilPhoto($newImageName);
            }
            $entityManager->persist($pro);
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/professionnal/edit.html.twig', [
            'pro' => $pro,
            'formPro' => $form->createView(),]);
    }

    /**
     * @Route("/pro/delete/{id}", name="deletepro", methods={"POST"}, requirements={"id": "\d+"})
     */
    public function deletePro(
        Request $request,
        Professionnal $pro,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $pro->getId(), $request->request->get('_token'))) {
            $profilPhoto = $pro->getProfilPhoto();
            if ($profilPhoto !== null) {
                if (is_string($this->getParameter('images_directory'))) {
                    $imageName = $this->getParameter('images_directory') . '/' . $profilPhoto;
                    unlink($imageName);
                }
            }
            $entityManager->remove($pro);
            $entityManager->flush();
            $this->addFlash("Valid", 'Le professionnel a bien été supprimé !');
        }
        return $this->redirectToRoute('admin_panelconfig');
    }
}
