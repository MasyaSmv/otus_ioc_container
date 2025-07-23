<?php

namespace Masyasmv\IoC\Contract;

interface Rotatable
{
    public function getAngle(): float;
    public function setAngle(float $angle): void;
}