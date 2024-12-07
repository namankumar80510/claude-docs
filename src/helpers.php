<?php

/**
 * procedural functions;
 */

/**
 * Get a configuration value.
 * 
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function config(string $key, mixed $default = null): mixed
{
    return \App\Library\Config\Config::get($key, $default);
}
