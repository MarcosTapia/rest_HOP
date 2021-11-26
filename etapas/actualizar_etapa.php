<?php
/**
 * Actualiza una etapa especificada por su identificador
 */

require 'Etapas.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Etapas::update(
        $body['idEtapa'],
        $body['numeroOperacion'],
        $body['descripcion_operacion'],
        $body['materiasprimas']
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
