<?php
/**
 * Representa el la estructura de las Etapas
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Etapas {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Habilidades'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM etapas";
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
     * Obtiene los campos de una Etapa con un identificador determinado
     * @param $idEtapa Identificador de la etapa
     * @return mixed
     */
    public static function getById($idEtapa) {
        $consulta = "SELECT * FROM etapas WHERE idEtapa = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idEtapa));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idEtapa      identificador
     * @param mas campos
     */
    public static function update($idEtapa,$numeroOperacion,$descripcion_operacion,$materiasprimas) {  
        $consulta = "UPDATE etapas SET numeroOperacion=?, descripcion_operacion=? WHERE idEtapa=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $retorno = $cmd->execute(array($numeroOperacion,$descripcion_operacion,$idEtapa));
        if ($retorno == TRUE) {
            $consulta = "delete from etapas_materiaprima where idEtapa=".$idEtapa;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $retorno = $cmd->execute();
            if ($retorno == TRUE) {
                $materiasprimasArray = explode("|",$materiasprimas);
                for($i=0; $i < sizeof($materiasprimasArray) - 1; $i++) {
                    $consulta = "INSERT INTO etapas_materiaprima(idEtapa,idMateriaPrima)" .
                            " VALUES(".$idEtapa.",".$materiasprimasArray[$i].");";
                    $cmd = Database::getInstance()->getDb()->prepare($consulta);
                    $retorno = $cmd->execute();
                }            
            }
        }
        return $retorno;
    }

    /**
     * Insertar una nueva Etapa
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($numeroOperacion,$descripcion_operacion,$materiasprimas) {
        $comando = "INSERT INTO etapas(numeroOperacion,descripcion_operacion) VALUES(?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        $retorno = $sentencia->execute(array($numeroOperacion,$descripcion_operacion));
        if ($retorno == TRUE) {
            $consulta = "SELECT max(idEtapa) as id FROM etapas";
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['id'];            

            $materiasprimasArray = explode("|",$materiasprimas);
            for($i=0; $i < sizeof($materiasprimasArray) - 1; $i++) {
                $consulta = "INSERT INTO etapas_materiaprima(idEtapa,idMateriaPrima)" .
                        " VALUES(".$lastId.",".$materiasprimasArray[$i].");";
                $cmd = Database::getInstance()->getDb()->prepare($consulta);
                $retorno = $cmd->execute();
            }
        }
        return $retorno;    
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idEtapa identificador de la tabla etapas
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idEtapa) {
        $consulta = "delete from etapas_materiaprima WHERE idEtapa=".$idEtapa;
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $retorno = $cmd->execute();
        if ($retorno == TRUE) {
            $consulta = "DELETE FROM etapas WHERE idEtapa=".$idEtapa;
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $retorno = $cmd->execute();
        }
        return $retorno;
    }
    
}

?>