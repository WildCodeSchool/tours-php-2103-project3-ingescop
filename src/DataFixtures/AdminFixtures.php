<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $passworddEncoder;

    public function __construct(UserPasswordEncoderInterface $passworddEncoder)
    {
        $this->passworddEncoder = $passworddEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setUsername('admin')
        ->setRoles(["ROLE_ADMIN"])
        ->setPassword($this->passworddEncoder->encodePassword(
            $admin,
            '\$argon2id\$v=19\$m=65536,t=4,p=1\$BQG+jovPcunctc30xG5PxQ\$TiGbx451NKdo+g9vLtfkMy4KjASKSOcnNxjij4gTX1s'
        ));
        $manager->persist($admin);
        $manager->flush();
    }
}
