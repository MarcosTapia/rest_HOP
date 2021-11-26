<?php

/**
 * Representa el la estructura de las Etapasmateriasprimas
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Etapasmateriasprimas {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'etapasmateriaprima'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM etapas_materiaprima as emp inner join "
                . "etapas as e on emp.idEtapa = e.idEtapa inner join materia_prima "
                . "as mp on emp.idMateriaPrima = mp.idMateriaPrima";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una $etapamateriaprima con un identificador
     * determinado
     * @param $idArea Identificador de la area
     * @return mixed
     */
    public static function getByIdEtapa($idEtapa) {
        $consulta = "SELECT * FROM etapas_materiaprima WHERE idEtapa = ".$idEtapa;
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
     */
    public static function update($idArea,$descripcion) {  
        $consulta = "UPDATE areas SET descripcion=? WHERE idArea=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($descripcion,$idArea));
        return $cmd;
    }

    /**
     * Insertar una nueva Etapasmateriasprimas
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($idEtapa,$materiasprimas) {
        $materiasprimasArray = explode("|",$materiasprimas);
        $retorno;
        for($i=0; $i < sizeof($materiasprimasArray) - 1; $i++) {
            $consulta = "INSERT INTO etapas_materiaprima(idEtapa,idMateriaPrima)" .
                    " VALUES(".$idEtapa.",".$materiasprimasArray[$i].");";
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $retorno = $cmd->execute();
        }
        return $retorno;    
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