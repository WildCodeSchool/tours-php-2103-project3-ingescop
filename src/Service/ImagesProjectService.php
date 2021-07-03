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
    private array $outputArray = [];
    private string $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function upload(
        array $imageArray,
        SluggerInterface $sluggerInterface,
        Project $project
    ): void {
        for ($i = 0; $i < count($imageArray); $i++) {
            if ($imageArray[$i] !== null) {
                $originalFilename = pathinfo($imageArray[$i]->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageArray[$i]->guessExtension();
                try {
                    $imageArray[$i]->move(
                        $this->getDirectory(),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new HttpException(
                        500,
                        "Les paramètres du répertoire d'images sont invalides,
                    contacter les administrateurs du site"
                    );
                } catch (ServiceNotFoundException $e) {
                    throw $e;
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
        SluggerInterface $sluggerInterface,
        Project $project
    ): void {
        for ($i = 0; $i < count($imageArray); $i++) {
            if ($imageArray[$i] !== null) {
                $originalFilename = pathinfo($imageArray[$i]->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageArray[$i]->guessExtension();
                try {
                    $imageArray[$i]->move(
                        $this->getDirectory(),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new HttpException(
                        500,
                        "Les paramètres du répertoire d'images sont invalides,
                    contacter les administrateurs du site"
                    );
                } catch (ServiceNotFoundException $e) {
                    throw $e;
                }
                $this->outputArray[] = $newFilename;
            }
        }
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }
}