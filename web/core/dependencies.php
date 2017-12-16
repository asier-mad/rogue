<?php
/**
 * Dependencias a inyectar en la aplicación
 */
declare(strict_types = 1);

$injector = new \League\Container\Container();

//Spot (ORM)
$db = new \Spot\Config();
$db->addConnection('mysql', [
    'dbname'   => getenv('DB_NAME'),
    'user'     => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'host'     => getenv('DB_HOST'),
    'driver'   => 'pdo_mysql'
]);

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