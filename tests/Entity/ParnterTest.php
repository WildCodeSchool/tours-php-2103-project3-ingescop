<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Partner;

final class PartnerTest extends TestCase
{
    public function testPartnerName(): void
    {
        $partner = new Partner();
        $partner->setName('Sacré couscous !');
        $this->assertEquals($partner->getName(), 'Sacré couscous !');

        $partner->setName('Ouplaboom');
        $this->assertEquals($partner->getName(), 'Ouplaboom');

        $partner->setName('Nous testons avec php unit');
        $this->assertEquals($partner->getName(), 'Nous testons avec php unit');

        $partner->setName('Novabat');
        $this->assertEquals($partner->getName(), 'Novabat');

        $partner->setName('Ingéscop');
        $this->assertEquals($partner->getName(), 'Ingéscop');

        $partner->setName('aEiOuY');
        $this->assertEquals($partner->getName(), 'aEiOuY');

        $partner->setName('1géscop');
        $this->assertEquals($partner->getName(), '1géscop');

        $partner->setName('abcdeffedcba');
        $this->assertEquals($partner->getName(), 'abcdeffedcba');

        $partner->setName('1géscop a décidé de confier le développement de son 
        site web aux étudiants de la Wild Code School');
        $this->assertEquals($partner->getName(), '1géscop a décidé de confier le développement de son 
        site web aux étudiants de la Wild Code School');

        $partner->setName('Eurêka');
        $this->assertEquals($partner->getName(), 'Eurêka');
    }
}
