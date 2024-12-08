<?php

declare(strict_types=1);

namespace App\Library\Config;

class Config
{
    public const CONFIG_FILE = __DIR__ . '/../../../config/config.php';
    public const DOCS_DIR = __DIR__ . '/../../../docs';

    private static array $config = [];
    private static array $localeConfig = [];
    private static string $currentLocale = 'en';

    public static function init(array $config = [], string $locale = 'en'): void
    {
        self::$currentLocale = $locale;
        self::$config = $config ?: require_once self::CONFIG_FILE;
        
        $localeConfigPath = self::DOCS_DIR . "/{$locale}/config.php";
        if (file_exists($localeConfigPath)) {
            self::$localeConfig = require $localeConfigPath;
        }
    }

    public static function get(?string $key = null, mixed $default = null): mixed
    {
        if (empty($key)) {
            return array_replace_recursive(self::$config, self::$localeConfig);
        }

        $keys = explode('.', $key);
        
        // First check in locale config
        $localeValue = self::getFromArray(self::$localeConfig, $keys);
        if ($localeValue !== null) {
            return $localeValue;
        }

        // Fallback to default config
        $defaultValue = self::getFromArray(self::$config, $keys);
        return $defaultValue ?? $default;
    }

    public static function has(string $key): bool
    {
        $keys = explode('.', $key);
        
        // Check in locale config first
        if (self::getFromArray(self::$localeConfig, $keys) !== null) {
            return true;
        }

        // Then check in default config
        return self::getFromArray(self::$config, $keys) !== null;
    }

    private static function getFromArray(array $array, array $keys): mixed
    {
        $current = $array;

        foreach ($keys as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return null;
            }
            $current = $current[$segment];
        }

        return $current;
    }

    public static function setLocale(string $locale): void
    {
        self::$currentLocale = $locale;
        $localeConfigPath = self::DOCS_DIR . "/{$locale}/config.php";
        
        if (file_exists($localeConfigPath)) {
            self::$localeConfig = require $localeConfigPath;
        } else {
            self::$localeConfig = [];
        }
    }

    public static function getLocale(): string
    {
        return self::$currentLocale;
    }
}
