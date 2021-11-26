<?php

/**
 * Representa el la estructura de los Datos de la Empresa
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class DatosEmpresa
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'datosempresa'
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM datosempresa";
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
     * Obtiene los campos de los datos de la empresa con un identificador
     * determinado
     *
     * @param $idEmpresa Identificador de la empresa
     * @return mixed
     */
    public static function getById($idEmpresa)
    {
        // Consulta de la tabla datosempresa
        $consulta = "SELECT *
                             FROM datosempresa
                             WHERE idEmpresa = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idEmpresa));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idEmpresa      identificador etc, etc
     
     */
    public static function update(
        $idEmpresa,
        $nombreEmpresa,
        $rfcEmpresa,
        $direccionEmpresa,
        $emailEmpresa,
        $telEmpresa,
        $cpEmpresa,
        $ciudadEmpresa,
        $estadoEmpresa,
        $paisEmpresa            
    )
    {  
        // Creando consulta UPDATE
        $consulta = "UPDATE datosempresa" .
            " SET nombreEmpresa=?, rfcEmpresa=?, direccionEmpresa=?, emailEmpresa=?,".
            " telEmpresa=?, cpEmpresa=?, ciudadEmpresa=?, estadoEmpresa=?, paisEmpresa=? " .
            "WHERE idEmpresa=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombreEmpresa,$rfcEmpresa,$direccionEmpresa,
                $emailEmpresa,$telEmpresa,$cpEmpresa,$ciudadEmpresa,
                $estadoEmpresa,$paisEmpresa,$idEmpresa));
        return $cmd;
    }

}

?>