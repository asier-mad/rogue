<?php
namespace Rogue\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class Homepage{
    private $response;

    public function __construct(Response $response, Twig_Environment $twig)
    {
        $this->response = $response;
        $this->twig = $twig;
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

    public function yapiyahoo($vars){
        $this->response->setContent($this->twig->render('pages/yapiyahoo.html.twig',[
            'name' => (!empty($vars['name'])) ? $vars['name'] : 'motherfucer'
        ]));
        $this->response->setStatusCode(Response::HTTP_OK);
        $this->response->headers->set('Content/type', 'text/html');
        $this->response->setCharset('UTF-8');

        return $this->response;
    }
}