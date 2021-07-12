<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileUploaderService
{
    private string $directory;
    private SluggerInterface $slugger;

    public function __construct(string $directory, SluggerInterface $slugger)
    {
        $this->directory = $directory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $imageData): string
    {
        if ($imageData !== null) {
            $originalFilename = pathinfo($imageData->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageData->guessExtension();
            try {
                $imageData->move(
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
            return $newFilename;
        }
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }
}
