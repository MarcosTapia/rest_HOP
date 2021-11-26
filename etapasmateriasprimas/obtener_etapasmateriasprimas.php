<?php
/**
 * Obtiene todas las obtener_etapasmateriasprimas de la base de datos
 */

require 'Etapasmateriasprimas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $etapasmateriasprimas = Etapasmateriasprimas::getAll();
    if ($etapasmateriasprimas) {
        $datos["estado"] = 1;
        $datos["etapasmateriasprimas"] = $etapasmateriasprimas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

