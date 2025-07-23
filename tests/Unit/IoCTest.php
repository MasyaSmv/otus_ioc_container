<?php

use Masyasmv\IoC\Entity\Ship;
use Masyasmv\IoC\IoC;
use Masyasmv\IoC\Service\MoveCommand;
use PHPUnit\Framework\TestCase;

class IoCTest extends TestCase
{
    public function setUp(): void
    {
        IoC::Resolve('Scopes.Current', 'global')->Execute();
    }

    public function testRegistersAndResolves(): void
    {
        IoC::Resolve(
            'IoC.Register',
            'move.forward',
            static fn($ship) => new MoveCommand($ship, 0, 1),
        )->Execute();

        $cmd = IoC::Resolve('move.forward', new Ship());
        $cmd->execute();
        $this->assertInstanceOf(MoveCommand::class, $cmd);
    }

    public function testScopesAreIndependent(): void
    {
        IoC::Resolve('Scopes.New', 'A')->Execute();
        IoC::Resolve('Scopes.Current', 'A')->Execute();
        IoC::Resolve('IoC.Register', 'key', static fn() => 1)->Execute();

        IoC::Resolve('Scopes.New', 'B')->Execute();
        IoC::Resolve('Scopes.Current', 'B')->Execute();

        $this->expectException(RuntimeException::class);
        IoC::Resolve('key');
    }

    public function testFallbackToGlobalScope(): void
    {
        // Зарегистрируем команду в global
        IoC::Resolve('Scopes.Current', 'global')->Execute();
        IoC::Resolve('IoC.Register', 'foo', static fn() => 'bar')->Execute();

        // Новый пустой скоуп
        IoC::Resolve('Scopes.New', 'X')->Execute();
        IoC::Resolve('Scopes.Current', 'X')->Execute();

        // Поскольку 'foo' не в локальном, но есть в global — вернётся значение 'bar'
        $this->assertSame('bar', IoC::Resolve('foo'));
    }
}