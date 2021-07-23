<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Form\PartnerEditType;
use App\Repository\PartnerRepository;
use App\Entity\Images;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminPartnerController extends AbstractController
{
    /**
     * @Route("/partner/new", name="partner_new", methods={"GET","POST"})
     */
    public function newPartner(
        Request $request,
        EntityManagerInterface $entityManager,
        FileUploaderService $uploaderFile
    ): Response {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageData = $form->get('logo')->getData();
            if ($imageData !== null) {
                $newImageName = $uploaderFile->upload($imageData);
                $partner->setLogo($newImageName);
            }
            $entityManager->persist($partner);
            $entityManager->flush();
            $this->addFlash('succes', "La photo a bien été tranférée");
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/partner/new.html.twig', [
            'partner' => $partner,
            'formPartner' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partner/edit/{id}", name="partner_edit", methods={"GET","POST"})
     */
    public function editPartner(
        Request $request,
        Partner $partner,
        EntityManagerInterface $entityManager,
        FileUploaderService $fileUploaderService
    ): Response {
        $image = $partner->getLogo();
        $form = $this->createForm(PartnerEditType::class, $partner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageData = $form->get('logo')->getData();
            if ($imageData !== null) {
                if ($image !== null) {
                    if (is_string($this->getParameter('images_directory'))) {
                        $imageName = $this->getParameter('images_directory') . '/' . $image;
                        unlink($imageName);
                    }
                }
                $newImageName = $fileUploaderService->upload($imageData);
                $partner->setLogo($newImageName);
            }
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }

        return $this->render('admin/partner/edit.html.twig', [
            'partner' => $partner,
            'formPartner' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partner/delete/{id}", name="partner_delete", methods={"POST"})
     */
    public function deletePartner(
        Request $request,
        Partner $partner,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $partner->getId(), $request->request->get('_token'))) {
            $image = $partner->getLogo();
            if (is_string($this->getParameter('images_directory'))) {
                $imageName = $this->getParameter('images_directory') . '/' . $image;
                unlink($imageName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();
            $this->addFlash("Valid", 'Le partenaire a bien été supprimé !');
        }

        return $this->redirectToRoute('admin_panelconfig');
    }
}
