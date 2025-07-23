<?php

namespace Masyasmv\IoC\Contract;

interface Movable
{
    public function getX(): int;
    public function getY(): int;
    public function setPosition(int $x, int $y): void;
}