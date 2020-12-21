<?php


namespace Ssf\Traits;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait SsfTwig
{

    public function render(Response $response, $template, $data)
    {
        $templates = __DIR__ . '/../../resources/views';
        $cache = __DIR__ . '/../../storage/cache';
        $loader = new FilesystemLoader($templates);
        $twig = new Environment($loader, [
            'cache' => $cache,
            'auto_reload' => true,
        ]);

        $data = (array)$data;

        $html = $twig->render($template, $data);
        $response->setContent($html);
        return $response;
    }
}