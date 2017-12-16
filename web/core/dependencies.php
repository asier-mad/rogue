<?php
/**
 * Dependencias a inyectar en la aplicación
 */
declare(strict_types = 1);

$injector = new \League\Container\Container();

//Spot (ORM)
$db = new \Spot\Config();
$datas_db = [
    'dbname'   => getenv('DB_NAME'),
    'user'     => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'host'     => getenv('DB_HOST'),
];
if(getenv('DB_DRIVER')) $datas_db['driver'] = getenv('DB_DRIVER');
$db->addConnection(getenv('DB_TYPE'),$datas_db);

$injector
    ->add('\Spot\Locator')
    ->withArgument($db);

//Twig (Templates)
$injector
    ->add('Twig_Environment')
    ->withArgument(
        new Twig_Loader_Filesystem(__DIR__ . '/../views/')
    );

//Auto-wiring
$injector
    ->delegate(
    new \League\Container\ReflectionContainer()
);

return $injector;