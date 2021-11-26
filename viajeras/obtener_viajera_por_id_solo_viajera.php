<?php
/**
 * Obtiene el detalle de una viajera especificada por
 * su identificador "idViajera"
 */

require 'Viajeras.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idViajera'])) {
        $parametro = $_GET['idViajera'];
        $retorno = Viajeras::getByIdSoloViajera($parametro);
        if ($retorno) {
            $viajera["estado"] = 1;
            $viajera["viajera"] = $retorno;
            print json_encode($viajera);
        } else {
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
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

