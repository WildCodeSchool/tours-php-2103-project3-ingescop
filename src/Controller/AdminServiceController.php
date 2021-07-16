<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
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
class AdminServiceController extends AbstractController
{
    /**
     * @Route("/service/new", name="newservice", methods={"GET","POST"})
     */
    public function newService(
        Request $request,
        FileUploaderService $uploadImage,
        EntityManagerInterface $entityManager
    ): Response {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageData = $form->get('image')->getData();
            if ($imageData !== null) {
                $newImageName = $uploadImage->upload($imageData);
                $service->setImage($newImageName);
            }
            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('succes', "La photo a bien été tranférée");
            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/service/new.html.twig', [
            'service' => $service,
            'formService' => $form->createView(),]);
    }

    /**
     * @Route("/service/edit/{id}", name="editservice", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function editService(
        Request $request,
        Service $service,
        EntityManagerInterface $entityManager,
        FileUploaderService $uploadImage
    ): Response {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageData = $form->get('image')->getData();
            $image = $service->getImage();
            if ($imageData !== null) {
                if ($image !== null) {
                    if (is_string($this->getParameter('images_directory'))) {
                        $imageName = $this->getParameter('images_directory') . '/' . $service->getImage();
                        unlink($imageName);
                    }
                }
                $newImageName = $uploadImage->upload($imageData);
                $service->setImage($newImageName);
            }
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('admin_panelconfig');
        }
        return $this->render('admin/service/edit.html.twig', [
            'service' => $service,
            'formService' => $form->createView(),]);
    }

    /**
     * @Route("/service/delete/{id}", name="deleteservice", methods={"POST"}, requirements={"id": "\d+"})
     */
    public function deletePro(
        Request $request,
        Service $service,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $imageName = $service->getImage();
            if ($imageName !== null) {
                if (is_string($this->getParameter('images_directory'))) {
                    $imagePath = $this->getParameter('images_directory') . '/' . $imageName;
                    unlink($imagePath);
                }
            }
            $entityManager->remove($service);
            $entityManager->flush();
            $this->addFlash("Valid", 'Le service a bien été supprimé !');
        }
        return $this->redirectToRoute('admin_panelconfig');
    }
}
