<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Vous devez choisir un nom")
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le projet saisie {{ value }} contient trop de charactères, {{ limit }} au maximum"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $entryDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "Vous devez entrez une note comprise entre {{ min }} et {{ max }}"
     * )
     */
    private int $note;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Professionnal", inversedBy="projects")
     */
    private Collection $owner;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez rentrer le lieu où le projet de
     * rénovation a été réalisé, dans le champs ('lieu')")
     * @Assert\Length(max="255", maxMessage="Le lieu saisie (champ 'place') {{ value }} contient trop
     * de charactères, vous devez en rentrez {{ limit }} au maximum")
     */
    private string $place;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez rentrer le client pour qui le
     * projet a été réalisé, dans le champ ('lieu')")
     * @Assert\Length(max="255", maxMessage="Le nom de client  saisie
     * (champ 'client') {{ value }} contient trop
     * de charactères, vous devez en rentrez {{ limit }} au maximum")
     */
    private string $client;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez rentrer une description de la mission
     * ingéscop éffectuée, dans le champ ('Mission ingéscop')")
     * @Assert\Length(max="255", maxMessage="Le descriptif de la mission ingéscope  saisie
     * (champ 'Mission ingéscope') {{ value }} contient trop
     * de charactères, vous devez en rentrez {{ limit }} au maximum")
     */
    private string $missionIngescop;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Vous devez rentrer le budget, dans le champ ('budget')")
     * @Assert\Length(max="255", maxMessage="Le budget  saisie
     * (champ 'budget') {{ value }} contient trop
     * de charactères, vous devez en rentrez {{ limit }} au maximum")
     */
    private string $budget;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Vous devez rentrer les dates de dédut et de fin, dans le champ ('Calendar')")
     * @Assert\Length(max="255", maxMessage="Le calendrier  saisie
     * (champ 'Calendar') {{ value }} contient trop
     * de charactères, vous devez en rentrez {{ limit }} au maximum")
     */
    private string $calendar;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez rentrer l'état actuel du projet', dans le
     * champ ('Work in progress'), vous avez le choix entre 'En études', 'En travaux' et 'Livré'")
     */
    private string $workInProgress;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez rentrer un résumé descriptif du projet, dans le champ ('Resume)")
     */
    private string $resume;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $photoOne;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
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

    public function getPhotoOne(): ?string
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
