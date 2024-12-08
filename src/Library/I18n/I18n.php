<?php

declare(strict_types=1);

namespace App\Library\I18n;

class I18n
{
    private static array $translations = [];
    private static string $locale = '';
    private static string $fallbackLocale = 'en';
    private static string $langPath;

    public static function init(string $locale, string $langPath = null): void
    {
        self::$langPath = $langPath ?? dirname(__DIR__, 3) . '/resources/lang';
        self::$locale = $locale ?? self::$fallbackLocale;
        self::loadTranslations();
    }

    public static function setLocale(string $locale): void
    {
        self::$locale = $locale;
        self::loadTranslations();
    }

    public static function getLocale(): string
    {
        return self::$locale;
    }

    public static function setFallbackLocale(string $locale): void
    {
        self::$fallbackLocale = $locale;
    }

    public static function getFallbackLocale(): string
    {
        return self::$fallbackLocale;
    }

    public static function get(string $key, array $replace = [], string $locale = null): string
    {
        $locale = $locale ?? self::$locale;

        $translation = self::getTranslation($key, $locale);

        if ($translation === null && $locale !== self::$fallbackLocale) {
            $translation = self::getTranslation($key, self::$fallbackLocale);
        }

        if ($translation === null) {
            return $key;
        }

        return self::replaceParameters($translation, $replace);
    }

    public static function has(string $key, string $locale = null): bool
    {
        return self::getTranslation($key, $locale ?? self::$locale) !== null;
    }

    private static function loadTranslations(): void
    {
        $locale = self::$locale;
        $path = self::$langPath . "/{$locale}";

        if (!is_dir($path)) {
            return;
        }

        self::$translations[$locale] = [];

        foreach (glob("{$path}/*.php") as $file) {
            $name = basename($file, '.php');
            self::$translations[$locale][$name] = require $file;
        }
    }

    private static function getTranslation(string $key, string $locale): ?string
    {
        $parts = explode('.', $key);

        if (!isset(self::$translations[$locale])) {
            return null;
        }

        $translations = self::$translations[$locale];

        foreach ($parts as $part) {
            if (!is_array($translations) || !array_key_exists($part, $translations)) {
                return null;
            }
            $translations = $translations[$part];
        }

        return is_string($translations) ? $translations : null;
    }

    private static function replaceParameters(string $translation, array $replace): string
    {
        if (empty($replace)) {
            return $translation;
        }

        $replacements = [];
        foreach ($replace as $key => $value) {
            $replacements[':' . $key] = $value;
            $replacements['{' . $key . '}'] = $value;
        }

        return strtr($translation, $replacements);
    }

    public static function choice(string $key, int $number, array $replace = [], string $locale = null): string
    {
        $translation = self::get($key, $replace, $locale);
        $segments = explode('|', $translation);

        $message = self::getTranslationByPlurality($segments, $number);

        return str_replace(':count', (string)$number, $message);
    }

    private static function getTranslationByPlurality(array $segments, int $number): string
    {
        if (count($segments) === 1) {
            return $segments[0];
        }

        foreach ($segments as $segment) {
            if (preg_match('/^[\{\[]([0-9]+,)?([0-9]+)?[\}\]](.*)/s', $segment, $matches)) {
                $from = $matches[1] ? (int)rtrim($matches[1], ',') : -INF;
                $to = $matches[2] ? (int)$matches[2] : INF;

                if ($number >= $from && $number <= $to) {
                    return $matches[3];
                }
            }
        }

        $pluralIndex = self::getPluralIndex($number);
        return $segments[$pluralIndex] ?? $segments[0];
    }

    private static function getPluralIndex(int $number): int
    {
        return $number === 1 ? 0 : 1;
    }
}
