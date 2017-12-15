<?php
/**
 * Iniciador de aplicación
 */
declare(strict_types = 1);

namespace Rogue;

use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/functions.php';

/**
 * Request
 * @see symfony/http-foundation
 */
$request = Request::createFromGlobals();

/**
 * Carga de environment
 * @see vlucas/phpdotenv
 */
$dotenv = new Dotenv(__DIR__.'/../','.env'.((is_localhost() === true) ? '.local' : ''));
$dotenv->load();

/**
 * Manejador de errores
 * @see filp/whoops
 */
$whoops = new Run();
if(getenv('WEB_STATUS') != 'production'){
    $whoops->pushHandler(new PrettyPageHandler);
}else{
    $whoops->pushHandler(function($e){
        //@todo: Manejador de errores en producción (envío correo, page friendly...???)
    });
}
$whoops->register();

/**
 * Router
 * @see nikic/fast-route
 */
$route_definition_callback = function (\FastRoute\RouteCollector $r){
    $routes = include __DIR__.'/routes.php';
    foreach ($routes as $route) $r->addRoute($route[0],$route[1],$route[2]);
};
$dispatcher = \FastRoute\simpleDispatcher($route_definition_callback);

$route_info = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($route_info[0]){
    case Dispatcher::NOT_FOUND:
        //404
        Response::create('404 - Not Found',Response::HTTP_NOT_FOUND)
            ->prepare($request)
            ->send();
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        //405
        Response::create('405 - Method Not Allowed',Response::HTTP_METHOD_NOT_ALLOWED)
            ->prepare($request)
            ->send();
        break;
    case Dispatcher::FOUND:
        //200
        $handler = $route_info[1];
        $vars = $route_info[2];
        call_user_func($handler,$vars);
        break;
}