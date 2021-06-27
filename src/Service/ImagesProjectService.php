<?php

namespace App\Service;

use App\Entity\Project;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
                $this->outputArray[] = $newFilename;
            }
        }
        for ($i = 0; $i < count($this->outputArray); $i++) {
            if ($i === 0) {
                $project->setPhotoOne($this->outputArray[$i]);
            } elseif ($i === 1) {
                $project->setPhotoTwo($this->outputArray[$i]);
            } else {
                $project->setPhotoThree($this->outputArray[$i]);
            }
        }
    }

    public function delete(array $photos): void
    {
        for ($i = 0; $i < count($photos); $i++) {
            if ($photos[$i] != null) {
                $photoName = $this->getDirectory() . '/' . $photos[$i];
                unlink($photoName);
            }
        }
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }
}
