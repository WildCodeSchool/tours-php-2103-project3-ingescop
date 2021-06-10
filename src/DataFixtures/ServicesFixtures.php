<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServicesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $serviceMetier = new Service();
        $serviceMetier->setName('Programmation')
            ->setCategory('AMO');
        $manager->persist($serviceMetier);

        $serviceMetier1 = new Service();
        $serviceMetier1->setName('Montage de projets')
            ->setCategory('AMO');
        $manager->persist($serviceMetier1);

        $serviceMetier2 = new Service();
        $serviceMetier2->setName('Conseil juridico-financier')
            ->setCategory('AMO');
        $manager->persist($serviceMetier2);

        $serviceMetier3 = new Service();
        $serviceMetier3->setName('Gestion du patrimoine bâti')
            ->setCategory('AMO');
        $manager->persist($serviceMetier3);

        $serviceMetier4 = new Service();
        $serviceMetier4->setName('Ingénieurs')
            ->setCategory('MOE');
        $manager->persist($serviceMetier4);

        $serviceMetier5 = new Service();
        $serviceMetier5->setName('Architecture')
            ->setCategory('MOE');
        $manager->persist($serviceMetier5);

        $serviceMetier6 = new Service();
        $serviceMetier6->setName('Paysagisme')
            ->setCategory('MOE');
        $manager->persist($serviceMetier6);

        $serviceMetier7 = new Service();
        $serviceMetier7->setName('Économistes')
            ->setCategory('MOE');
        $manager->persist($serviceMetier7);

        $serviceMetier8 = new Service();
        $serviceMetier8->setName('Formateurs')
            ->setCategory('Conseil');
        $manager->persist($serviceMetier8);

        $serviceMetier9 = new Service();
        $serviceMetier9->setName('Animateurs Pédagogiques')
            ->setCategory('Conseil');
        $manager->persist($serviceMetier9);

        $serviceMetier10 = new Service();
        $serviceMetier10->setName('Stage transdisciplinaire')
            ->setCategory('Conseil');
        $manager->persist($serviceMetier10);

        $serviceMetier11 = new Service();
        $serviceMetier11->setName('Parrainage')
            ->setCategory('Conseil');
        $manager->persist($serviceMetier11);

        $manager->flush();
    }
}
