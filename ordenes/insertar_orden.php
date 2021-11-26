<?php
/**
 * Insertar una nueva orden en la base de datos
 */

require 'Ordenes.php';
                    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Ordenes::insert(
        $body['numeroOrden'],
        $body['fecha'],
        $body['cantidad'],
        $body['viajera'],
        $body['idUsuario']
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