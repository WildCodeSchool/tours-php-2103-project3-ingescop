<?php

namespace App\Service;

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
        SluggerInterface $sluggerInterface
    ): array {
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
        return $this->outputArray;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }
}
