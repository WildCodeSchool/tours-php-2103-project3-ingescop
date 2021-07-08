<?php

namespace App\FormData;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Routing\Annotation\Route;

class PasswordData
{
    protected string $oldPassword;
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
