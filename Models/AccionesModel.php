<?php

/**
 * Description of AccionesModel
 *
 * @author mario
 */
class AccionesModel extends Mysql {

    private $idAccion;
    private $nombreAccion;
    private $puntosAccion;
    private $statusAccion;

    public function __construct() {
        parent::__construct();
    }

    public function selectAcciones($opcion = NULL) {
        $validateStatus = "";
        if ($opcion != NULL) {
            $validateStatus = "WHERE ac.statusAccion != 0";
        }
        $sql = "SELECT ac.nombre, ac.puntos, DATE_FORMAT(ac.created_at, '%d/%m/%Y') as fecha, 
            DATE_FORMAT(ac.created_at, '%H:%i:%s') as hora, pt.puntos FROM acciones ac INNER JOIN puntaje pt 
            ON ac.score_id = pt.ids $validateStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectAccion(int $idAccion) {
        $this->idAccion = $idAccion;
        $sql = "SELECT ac.nombre, ac.puntos, DATE_FORMAT(ac.created_at, '%d/%m/%Y') as fecha, 
            DATE_FORMAT(ac.created_at, '%H:%i:%s') as hora, pt.puntos FROM acciones ac INNER JOIN puntaje pt 
            ON ac.score_id = pt.id WHERE ac.id = $this->idAccion;";
        $request = $this->select($sql);
        return $request;
    }

    public function insertAccion(string $nombre, int $puntos) {
        $this->nombreAccion = $nombre;
        $this->puntosAccion = $puntos;
        $return = 0;
        $sql = "SELECT * FROM acciones WHERE nombre = '$this->nombreAccion' AND score_id = $this->puntosAccion ";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO acciones(nombre, score_id) VALUES (?,?,?,?)";
            $arrData = array($this->nombre,
                $this->puntos,
                $this->status,
                $this->score_id);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exit";
        }
        return $return;
    }

    public function updateAccion(string $nombre, int $puntos, int $id) {
        $this->nombreAccion = $nombre;
        $this->puntosAccion = $puntos;
        $this->idAccion = $id;
        $sql = "SELECT * FROM acciones WHERE nombre = '$this->nombreAccion' AND id != $this->idAccion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE acciones SET nombre = ?, score_id = ? WHERE id = ?";
            $params = array($this->nombreAccion,
                $this->puntosAccion,
                $this->idAccion);
            $request = $this->update($sql, $params);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function updateStatusAccion(int $idAccion, int $status) {
        $this->idAccion = $idAccion;
        $this->statusAccion = $status;
        $sql = "SELECT * FROM usuarios_puntaje WHERE action_id  = $this->idAccion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE acciones SET status = ? WHERE id = $this->idAccion";
            $params = array($this->status);
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
