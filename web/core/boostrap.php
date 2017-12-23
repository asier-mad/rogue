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
 * Inyector de dependencias
 * Las dependencias se encuentran definidas en /core/dependencies.php
 * @see league/container
 */
$injector = require __DIR__.'/dependencies.php';

/**
 * Router
 * Las routas se encuentran definidas en /core/routes.php
 * @see nikic/fast-route
 */
$route_definition_callback = function (\FastRoute\RouteCollector $r){
    $routes = require __DIR__.'/routes.php';
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
        //Nombre de la clase
        $class_name = $route_info[1][0];
        //Metodo a ejecutar
        $method = $route_info[1][1];
        //Variables
        $vars = $route_info[2];

        if($class_name == 'private_callback'){
            //Seteamos el controlador segun las variables
            if(!empty($vars['model'])){
                $class_name = 'Rogue\Controllers\\' . ucfirst($vars['model']);
            }else{
                Response::create('500 - Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR)
                    ->prepare($request)
                    ->send();
            }
        }

        if(!class_exists($class_name)){
            $class_name = 'Rogue\Controllers\Controller';
        }

        //Instancia del controlador resolviendo dependencias con el $injector
        $controller = $injector->get($class_name);

        //Generar respuesta con la llamada al metodo adecuado en el controlador
        $response = $controller->$method($vars,$request);
        if($response instanceof Response){
            $response
                ->prepare($request)
                ->send();
        }

        break;
    default:
        // Esto no deberia ocurrir segun la documentación, pero asi cubrimos todas las posibilidades.
        Response::create('500 - Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR)
            ->prepare($request)
            ->send();
        return;
}