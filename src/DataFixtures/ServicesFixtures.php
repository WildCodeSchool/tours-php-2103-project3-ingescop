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
        $service = new Service();
        $service->setName('Programmation')
            ->setCategory('AMO')
            ->setImage('');
        $manager->persist($service);

        $service1 = new Service();
        $service1->setName('Montage de projets')
            ->setCategory('AMO')
            ->setImage('');
        $manager->persist($service1);

        $service2 = new Service();
        $service2->setName('Conseil juridico-financier')
            ->setCategory('AMO')
            ->setImage('');
        $manager->persist($service2);

        $service3 = new Service();
        $service3->setName('Gestion du patrimoine bâti')
            ->setCategory('AMO')
            ->setImage('');
        $manager->persist($service3);

        $service4 = new Service();
        $service4->setName('Ingénieurs')
            ->setCategory('MOE')
            ->setImage('');
        $manager->persist($service4);

        $service5 = new Service();
        $service5->setName('Architecture')
            ->setCategory('MOE')
            ->setImage('');
        $manager->persist($service5);

        $service6 = new Service();
        $service6->setName('Paysagisme')
            ->setCategory('MOE')
            ->setImage('');
        $manager->persist($service6);

        $service7 = new Service();
        $service7->setName('Économistes')
            ->setCategory('MOE')
            ->setImage('');
        $manager->persist($service7);

        $service8 = new Service();
        $service8->setName('Formateurs')
            ->setCategory('Conseil')
            ->setImage('');
        $manager->persist($service8);

        $service9 = new Service();
        $service9->setName('Animateurs Pédagogiques')
            ->setCategory('Conseil')
            ->setImage('');
        $manager->persist($service9);

        $service10 = new Service();
        $service10->setName('Stage transdisciplinaire')
            ->setCategory('Conseil')
            ->setImage('');
        $manager->persist($service10);

        $service11 = new Service();
        $service11->setName('Parrainage')
            ->setCategory('Conseil')
            ->setImage('');
        $manager->persist($service11);

        $manager->flush();
    }
}
