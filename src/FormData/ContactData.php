<?php

declare(strict_types=1);

namespace App\FormData;

use Symfony\Component\Validator\Constraints as Assert;

class ContactData
{
    /**
     * @Assert\NotBlank
     */
    private string $firstName;

    /**
     * @Assert\NotBlank
     */
    private string $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      max = 13,
     *      minMessage = "Votre numéro de téléphone {{ value }} est trop court, minimum {{ limit }} chiffres.",
     *      maxMessage = "Votre numéro de téléphone {{ value }} est trop long, maximum {{ limit }} chiffres."
     * )
     */
    private string $phoneNumber;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    private string $emailAddress;

    /**
     * @Assert\NotBlank
     */
    private string $message;


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }
}
