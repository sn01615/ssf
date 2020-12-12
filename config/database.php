<?php


namespace config;


use Ssf\Traits\GetInstances;
use function Ssf\env;

class database
{
    use GetInstances;

    public function config(): array
    {
        return [
            'default' => [
                'driver' => 'mysql',
                'host' => env('MYSQL_HOST', '127.0.0.1'),
                'port' => env('MYSQL_PORT', 3306),
                'database' => env('MYSQL_DATABASE', 'test'),
                'username' => env('MYSQL_USERNAME', 'root'),
                'password' => env('MYSQL_PASSWORD', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_bin',
                'prefix' => '',
            ]
        ];
    }
}