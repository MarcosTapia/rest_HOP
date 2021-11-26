<?php
/**
 * Obtiene el detalle de un usuario especificado por
 * su identificador "idUsuario"
 */

require 'Usuarios.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuario']) && isset($_GET['idEtapa'])) {
        $parametro1 = $_GET['idUsuario'];
        $parametro2 = $_GET['idEtapa'];
        $usuarios = Usuarios::getByIdUsuarioIdEtapa($parametro1,$parametro2);  
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
