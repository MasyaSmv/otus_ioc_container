<?php

namespace Service;

use Masyasmv\IoC\Entity\Ship;
use Masyasmv\IoC\Service\RotateCommand;
use PHPUnit\Framework\TestCase;

final class RotateCommandTest extends TestCase
{
    public function testExecuteRotateShip(): void
    {
        $ship = new Ship(0, 0, 350.0);
        (new RotateCommand($ship, 30.0))->execute();

        $this->assertEquals(20.0, $ship->getAngle());
    }
}