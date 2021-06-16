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
        $professionnal->setName('Alice PERROTE')
            ->setJob('');
        $manager->persist($professionnal);

        $professionnal1 = new Professionnal();
        $professionnal1->setName('Robert BORIA')
            ->setJob('');
        $manager->persist($professionnal1);

        $professionnal2 = new Professionnal();
        $professionnal2->setName('Patrick GARREAU')
            ->setJob('');
        $manager->persist($professionnal2);

        $professionnal3 = new Professionnal();
        $professionnal3->setName('Sandra GERART')
            ->setJob('');
        $manager->persist($professionnal3);

        $professionnal4 = new Professionnal();
        $professionnal4->setName('Etienne')
            ->setJob('');
        $manager->persist($professionnal4);

        $professionnal5 = new Professionnal();
        $professionnal5->setName('Louis')
            ->setJob('');
        $manager->persist($professionnal5);

        $professionnal6 = new Professionnal();
        $professionnal6->setName('Jean-Claude LEMMEL')
            ->setJob('');
        $manager->persist($professionnal6);

        $professionnal7 = new Professionnal();
        $professionnal7->setName('Stéphane GRIFFE')
            ->setJob('');
        $manager->persist($professionnal7);

        $manager->flush();
    }
}
