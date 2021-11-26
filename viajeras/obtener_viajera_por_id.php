<?php
/**
 * Obtiene el detalle de una viajera especificado por
 * su identificador "idViajera"
 */

require 'Viajeras.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idViajera'])) {
        $parametro = $_GET['idViajera'];
        $viajeras = Viajeras::getById($parametro);  
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
    } else {
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

