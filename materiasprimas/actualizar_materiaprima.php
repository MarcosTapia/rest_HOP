<?php
/**
 * Actualiza una materia prima especificada por su identificador
 */

require 'MateriasPrimas.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = MateriasPrimas::update(
        $body['idMateriaPrima'],
        $body['descripcion_materiaprima'],
        $body['nosap']
            );
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
	echo $json_string;
    }
}
?>
