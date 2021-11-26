<?php
/**
 * Obtiene todas los viajeras de la base de datos
 */

require 'Viajeras.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $viajeras = Viajeras::getAll();
    if ($viajeras) {
        $datos["estado"] = 1;
        $datos["viajeras"] = $viajeras;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

