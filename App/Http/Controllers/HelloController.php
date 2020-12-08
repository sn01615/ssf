<?php


namespace App\Http\Controllers;


use stdClass;
use Swoole\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{

    public function test(Response $response, Request $request, $vars): Response
    {
        $data = new stdClass();
        $data->Hello = 'world';
        return $this->renderJson($response, $data);
    }

    public function testError(Response $response, Request $request, $vars): Response
    {
        return $this->renderError($response, $code = 123, $msg = "错误信息");
    }

    public function testList(Response $response, Request $request, $vars): Response
    {
        $data = new stdClass();
        $data->list = [1, 2, 3];
        return $this->renderJson($response, $data);
    }
}