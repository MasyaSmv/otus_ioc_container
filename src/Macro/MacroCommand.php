<?php

namespace Masyasmv\IoC\Macro;

use Masyasmv\IoC\Contract\Command;

final class MacroCommand implements Command
{
    /** @var Command[] */
    private array $commands;

    public function __construct(Command ...$cmds)
    {
        $this->commands = $cmds;
    }

    public function add(Command $cmd): void
    {
        $this->commands[] = $cmd;
    }

    public function execute(): void
    {
        foreach ($this->commands as $cmd) {
            $cmd->execute();
        }
    }
}