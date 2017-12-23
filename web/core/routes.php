<?php
/**
 * Rutas de la aplicación
 */
declare(strict_types = 1);

return [
    [['GET','POST'], '/privado/{model}/edit[/{id:\d+}]', ['private_callback','edit']],
    [['GET','POST'], '/privado/{model}/add', ['private_callback','edit']],
    [['GET','POST'], '/privado/{model}/delete[/{id:\d+}]', ['private_callback','delete']],
    ['GET', '/privado/{model}', ['private_callback','list']],
    ['GET', '/[{slug}]', ['Rogue\Controllers\Section','show']],
];