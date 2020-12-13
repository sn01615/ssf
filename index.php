<?php

use Composer\Autoload\ClassLoader;
use Ssf\EnvLoad;
use Ssf\RouterDispatcher;
use Swoole\Http\Server;
use function Ssf\env as env;

$http = new Server("127.0.0.1", 9501);

$http->on('workerStart', function () {
    /**
     * @var ClassLoader $loader
     */
    $loader = (require __DIR__ . '/vendor/autoload.php');

    $loader->addPsr4('Ssf\\', __DIR__ . '/Ssf/');
    $loader->addPsr4('App\\', __DIR__ . '/App/');
    $loader->addPsr4('router\\', __DIR__ . '/router/');
    $loader->addPsr4('config\\', __DIR__ . '/config/');

    EnvLoad::getInstance()->init();

    ini_set('memory_limit', env('MEMORY_LIMIT', '256M'));
});

$http->on("request", function ($request, $response) use ($http) {
    RouterDispatcher::getInstance()->processRouter($request, $response, $http);
});

$http->start();
