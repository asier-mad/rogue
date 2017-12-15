<?php
/**
 * Rutas de la aplicación
 */
declare(strict_types = 1);

return [
    ['GET', '/hello-world', function () {
        echo 'Hello World';
    }],
    ['GET', '/another-route', function () {
        echo 'This works too';
    }],
];