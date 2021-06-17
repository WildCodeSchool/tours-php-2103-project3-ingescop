<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $project = new Project();
        $project->setName('Restauration et construction, Ferme de Cément, Chinon')
                ->setNote(3)
                /*->setEntryDate(2019/05/24)*/
                ->setPlace('Ferme de Cément, Chinon (37)')
                ->setClient('FBH Invest')
                ->setMissionIngescop('Maitrise d’oeuvre structure bois, pierre
                , béton, Ordonancement Pilotage Coordination (OPC)')
                ->setBudget('1,6M€HT')
                ->setCalendar('#études2019-2020 #livraison2021')
                ->setWorkInProgress('Livré')
                ->setResume('Le projet confié à l’Architecte du patrimoine 
                Atelier 27, prévoit la rénovation soignée d’un ensemble de 
                bâtiments en pierre de Tuffeau; et la construction de 
                nouveaux bâtiments pour les besoins agricoles: hangar, 
                bâtiments techniques à ossature bois en charpente traditionnelle
                . Les matériaux sont choisis dans des panels locaux, avec 
                notamment 100% d’isolants biosourcés pour les locaux chauffés 
                (liège, laine de bois, chaux-chanvre).')
                ->setStrongPoints('#ossature bois/#isolants biosourcés : liège, chanvre, laine de bois
                /#projection chaux-chanvre/#dallages à la chaux
                /#murs de soutènement poids en pierre de Tuffeau/#bardage châtaigner
                /#matériaux locaux #réemploi de pierres issues des déconstructions')
                ->setPhotoOne('build/images/cement.jpg')
                ->setPhotoTwo('build/images/Cement-chantier.jpg')
                ->setPhotoThree('build/images/Cement-chantier2.jpg');
        $manager->persist($project);

        $project1 = new Project();
        $project1->setName('Transformation d’un bâtiment en gîte d’accueil, Candes St Martin')
                ->setNote(5)
                ->setPlace('Route de Compostelle, Candes Saint Martin (37)')
                ->setClient('privé')
                ->setMissionIngescop('diagnostic technique global (DTG)')
                ->setBudget('nc')
                ->setCalendar('#études2019 #livraison2020')
                ->setWorkInProgress('En travaux')
                ->setResume('Le projet prévoit l’aménagement d’un gîte ouvert 
                au public, à l’étage d’une maison de maitre en Tuffeau.')
                ->setStrongPoints('#gîte/#chaudière à granulés bois/#isolants biosourcés
                /#copropriété#site remarquable')
                ->setPhotoOne('build/images/candes-st-martin2.jpg');
        $manager->persist($project1);

        $project2 = new Project();
        $project2->setName('Transformation de bureaux en 68 logements et crèche, Paris 18e')
                ->setNote(2)
                ->setPlace('Rue Coustou, Paris 18e')
                ->setClient('Elogie Siemp')
                ->setMissionIngescop('étude structure')
                ->setBudget('11M€ HT')
                ->setCalendar('#études 2019-2021 #livraison 2023')
                ->setWorkInProgress('En études')
                ->setResume('Le projet prévoit de transformer un bâtiment de 
                bureaux, construit en plusieurs étapes au cours du XXe 
                siècle. La nature des existants est assez hétéroclite, 
                présentant des parois en briques, en éléments préfabriqués 
                en béton armé, en parpaings de ciment. Au pied de la butte 
                Montmartre, Elogie Siemp prévoit de réaliser des logements 
                sociaux et une crèche, avec une ambition environnementale 
                très forte, dans le respect et même au delà des exigences 
                du Plan Climat Air Energie de la Ville de Paris.')
                ->setStrongPoints('#habitat partagé/#ossature bois/#isolant biosourcé
                /#ventilation double flux/#locaux communs partagés')
                ->setPhotoOne('build/images/Paris.jpg');
        $manager->persist($project2);

        $project3 = new Project();
        $project3->setName('Construction de 8 logements participatifs, La Riche')
                ->setNote(4)
                ->setPlace('zac du Plessis Botanique, La Riche (37)')
                ->setClient('Les tisserins')
                ->setMissionIngescop('étude structure')
                ->setBudget('nc')
                ->setCalendar('#études2019-2020 #livraison2022')
                ->setWorkInProgress('En travaux')
                ->setResume('Le projet prévoit la construction d’un immeuble 
                collectif, d’habitat participatif, par la commande d’un 
                groupement d’habitants sur la commune de La Riche. La 
                structure du bâtiment est constituée d’un socle rigide en 
                béton armé, composé du RdC et du noyau dur que forment 
                l’escalier et la cage d’ascenseur. Sur ce socle, est posée 
                la structure à ossature bois des étages.')
                ->setStrongPoints('#géothermie sur nappe#planchers chauffants
                /#réemploi de matériaux/#surélévation en ossature bois
                /#isolants biosourcés/#puit canadien/#récupération de calories sur eaux grises')
                ->setPhotoOne('build/images/la-riche2.jpg')
                ->setPhotoTwo('build/images/Paris.jpg');
        $manager->persist($project3);

        $manager->flush();
    }
}
