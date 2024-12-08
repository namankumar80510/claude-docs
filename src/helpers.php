<?php

declare(strict_types=1);

use App\Library\Config\Config;
use App\Library\I18n\I18n;

/**
 * Get a configuration value.
 * 
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function config(?string $key = null, mixed $default = null): mixed
{
    return Config::get($key, $default);
}

/**
 * Get the text in current locale
 * 
 * @param string $key
 * @param array $replace
 * @return string
 */
function __($key, array $replace = []): string
{
    return I18n::get($key, $replace);
}

/**
 * Check if a translation key exists
 * 
 * @param string $key
 * @return bool
 */
function __has($key): bool
{
    return I18n::has($key);
}

/**
 * Get the current locale
 * 
 * @return string
 */
function locale(): string
{
    return I18n::getLocale();
}
