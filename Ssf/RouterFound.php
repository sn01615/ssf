<?php


namespace Ssf;


use App\Http\Controllers\Controller;
use Ssf\Traits\GetInstances;
use Ssf\Traits\SsfJson;
use stdClass;
use Swoole\Http\Request;
use Swoole\Http\Server;
use Symfony\Component\HttpFoundation\Response;

class RouterFound
{
    use GetInstances, SsfJson;

    public function found(Request $request, Response $response, $handler, $vars, Server $http): Response
    {
        if ($handler == 'reload') {
            return $this->reload($response, $http);
        }
        $_COOKIE = $request->cookie;
        foreach ($request->server as $key => $item)
            $_SERVER[strtoupper($key)] = $item;
        if ($request->header['x-real-ip'] ?? null)
            $_SERVER['REMOTE_ADDR'] = $request->header['x-real-ip'];

        [$controller, $method] = explode('@', $handler);

        /**
         * @var Controller $controller
         */
        $controller = sprintf("\\App\\Controllers\\%s", $controller);

        return $controller::getInstance()->$method($response, $request, $vars);
    }

    private function reload(Response $response, Server $http): Response
    {
        $http->reload();
        $data = new stdClass();
        $data->info = "Reload current server success";
        return $this->renderJson($response, $data);
    }
}