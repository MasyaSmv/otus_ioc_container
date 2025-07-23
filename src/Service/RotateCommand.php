<?php

namespace Masyasmv\IoC\Service;

use Masyasmv\IoC\Contract\Command;
use Masyasmv\IoC\Contract\Rotatable;

final class RotateCommand implements Command
{
    public function __construct(private Rotatable $obj, private float $delta) {}

    public function execute(): void
    {
        $angle = fmod($this->obj->getAngle() + $this->delta + 360.0, 360.0);
        $this->obj->setAngle($angle);
    }
}