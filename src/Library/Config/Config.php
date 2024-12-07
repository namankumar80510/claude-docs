<?php

declare(strict_types=1);

namespace App\Library\Config;

class Config
{
    public const CONFIG_FILE = __DIR__ . '/../../../config/config.php';

    private static array $config = [];

    public static function init(array $config = []): void
    {
        self::$config = $config ?: require_once self::CONFIG_FILE;
    }

    public static function get(?string $key = null, mixed $default = null): mixed
    {
        if (empty($key)) {
            return self::$config;
        }

        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $segment) {
            if (!is_array($config) || !array_key_exists($segment, $config)) {
                return $default;
            }
            $config = $config[$segment];
        }

        return $config;
    }

    public static function has(string $key): bool
    {
        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $segment) {
            if (!is_array($config) || !array_key_exists($segment, $config)) {
                return false;
            }
            $config = $config[$segment];
        }

        return true;
    }
}
