<?php

/**
 * Representa el la estructura de las Materias Primas
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class MateriasPrimas {
    function __construct() {
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'materia_prima'
     * @return array Datos del registro
     */
    public static function getByIdEtapa($idEtapa) {
        $consulta = "SELECT * FROM etapas_materiaprima ".
                "as emp inner join materia_prima as mp on emp.idMateriaPrima=".
                "mp.idMateriaPrima where emp.idEtapa=".$idEtapa;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Retorna en la fila especificada de la tabla 'materia_prima'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM materia_prima";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una Materia prima con un identificador determinado
     * @param $idMateriaPrima Identificador de la Materia Prima
     * @return mixed
     */
    public static function getById($idMateriaPrima) {
        $consulta = "SELECT * FROM materia_prima WHERE idMateriaPrima = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idMateriaPrima));
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
    public static function update($idMateriaPrima,$descripcion_materiaprima,$nosap) {  
        $consulta = "UPDATE materia_prima SET descripcion_materiaprima=?,nosap=? WHERE idMateriaPrima=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($descripcion_materiaprima,$nosap,$idMateriaPrima));
        return $cmd;
    }

    /**
     * Insertar una nueva Materia Prima
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($descripcion_materiaprima,$nosap) {
        $comando = "INSERT INTO materia_prima (descripcion_materiaprima,nosap) VALUES(?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($descripcion_materiaprima,$nosap)
        );
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idMateriaPrima identificador de la tabla materia_prima
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idMateriaPrima) {
        $comando = "DELETE FROM materia_prima WHERE idMateriaPrima=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idMateriaPrima));
    }
    
}

?>