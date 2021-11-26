<?php
/**
 * Obtiene el detalle de una materia prima especificado por
 * su identificador "idMateriaPrima"
 */

require 'MateriasPrimas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idMateriaPrima'])) {
        $parametro = $_GET['idMateriaPrima'];
        $retorno = MateriasPrimas::getById($parametro);
        if ($retorno) {
            $materiaprima["estado"] = 1;
            $materiaprima["materiaprima"] = $retorno;
            print json_encode($materiaprima);
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

