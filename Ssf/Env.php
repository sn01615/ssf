<?php


namespace Ssf;


use Ssf\Traits\GetInstances;
use Symfony\Component\Dotenv\Dotenv;

class Env
{
    use GetInstances;

    public function init()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');
    }
}

if (!function_exists('Ssf\env')) {
    function env($key, $default = null)
    {
        if ((string)($_ENV[$key] ?? null) !== '')
            return $_ENV[$key];
        return $default;
    }
}
