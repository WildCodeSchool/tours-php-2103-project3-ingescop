<?php

namespace App\FormData;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Routing\Annotation\Route;

class PasswordData
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Mauvais mot de passe"
     * )
     */
    protected string $oldPassword;

    /**
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre nouveau mot de passe doit comporter au minimum {{ limit }} caractères"
     * )
     */
    protected string $password;

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}
