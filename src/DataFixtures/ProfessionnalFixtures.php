<?php

namespace App\DataFixtures;

use App\Entity\Professionnal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfessionnalFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $professionnal = new Professionnal();
        $professionnal->setName('robert')
            ->setJob('ebeniste');
        $manager->persist($professionnal);

        $professionnal1 = new Professionnal();
        $professionnal1->setName('francois')
            ->setJob('architecte');
        $manager->persist($professionnal1);

        $professionnal2 = new Professionnal();
        $professionnal2->setName('albert')
            ->setJob('botaniste');
        $manager->persist($professionnal2);

        $professionnal3 = new Professionnal();
        $professionnal3->setName('tartenpion')
            ->setJob('charpentier');
        $manager->persist($professionnal3);
        $manager->flush();
    }
}
