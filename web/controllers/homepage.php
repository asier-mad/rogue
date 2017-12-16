<?php
namespace Rogue\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Homepage{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function show($vars)
    {

        $content = '<h1>Hello World!</h1>
                    Hello '.((!empty($vars['name'])) ? $vars['name'] : 'stranger');

        $this->response->setContent($content);
        $this->response->setStatusCode(Response::HTTP_OK);
        $this->response->headers->set('Content/type', 'text/html');
        $this->response->setCharset('UTF-8');

       return $this->response;
    }
}