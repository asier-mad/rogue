<?php
/**
 * Rutas de la aplicación
 */
declare(strict_types = 1);

return [
    ['GET', '/yapiyahoo/[{name}]', ['Rogue\Controllers\Homepage','yapiyahoo']],
    ['GET', '/[{name}]', ['Rogue\Controllers\Homepage','show']],
];