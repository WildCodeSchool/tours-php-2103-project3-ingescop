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
     * @Assert\NotBlank(message="Vous devez choisir un nom")
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le service saisie {{ value }} contient trop de charactères, {{ limit }} au maximum"
     * )
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private string $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
