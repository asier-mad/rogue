<?php
/**
 * Dependencias a inyectar en la aplicación
 */
declare(strict_types = 1);

$injector = new \League\Container\Container();

$injector
    ->add('Twig_Environment')
    ->withArgument(
        new Twig_Loader_Filesystem(__DIR__ . '/../views/')
    );

$injector
    ->delegate(
    //Auto-wiring
    new \League\Container\ReflectionContainer()
);

return $injector;