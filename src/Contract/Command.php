<?php

namespace Masyasmv\IoC\Contract;

interface Command
{
    public function execute(): void;
}