<?php

namespace Macro;


use Masyasmv\IoC\Entity\Ship;
use Masyasmv\IoC\Macro\MacroCommand;
use Masyasmv\IoC\Service\MoveCommand;
use Masyasmv\IoC\Service\RotateCommand;
use PHPUnit\Framework\TestCase;

final class MacroCommandTest extends TestCase
{
    public function testExecuteMovesShip(): void
    {
        $ship = new Ship(0, 0, 0.0);
        $move = new MoveCommand($ship, 5, 0);
        $rotate = new RotateCommand($ship, 90.0);
        $macro = new MacroCommand($move, $rotate);

        $macro->execute();
        $this->assertSame(5, $ship->getX());
        $this->assertEquals(90.0, $ship->getAngle());
    }

    public function testAddAllowsAppendingCommands(): void
    {
        $ship = new Ship(0, 0, 0.0);
        $macro = new MacroCommand();  // стартуем без команд

        $move = new MoveCommand($ship, 2, 3);
        $rotate = new RotateCommand($ship, 45.0);

        $macro->add($move);
        $macro->add($rotate);

        $macro->execute();
        $this->assertSame(2, $ship->getX());
        $this->assertSame(3, $ship->getY());
        $this->assertEquals(45.0, $ship->getAngle());
    }
}