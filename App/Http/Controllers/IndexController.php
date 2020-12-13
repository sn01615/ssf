<?php


namespace App\Http\Controllers;


use App\Models\UserModel;
use stdClass;
use Swoole\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{

    public function home(Response $response, Request $request, $vars): Response
    {
        $data = new stdClass();
        $data->Hello = 'world';
        $data->Test = UserModel::getInstance()->getUser(1);
        return $this->renderJson($response, $data);
    }

    public function twig(Response $response, Request $request, $vars): Response
    {
        $data = new stdClass();
        $data->world = 'world';
        return $this->render($response, "hello.html", $data);
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