<?php

namespace Masyasmv\IoC;

use Closure;
use RuntimeException;

final class IoC
{
    /** @var array<string, Closure> */
    private static array $global = [];

    /** @var array<string, array<string, Closure>> */
    private static array $scopes = [];

    /** @var string */
    private static string $currentScope = 'global';

    /**
     * Универсальный фасад‐метод.
     */
    public static function Resolve(string $key, ...$args): mixed
    {
        // служебные ключи разбираем сразу
        return match ($key) {
            // -------------------- Регистрация --------------------
            'IoC.Register' => self::handleRegister(...$args),

            // -------------------- Скоупы -------------------------
            'Scopes.New' => self::handleNewScope(...$args),
            'Scopes.Current' => self::handleSwitchScope(...$args),

            default => self::handleResolve($key, ...$args),
        };
    }

    // --- служебные методы ниже, пока заглушки ----------------

    /**
     * @param string $key
     * @param Closure $factory
     *
     * @return __anonymous@1353
     */
    private static function handleRegister(string $key, Closure $factory)
    {
        if (self::$currentScope === 'global') {
            self::$global[$key] = $factory;
        } else {
            self::$scopes[self::$currentScope][$key] = $factory;
        }
        // возвращаем объект-команду для .Execute()
        return new class {
            public function Execute(): void
            {
            }
        };
    }

    /**
     * @param string $scopeId
     *
     * @return __anonymous@1576
     */
    private static function handleNewScope(string $scopeId)
    {
        self::$scopes[$scopeId] ??= [];
        return new class {
            public function Execute(): void
            {
            }
        };
    }

    /**
     * @param string $scopeId
     *
     * @return __anonymous@1802
     */
    private static function handleSwitchScope(string $scopeId)
    {
        self::$currentScope = $scopeId;
        return new class {
            public function Execute(): void
            {
            }
        };
    }

    /**
     * @param string $key
     * @param mixed ...$args
     *
     * @return mixed
     */
    private static function handleResolve(string $key, mixed ...$args): mixed
    {
        if (self::$currentScope === 'global') {
            $scope = self::$global;
        } else {
            $scope = self::$scopes[self::$currentScope];
        }

        if (!isset($scope[$key])) {
            // fallback: ищем в global
            if (!isset(self::$global[$key])) {
                throw new RuntimeException("Не зарегистрировано: $key");
            }
            return (self::$global[$key])(...$args);
        }
        return ($scope[$key])(...$args);
    }
}