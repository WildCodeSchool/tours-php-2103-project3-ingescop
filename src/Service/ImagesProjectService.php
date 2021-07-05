<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\Images;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\File\File;

class ImagesProjectService
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
        Project $project
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
                if ($i === 0) {
                    $project->setMainPhoto($newFilename);
                } elseif ($i > 0) {
                    $img = new Images();
                    $img->setName($newFilename);
                    $project->addImage($img);
                }
            }
        }
    }

    public function edit(
        array $imageArray,
        Project $project
    ): void {
        $images = $project->getImages();
        $arrImgs = [];
        foreach ($images as $image) {
            $arrImgs[] = $image;
        }
        for ($i = 0; $i < count($imageArray); $i++) {
            if ($imageArray[$i] !== null) {
                if ($i === 0) {
                    if (is_string($this->getDirectory())) {
                        $imageName = $this->getDirectory() . '/' . $project->getMainPhoto();
                        unlink($imageName);
                    }
                }
            }
        }
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }
}
