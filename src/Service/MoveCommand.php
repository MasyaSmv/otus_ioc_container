<?php

namespace Masyasmv\IoC\Service;

use Masyasmv\IoC\Contract\Command;
use Masyasmv\IoC\Contract\Movable;

final class MoveCommand implements Command
{
    public function __construct(private Movable $obj, private int $dx, private int $dy) {}

    public function execute(): void
    {
        $this->obj->setPosition(
            $this->obj->getX() + $this->dx,
            $this->obj->getY() + $this->dy
        );
    }
}