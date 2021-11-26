<?php
/**
 * Obtiene todas las areas de la base de datos
 */

require 'Trazabilidad.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $trazabilidades = Trazabilidad::getAllDay();
    if ($trazabilidades) {
        $datos["estado"] = 1;
        $datos["trazabilidades"] = $trazabilidades;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

