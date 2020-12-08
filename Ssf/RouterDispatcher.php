<?php

namespace Ssf;

use FastRoute\Dispatcher;
use router\web;
use Ssf\Traits\GetInstances;
use Swoole\Http\Response as SwResponse;
use Swoole\Http\Server;
use Symfony\Component\HttpFoundation\Response;

class RouterDispatcher
{
    use GetInstances;

    public function processRouter($request, SwResponse $swoole_response, Server $http)
    {
        $_SERVER['_DW_INIT_AT_'] = microtime(true);

        // Fetch method and URI from somewhere
        $httpMethod = $request->server['request_method'];
        $uri = $request->server['request_uri'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $dispatcher = $this->getDispatcher();

        $response = new Response();

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                $response->setStatusCode(404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                $response->setStatusCode(405);
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars
                RouterFound::getInstance()->found($request, $response, $handler, $vars, $http);
                break;
        }

        $headers = $response->headers->all();
        foreach ($headers as $key => $header) {
            foreach ($header as $item) {
                $swoole_response->header($key, $item);
            }
        }
        $swoole_response->status($response->getStatusCode());

        $swoole_response->end($response->getContent());
    }

    public function getDispatcher(): Dispatcher
    {
        return web::getInstance()->getRouter();
    }
}