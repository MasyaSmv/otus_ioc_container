<?php

namespace Masyasmv\IoC\Entity;

use Masyasmv\IoC\Contract\Movable;
use Masyasmv\IoC\Contract\Rotatable;

final class Ship implements Movable, Rotatable
{
    public function __construct(
        private int $x = 0,
        private int $y = 0,
        private float $angle = 0.0
    ) {
    }

    // Movable
    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setPosition(int $x, int $y): void
    {
        $this->x = $x;
        $this->y = $y;
    }

    // Rotatable
    public function getAngle(): float
    {
        return $this->angle;
    }

    public function setAngle(float $angle): void
    {
        $this->angle = $angle;
    }
}