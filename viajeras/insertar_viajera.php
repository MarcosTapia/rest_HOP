<?php
/**
 * Insertar una nueva viajera en la base de datos
 */

require 'Viajeras.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Viajeras::insert(
        $body['sap'],
        $body['variant'],
        $body['standard'],
        $body['etapas'],
        $body['area'],
        $body['proyecto']
            );
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
	echo $json_string;
    }
}

?>