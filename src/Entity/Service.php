<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $category;

    /**
     * @ORM\ManyToMany(targetEntity=Professionnal::class, inversedBy="service")
     */
    private Collection $professionnal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $image;

    public function __construct()
    {
        $this->professionnal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Professionnal[]
     */
    public function getProfessionnal(): Collection
    {
        return $this->professionnal;
    }

    public function addProfessionnal(Professionnal $professionnal): self
    {
        if (!$this->professionnal->contains($professionnal)) {
            $this->professionnal[] = $professionnal;
        }

        return $this;
    }

    public function removeProfessionnal(Professionnal $professionnal): self
    {
        $this->professionnal->removeElement($professionnal);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
