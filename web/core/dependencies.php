<?php
/**
 * Dependencias a inyectar en la aplicación
 */
declare(strict_types = 1);

$injector = new \League\Container\Container();

$injector->delegate(
    //Auto-wiring
    new \League\Container\ReflectionContainer()
);

return $injector;