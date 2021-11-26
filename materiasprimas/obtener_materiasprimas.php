<?php
/**
 * Obtiene todas las matrias primas de la base de datos
 */

require 'MateriasPrimas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $materiasprimas = MateriasPrimas::getAll();
    if ($materiasprimas) {
        $datos["estado"] = 1;
        $datos["materiasprimas"] = $materiasprimas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

