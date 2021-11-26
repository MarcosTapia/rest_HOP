<?php
/**
 * Obtiene todas las etapas de la base de datos
 */

require 'Etapas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $etapas = Etapas::getAll();
    if ($etapas) {
        $datos["estado"] = 1;
        $datos["etapas"] = $etapas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

