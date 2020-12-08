<?php

use Composer\Autoload\ClassLoader;
use Ssf\RouterDispatcher;
use Swoole\Http\Server;


/**
 * @var ClassLoader $loader
 */
$loader = (require __DIR__ . '/vendor/autoload.php');

$loader->addPsr4('Ssf\\', __DIR__ . '/Ssf/');
$loader->addPsr4('App\\', __DIR__ . '/App/');
$loader->addPsr4('router\\', __DIR__ . '/router/');

ini_set('memory_limit', '10G');

$http = new Server("127.0.0.1", 9501);

$http->on("request", function ($request, $response) use ($http) {
    RouterDispatcher::getInstance()->processRouter($request, $response, $http);
});

$http->start();
