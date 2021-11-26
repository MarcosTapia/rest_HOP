<?php

/**
 * Representa el la estructura de las Usuarios
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Usuarios {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'usuarios'
     * @param $idUsuario Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM usuarios";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Usuario con un identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function getById($idUsuario) {
        $consulta = "SELECT * FROM usuarios as u inner join "
                . "usuarios_etapas as ue on u.idUsuario=ue.idUsuario "
                . "where u.idUsuario=".$idUsuario;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene los campos de un Usuario-Etapa para ver si 
     * puede usar una etapa con dos identificadorwa determinados
     * @param $idUsuario,$idEtapas Identificador del usuario
     * @return mixed
     */
    public static function getByIdUsuarioIdEtapa($idUsuario,$idEtapa) {
        $consulta = "SELECT * FROM usuarios_etapas "
                . "where idUsuario=".$idUsuario." and idEtapa=".$idEtapa;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Usuario con un identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function getByIdSoloUsuario($idUsuario) {
        $consulta = "SELECT * FROM usuarios where idUsuario=".$idUsuario;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idUsuario      identificador
     * @param mas campos
     */
    public static function update($idUsuario,$usuario,$clave,$noEmpleado,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno,$habilidades) {  
        $retorno;
        if ($permisos == 1) {
            $consulta = "delete from usuarios_etapas WHERE idUsuario=".$idUsuario;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $cmd->execute();
            $retorno = $cmd;
            if ($retorno == TRUE) {
                $consulta = "UPDATE usuarios" .
                    " SET usuario=?, clave=?, permisos=?, nombre=?,".
                    " apellido_paterno=?, apellido_materno=?, noEmpleado=? " .
                    "WHERE idUsuario=?";
                $cmd = Database::getInstance()->getDb()->prepare($consulta);
                $cmd->execute(array($usuario, $clave, $permisos
                        , $nombre, $apellidoPaterno,$apellidoMaterno,$noEmpleado,$idUsuario));
                $retorno = $cmd;
            }
        }
        if ($permisos == 2) {
            $consulta = "update usuarios set usuario='".$usuario."',clave='".$clave."'"
                    .",permisos=".$permisos.",nombre='".$nombre."',apellido_paterno='"
                    .$apellidoPaterno."',apellido_materno='".$apellidoMaterno."'"
                    .",noEmpleado='".$noEmpleado."' where idUsuario=".$idUsuario;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $retorno = $cmd->execute();
            if ($retorno == TRUE) {
                $consulta = "delete from usuarios_etapas where idUsuario=".$idUsuario;
                $cmd = Database::getInstance()->getDb()->prepare($consulta);
                $retorno = $cmd->execute();
                if ($retorno == TRUE) {
                    $habilidadesArray = explode("|",$habilidades);
                    for($i=0; $i < sizeof($habilidadesArray) - 1; $i++) {
                        $consulta = "INSERT INTO usuarios_etapas(idUsuario,idEtapa)" .
                                " VALUES(".$idUsuario.",".$habilidadesArray[$i].");";
                        $cmd = Database::getInstance()->getDb()->prepare($consulta);
                        $retorno = $cmd->execute();
                    }            
                }
            }
        }
        return $retorno;
    }

    /**
     * Insertar un nuevo Usuario
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($usuario,$clave,$noEmpleado
            ,$permisos,$nombre,$apellidoPaterno
            ,$apellidoMaterno,$habilidades) {
        $consulta = "INSERT INTO usuarios(usuario,clave,permisos,nombre,apellido_paterno,apellido_materno,noEmpleado) "
                . "VALUES('".$usuario."','".$clave."',".$permisos.",'"
                .$nombre."','".$apellidoPaterno."','".$apellidoMaterno."','".$noEmpleado."')";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $retorno = $cmd->execute();
        if ($retorno == TRUE) {
            //$lastId = mysqli_insert_id($conn);
            $consulta = "SELECT max(idUsuario) as id FROM usuarios";
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['id'];            
            $habilidadesArray = explode("|",$habilidades);
            for($i=0; $i < sizeof($habilidadesArray) - 1; $i++) {
                $consulta = "INSERT INTO usuarios_etapas(idUsuario,idEtapa)" .
                        " VALUES(".$lastId.",".$habilidadesArray[$i].");";
                $cmd = Database::getInstance()->getDb()->prepare($consulta);
                $retorno = $cmd->execute();
            }
        }
        return $retorno;    
    }
         
    /**
     * Eliminar el registro con el identificador especificado
     * @param $idUsuario identificador de la tabla Usuarios
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idUsuario) {
        $consulta = "delete from usuarios_etapas WHERE idUsuario=".$idUsuario;
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $retorno = $cmd->execute();
        if ($retorno == TRUE) {
            $consulta = "delete from usuarios WHERE idUsuario=".$idUsuario;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $retorno = $cmd->execute();;
        }
        return $retorno;
    }
    
    /**
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     * @param $usuario, $claveIdentificador del usuario
     * @return mixed
     */
    public static function verificaUsuario($usuario, $clave) {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? and clave=?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($usuario,md5($clave)));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function userExist($usuario,$clave) {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? and clave = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($usuario,$clave));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
            //return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
}

?>