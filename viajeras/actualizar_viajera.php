<?php
/**
 * Actualiza una vijera especificada por su identificador
 */

require 'Viajeras.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Viajeras::update(
        $body['idViajera'],
        $body['sap'],
        $body['variant'],
        $body['standard'],
        $body['viajerasEtapas'],
        $body['area'],
        $body['proyecto']
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
