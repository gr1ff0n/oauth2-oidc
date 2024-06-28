<?php

use Uru\BitrixCacher\Cache;
use Uru\BitrixCacher\CacheBuilder;
use Uru\DotEnv\DotEnv;

define('PROJECT_PATH', dirname(__DIR__) . "/");

function project_path($path = '')
{
    return PROJECT_PATH.'/'.$path;
}

function app_path($path = '')
{
    return project_path("src/$path");
}

/**
 * @param null|string $key
 * @param null|float $minutes
 * @param null|Closure $callback
 * @param string $initDir
 * @param string $basedir
 * @return CacheBuilder|mixed
 */
function cache($key = null, $minutes = null, $callback = null, $initDir = '/', $basedir = 'cache')
{
    if (func_num_args() === 0) {
        return new CacheBuilder();
    }

    return Cache::remember($key, $minutes, $callback, $initDir, $basedir);
}

function getDotEnv($key, $default = null)
{
    return DotEnv::get($key, $default);
}

require_once project_path('vendor/autoload.php');

DotEnv::load(project_path('config/.env.php'));
