<?php

declare(strict_types=1);

namespace App\tests\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\EntityValidationTrait;
use App\Entity\Partner;

final class PartnerTest extends TestCase
{
    /**
     * @dataProvider getNames
     */
    public function testPartnerName(string $string): void
    {
        $partner = new Partner();
        $partner->setName($string);
        $this->assertEquals($partner->getName(), $string);
    }

    public function getNames(): array
    {
        return [
            ['Sacré couscous !'],
            ['Ouplaboom'],
            ['Nous testons avec php unit'],
            ['Novabat'],
            ['Ingéscop'],
            ['aEiOuY'],
            ['abcdeffedcba'],
            ['1géscop a décidé de confier le développement de son 
            site web aux étudiants de la Wild Code School'],
            ['Eurêka'],
            ['1géscop']
        ];
    }
}
