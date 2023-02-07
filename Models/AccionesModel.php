<?php

/**
 * Description of AccionesModel
 *
 * @author mario
 */
class AccionesModel extends Mysql {

    private $idAccion;
    private $nombreAccion;
    private $statusAccion;

    public function __construct() {
        parent::__construct();
    }

    public function selectAcciones($opcion = NULL) {
        $validateStatus = "";
        if ($opcion != NULL) {
            $validateStatus = "WHERE ac.status != 0";
        }
        $sql = "SELECT ac.id, ac.nombre, ac.puntos, DATE_FORMAT(ac.created_at, '%d/%m/%Y') as fecha, ac.status,
            DATE_FORMAT(ac.created_at, '%H:%i:%s') as hora FROM acciones ac $validateStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectAccion(int $idAccion) {
        $this->idAccion = $idAccion;
        $sql = "SELECT ac.id,ac.nombre, ac.puntos, DATE_FORMAT(ac.created_at, '%d/%m/%Y') as fecha, ac.status,
            DATE_FORMAT(ac.created_at, '%H:%i:%s') as hora FROM acciones ac WHERE ac.id = $this->idAccion;";
        $request = $this->select($sql);
        return $request;
    }

    public function insertAccion(string $nombre) {
        $this->nombreAccion = $nombre;
        $return = 0;
        $sql = "SELECT * FROM acciones WHERE nombre = '$this->nombreAccion'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO acciones(nombre) VALUES (?)";
            $arrData = array($this->nombreAccion);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exit";
        }
        return $return;
    }

    public function updateAccion(int $id, string $nombre) {
        $this->nombreAccion = $nombre;
        $this->idAccion = $id;
        $sql = "SELECT * FROM acciones WHERE nombre = '$this->nombreAccion' AND id != $this->idAccion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE acciones SET nombre = ? WHERE id = $this->idAccion";
            $params = array($this->nombreAccion);
            $request = $this->update($sql, $params);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function updateStatusAccion(int $idAccion, int $status) {
        $this->idAccion = $idAccion;
        $this->statusAccion = $status;
        $sql = "SELECT * FROM puntos_alumnos_envio WHERE accion_id  = $this->idAccion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE acciones SET status = ? WHERE id = $this->idAccion";
            $params = array($this->statusAccion);
            $request = $this->update($sql, $params);
            if ($request) {
                $request = 'ok';
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }

}
