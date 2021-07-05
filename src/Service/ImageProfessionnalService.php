<?php

namespace App\Service;

use App\Entity\Images;
use App\Entity\Professionnal;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ImageProfessionnalService
{
    private string $directory;
    private SluggerInterface $slugger;

    public function __construct(string $directory, SluggerInterface $slugger)
    {
        $this->directory = $directory;
        $this->slugger = $slugger;
    }

    public function upload(
        array $imageArray,
        Professionnal $pro
    ): void {
        for ($i = 0; $i < count($imageArray); $i++) {
            if ($imageArray[$i] !== null) {
                $originalFilename = pathinfo($imageArray[$i]->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageArray[$i]->guessExtension();
                try {
                    $imageArray[$i]->move(
                        $this->directory,
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new HttpException(
                        500,
                        "Les paramètres du répertoire d'images sont invalides,
                    contacter les administrateurs du site"
                    );
                }
                $pro->setProfilPhoto($newFilename);
            }
        }
    }

    public function edit(
        array $imageArray,
        Professionnal $pro
    ): void {
        $image = $pro->getProfilPhoto();
        if ($image !== null) {
            if (is_string($this->getDirectory())) {
                $imageName = $this->getDirectory() . '/' . $pro->getProfilPhoto();
                unlink($imageName);
            }
        }
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }
}
