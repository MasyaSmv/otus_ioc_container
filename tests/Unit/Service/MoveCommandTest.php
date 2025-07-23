<?php

namespace Service;


use Masyasmv\IoC\Entity\Ship;
use Masyasmv\IoC\Service\MoveCommand;
use PHPUnit\Framework\TestCase;

final class MoveCommandTest extends TestCase
{
    public function testExecuteMovesShip(): void
    {
        $ship = new Ship();
        (new MoveCommand($ship, 3, 4))->execute();

        $this->assertSame(3, $ship->getX());
        $this->assertSame(4, $ship->getY());
    }
}