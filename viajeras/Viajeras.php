<?php

/**
 * Representa el la estructura de las Viajeras
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Viajeras {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'viajeras'
     * @return array Datos del registro
     */
    public static function getAll() {
        //$consulta = "SELECT * FROM viajeras";
        $consulta = "SELECT * FROM viajeras as v inner join areas as a "
                . "on v.idArea = a.idArea inner join proyectos as "
                . "p on v.idProyecto=p.idProyecto";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una viajera y sus etapas con un identificador determinado
     * @param $idViajera Identificador de la viajera
     * @return mixed
     */
    public static function getById($idViajera) {
        $consulta = "SELECT * FROM viajeras as v inner join viajeras_etapas as ve "
                . "on v.idViajera=ve.idViajera where v.idViajera=".$idViajera;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene los campos de una Viajera con un identificador determinado
     * @param $idViajera Identificador de la viajera
     * @return mixed
     */
    public static function getByIdSoloViajera($idViajera) {
        $consulta = "SELECT * FROM viajeras where idViajera=".$idViajera;
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
    public static function update($idViajera,$sap,$variant,$standard,$viajerasEtapas,$idArea,$idProyecto) {  
        $retorno;
        $consulta = "update viajeras set sap='".$sap."',variant='".$variant."'"
                .",standard=".$standard.", idArea=".$idArea.", idProyecto=".$idProyecto." where idViajera=".$idViajera;
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $retorno = $cmd->execute();
        if ($retorno == TRUE) {
            $consulta = "delete from viajeras_etapas WHERE idViajera=".$idViajera;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $retorno = $cmd->execute();
            if ($retorno == TRUE) {
                $viajerasEtapasArray = explode("|",$viajerasEtapas);
                for($i=0; $i < sizeof($viajerasEtapasArray) - 1; $i++) {
                    $consulta = "INSERT INTO viajeras_etapas(idViajera,idEtapa)" .
                            " VALUES(".$idViajera.",".$viajerasEtapasArray[$i].");";
                    $cmd = Database::getInstance()->getDb()->prepare($consulta);
                    $retorno = $cmd->execute();
                }            
            }
        }
        return $retorno;
    }

    /**
     * Insertar una nueva viajera
     * @param nuevo registro
     * @return PDOStatement
     */
    public static function insert($sap,$variant,$standard, $etapas, $idArea, $idProyecto) {
        //inserta en viajeras
        $comando = "INSERT INTO viajeras (sap,variant,standard,idArea,idProyecto) VALUES(?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        $retorno = $sentencia->execute(
            array($sap,$variant,$standard,$idArea,$idProyecto)
        );
        //si se inserto bien la viajera obtengo mi ultimo id
        if ($retorno == TRUE) {
            $consulta = "SELECT max(idViajera) as id FROM viajeras";
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['id'];            
            $etapasArray = explode("|",$etapas);
            //inserto la viajera con las etapas en viajeras_etapas
            for($i=0; $i < sizeof($etapasArray) - 1; $i++) {
                $consulta = "INSERT INTO viajeras_etapas(idViajera,idEtapa)" .
                        " VALUES(".$lastId.",".$etapasArray[$i].");";
                $cmd = Database::getInstance()->getDb()->prepare($consulta);
                $retorno = $cmd->execute();
            }
        }
        return $retorno;    
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idViajera identificador de la tabla Viajeras
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idViajera) {
        $consulta = "delete from viajeras_etapas WHERE idViajera=".$idViajera;
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $retorno = $cmd->execute();
        if ($retorno == TRUE) {
            $consulta = "delete from viajeras WHERE idViajera=".$idViajera;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $cmd->execute();
            $retorno = $cmd;
        }
        return $retorno;
    }
    
}

?>