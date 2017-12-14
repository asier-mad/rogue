<?php
declare(strict_types = 1);

namespace Rogue;

use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/functions.php';

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

throw new \Exception;