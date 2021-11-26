<?php
/**
 * Obtiene todas las ordenes de la base de datos
 */

require 'Ordenes.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $ordenes = Ordenes::getAll();
    if ($ordenes) {
        $datos["estado"] = 1;
        $datos["ordenes"] = $ordenes;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

