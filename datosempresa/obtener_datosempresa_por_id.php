<?php
/**
 * Obtiene el detalle de la Empresa especificado por
 * su identificador "idEmpresa"
 */

require 'DatosEmpresa.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['idEmpresa'])) {

        // Obtener parametro idEmpresa
        $parametro = $_GET['idEmpresa'];

        // Tratar retorno
        $retorno = DatosEmpresa::getById($parametro);


        if ($retorno) {

            $datosEmpresa["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $datosEmpresa["datosEmpresa"] = $retorno;
            // Enviar objeto json de la empresa
            print json_encode($datosEmpresa);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
        }

    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

