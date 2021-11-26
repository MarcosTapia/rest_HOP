<?php
/**
 * Obtiene el detalle de una etapa especificado por
 * su identificador "idEtapa"
 */

require 'Etapas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idEtapa'])) {
        $parametro = $_GET['idEtapa'];
        $retorno = Etapas::getById($parametro);
        if ($retorno) {
            $etapa["estado"] = 1;
            $etapa["etapa"] = $retorno;
            print json_encode($etapa);
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

