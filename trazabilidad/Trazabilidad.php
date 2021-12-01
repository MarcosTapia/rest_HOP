<?php

/**
 * Representa el la estructura de las trazabilidades
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Trazabilidad {
    function __construct() {
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'trazabilidad' de hoy
     * @return array Datos del registro
     */
    public static function getAllDay() {
        $consulta = "SELECT Event, COUNT(*) AS contadores FROM ".$tskTableName." where ".$complementoSql1." GROUP BY Event";
        /*
        $consulta = "SELECT tmp.cantidad as standard, ordenes.cantidad as cantidad_orden,m.nombre_maquina, m.numero_maquina, u.nombre,u.apellido_paterno,u.apellido_materno,ordenes.fecha, tmp.idTrazabilidadMateriaPrima, ordenes.numeroOrden, e.numeroOperacion,e.descripcion_operacion,mp.descripcion_materiaprima, "
                . "tmp.fechaMateriaPrima FROM trazabilidad_materiaprima as tmp inner join ordenes on tmp.idOrden=ordenes.idOrden "
                . "inner join materia_prima as mp on tmp.idMateriaPrima = mp.idMateriaPrima inner join etapas as e on tmp.idEtapa = e.idEtapa "
                . "inner join usuarios as u on tmp.idUsuario = u.idUsuario inner join maquinas as m on tmp.idMaquina = m.idMaquina where DATE(fechaEscaneo) = DATE(NOW())";
         */
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    

    /**
     * Retorna en la fila especificada de la tabla 'trazabilidad'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT tmp.cantidad as standard, ordenes.cantidad as cantidad_orden,m.nombre_maquina, m.numero_maquina, u.nombre,u.apellido_paterno,u.apellido_materno,ordenes.fecha, tmp.idTrazabilidadMateriaPrima, ordenes.numeroOrden, e.numeroOperacion,e.descripcion_operacion,mp.descripcion_materiaprima, "
                . "tmp.fechaMateriaPrima FROM trazabilidad_materiaprima as tmp inner join ordenes on tmp.idOrden=ordenes.idOrden "
                . "inner join materia_prima as mp on tmp.idMateriaPrima = mp.idMateriaPrima inner join etapas as e on tmp.idEtapa = e.idEtapa "
                . "inner join usuarios as u on tmp.idUsuario = u.idUsuario inner join maquinas as m on tmp.idMaquina = m.idMaquina";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una Area con un identificador
     * determinado
     * @param $idArea Identificador de la area
     * @return mixed
     */
    public static function getById($idArea) {
        $consulta = "SELECT * FROM areas WHERE idArea = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idArea));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     */
    public static function update($idArea,$descripcion) {  
        $consulta = "UPDATE areas SET descripcion=? WHERE idArea=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($descripcion,$idArea));
        return $cmd;
    }

    /**
     * Insertar un nuevo Usuario
     *
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($descripcion) {
        $comando = "INSERT INTO areas (descripcion) VALUES(?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($descripcion)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idArea identificador de la tabla Areas
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idArea) {
        $comando = "DELETE FROM areas WHERE idArea=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idArea));
    }
    
    
    /**
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function verificaUsuario($usuario, $clave)
    {
        // Consulta de la tabla Alumnos
        $consulta = "SELECT *
                             FROM usuarios
                             WHERE usuario = ? and clave=?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($usuario,  md5($clave)));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
    
    /** nuevo
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function getByIdBusq($idUsuario)
    {
        // Consulta de la tabla Alumnos
        $consulta = "select * from usuarios where idUsuario like '"
                .$idUsuario."%'";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
//            return $comando->fetchAll(PDO::FETCH_ASSOC);
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /** nuevo
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function getByNombreBusq($nombre)
    {
        // Consulta de la tabla Alumnos
        $consulta = "select * from usuarios where concat(nombre,' ',apellido_paterno,' ',apellido_materno) like '"
                .$nombre."%'";
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
    
}

?>