<?php
/**
 * Obtiene el detalle de un usuario especificado por
 * su identificador "idUsuario"
 */

require 'Usuarios.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuario'])) {
        $parametro = $_GET['idUsuario'];
        $usuarios = Usuarios::getById($parametro);  
        if ($usuarios) {
            $datos["estado"] = 1;
            $datos["usuarios"] = $usuarios;
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
