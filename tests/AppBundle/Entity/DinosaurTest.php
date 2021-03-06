<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function testSettingLength()
    {
        $dinosaur = new Dinosaur();

        $this->assertSame(0, $dinosaur->getLength());

        $dinosaur->setLength(9);
        $this->assertSame(9, $dinosaur->getLength());
    }

    public function testDinosaurHasNotShrunk()
    {
        $dinosaur = new Dinosaur();
        $dinosaur->setLength(17);

        $this->assertGreaterThan(16, $dinosaur->getLength(), 'Did you put it in the washing machine?');
    }

    public function testReturnsFullSpacificationOfDinosaur()
    {
        $dinosaur = new Dinosaur();

        $this->assertSame(
            'The unknown non-carnivorous dinosaur is 0 meters long',
            $dinosaur->getSpecification()
        );
    }

    public function testReturnsFullSpacificationForTyrannosaurus()
    {
        $dinosaur = new Dinosaur('Tyrannosaurus', true);

        $dinosaur->setLength(12);

        $this->assertSame(
            'The Tyrannosaurus carnivorous dinosaur is 12 meters long',
            $dinosaur->getSpecification()
        );
    }
}