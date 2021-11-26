<?php
/**
 * Obtiene el detalle de una materia prima especificado por
 * su identificador "idMateriaPrima"
 */

require 'MateriasPrimas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idEtapa'])) {
        $parametro = $_GET['idEtapa'];
        $materiasprimas = MateriasPrimas::getByIdEtapa($parametro);
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
    } else {
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

