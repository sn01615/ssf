<?php


namespace Ssf\Traits;


use stdClass;
use Symfony\Component\HttpFoundation\Response;

trait SsfJson
{
    private $status = 0;

    private $user_msg;

    protected function renderError(Response $response, $code, $msg)
    {
        $this->status = $code;
        $this->user_msg = $msg;
        $data = new stdClass();
        return $this->renderJson($response, $data);
    }

    protected function renderJson(Response $response, $data): Response
    {
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');

        $_data = new stdClass();
        $_data->status = $this->status;
        $_data->user_msg = $this->user_msg;
        $_data->data = $data;
        $_data->php_version = PHP_VERSION_ID;
        if (isset($_SERVER['_DW_INIT_AT_'])) {
            $_data->runtime = round(microtime(true) - $_SERVER['_DW_INIT_AT_'], 6);
        }

        return $response->setContent(json_encode($_data));
    }
}