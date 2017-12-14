<?php
/**
 * Catalogo de funciones de uso global
 */

/**
 * Comprueba si estamos en local
 * @return bool
 */
function is_localhost()
{
    $server_name = $_SERVER['SERVER_NAME']; /** Host actual */
    return ($server_name == 'localhost' || $server_name == '127.0.0.1' || substr($server_name,0,10) == '192.168.1.');
}

