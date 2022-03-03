<?php

namespace App\Controllers;

use Laminas\Diactoros\Response\HtmlResponse as HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse as RedirectResponse;

class BaseController{
    protected $templateEngine;
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../Views');
        $this->templateEngine =   new \Twig\Environment($loader, array(
            'debug' => true,
            'cache' => false,
        ));
    }
    public function renderHTML($fileName, $data=[]) {
        return new HTMLResponse($this->templateEngine->render($fileName, $data));

    }
}