<?php
/**
 * Obtiene el detalle de una orden especificado por
 * su identificador "numeroOrden"
 */

require 'Ordenes.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['numeroOrden'])) {
        $parametro = $_GET['numeroOrden'];
        $retorno = Ordenes::getByNumeroOrden($parametro);
        if ($retorno) {
            $orden["estado"] = 1;
            $orden["orden"] = $retorno;
            print json_encode($orden);
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

