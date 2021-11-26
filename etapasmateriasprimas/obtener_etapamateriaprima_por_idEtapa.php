<?php
/**
 * Obtiene el detalle de una etapasmateriasprimas especificado por
 * su identificador "idEtapa"
 */

require 'Etapasmateriasprimas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idEtapa'])) {
        $parametro = $_GET['idEtapa'];
        $etapasmateriasprimas = Etapasmateriasprimas::getByIdEtapa($parametro);  
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
    } else {
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

