<?php

namespace App\Core;

use Dotenv\Dotenv;

class Env
{
    private static array $env = [];
    private static bool $loaded = false;

    private static function load(string $path): void
    {
        if (!self::$loaded) {
            $dotenv = Dotenv::createImmutable($path);
            $dotenv->load();

            self::$env = $_ENV;
            self::$loaded = true;
        }
    }

    /**
     * Получить значение переменной окружения
     */
    public static function get(string $key, $default = null)
    {
        if (!self::$loaded) {
            self::load(dirname(__DIR__, 2));
        }

        return self::$env[$key] ?? $default;
    }
}
