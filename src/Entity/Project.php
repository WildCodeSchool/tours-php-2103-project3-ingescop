<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $entryDate;

    /**
     * @ORM\Column(type="integer")
     */
    private int $note;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Professionnal", inversedBy="projects")
     */
    private Collection $owner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $place;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $missionIngescop;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $budget;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $calendar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $workInProgress;

    /**
     * @ORM\Column(type="text")
     */
    private string $resume;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $photoOne;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $strongPoints;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $photoTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $photoThree;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
        $this->entryDate = new DateTime('now');
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

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection|Professionnal[]
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Professionnal $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
        }

        return $this;
    }

    public function removeOwner(Professionnal $owner): self
    {
        $this->owner->removeElement($owner);

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getMissionIngescop(): ?string
    {
        return $this->missionIngescop;
    }

    public function setMissionIngescop(string $missionIngescop): self
    {
        $this->missionIngescop = $missionIngescop;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getCalendar(): ?string
    {
        return $this->calendar;
    }

    public function setCalendar(string $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    public function getWorkInProgress(): ?string
    {
        return $this->workInProgress;
    }

    public function setWorkInProgress(string $workInProgress): self
    {
        $this->workInProgress = $workInProgress;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPhotoOne(): string
    {
        return $this->photoOne;
    }

    public function setPhotoOne(string $photoOne): self
    {
        $this->photoOne = $photoOne;

        return $this;
    }

    public function getStrongPoints(): string
    {
        return $this->strongPoints;
    }

    public function setStrongPoints(string $strongPoints): self
    {
        $this->strongPoints = $strongPoints;

        return $this;
    }

    public function getPhotoTwo(): ?string
    {
        return $this->photoTwo;
    }

    public function setPhotoTwo(string $photoTwo): self
    {
        $this->photoTwo = $photoTwo;

        return $this;
    }

    public function getPhotoThree(): ?string
    {
        return $this->photoThree;
    }

    public function setPhotoThree(string $photoThree): self
    {
        $this->photoThree = $photoThree;

        return $this;
    }
}
