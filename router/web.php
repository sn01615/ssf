<?php

namespace router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Ssf\Traits\GetInstances;
use function FastRoute\simpleDispatcher;

class web
{
    use GetInstances;

    public function getRouter(): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $router) {
            $router->get('/reload', 'reload');

            $router->addRoute('GET', '/', 'HelloController@test');

            $router->get('/error', 'HelloController@testError');

            // {id} must be a number (\d+)
            $router->get('/user/{id:\d+}', 'HelloController@test');
            // The /{title} suffix is optional
            $router->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'HelloController@test');

            $router->addGroup('/admin', function (RouteCollector $router) {
                $router->addRoute('GET', '/list', 'HelloController@testList');
            });
        });
    }
}