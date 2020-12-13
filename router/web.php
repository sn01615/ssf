<?php

namespace router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Ssf\Traits\GetInstances;
use function FastRoute\simpleDispatcher;

class web
{
    use GetInstances;

    public function routers(): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $router) {
            $router->get('/reload', 'reload');

            $router->addRoute('GET', '/', 'IndexController@home');

            $router->get('/twig', 'IndexController@twig');

            $router->get('/error', 'IndexController@testError');

            // {id} must be a number (\d+)
            $router->get('/user/{id:\d+}', 'IndexController@test');
            // The /{title} suffix is optional
            $router->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'IndexController@test');

            $router->addGroup('/admin', function (RouteCollector $router) {
                $router->addRoute('GET', '/list', 'IndexController@testList');
            });
        });
    }
}