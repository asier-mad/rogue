<?php
/**
 * Rutas de la aplicación
 */
declare(strict_types = 1);

return [
    ['GET', '/[{name}]', ['Rogue\Controllers\Homepage','show']],
];