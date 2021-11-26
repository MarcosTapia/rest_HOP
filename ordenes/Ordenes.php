<?php

/**
 * Representa el la estructura de las ordenes
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Ordenes {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'ordenes'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM ordenes as o inner "
                . "join viajeras as v on o.idViajera = v.idViajera";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una orden con un identificador determinado
     * @param $numeroOrden Identificador de la orden
     * @return mixed
     */
    public static function getByNumeroOrden($numeroOrden) {
        $consulta = "select * from ordenes as o inner join viajeras as v on o.idViajera = v.idViajera "
                ."where o.numeroOrden='".$numeroOrden."'";
        
        //$consulta = "SELECT * FROM ordenes WHERE numeroOrden = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($numeroOrden));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
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
     * Insertar una nueva orden
     * @param $registro      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($numeroOrden,$fecha,$cantidad,$viajera,$idUsuario) {
        $comando = "INSERT INTO ordenes (numeroOrden,fecha,cantidad,idViajera,idUsuario) VALUES(?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($numeroOrden,$fecha,$cantidad,$viajera,$idUsuario)
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
    
}

?>