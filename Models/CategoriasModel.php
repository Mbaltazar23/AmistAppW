<?php

class CategoriasModel extends Mysql {

    public $intIdCategoria;
    public $strNombre;
    public $intStatus;

    public function __construct() {
        parent::__construct();
    }

    public function selectCategorias($option = NULL) {
        $this->intStatus = $option != NULL ? "WHERE status != 0" : "";
        $sql = "SELECT id, nombre, status FROM categorias $this->intStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCategoria(int $idCategoria) {
        $this->intIdCategoria = $idCategoria;
        $sql = "SELECT id, nombre,DATE_FORMAT(created_at, '%d/%m/%Y') as fecha, 
            DATE_FORMAT(created_at, '%H:%i:%s') as hora, status FROM categorias WHERE id = $this->intIdCategoria";
        $request = $this->select($sql);
        return $request;
    }

    public function insertCategoria(string $nombre) {
        $this->strNombre = $nombre;
        $return = 0;
        $sql = "SELECT * FROM categorias WHERE nombre = '{$this->strNombre}' ";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO categorias (nombre) VALUES (?)";
            $arrData = array($this->strNombre);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateCategoria(int $id, string $nombre) {
        $this->intIdCategoria = $id;
        $this->strNombre = $nombre;
        $sql = "SELECT * FROM categorias WHERE id != $this->intIdCategoria AND nombre = '$this->strNombre'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE categorias SET nombre = ? WHERE id = $this->intIdCategoria";
            $arrData = array($this->strNombre);
            $request_update = $this->update($query_update, $arrData);
            return $request_update;
        } else {
            return "exist";
        }
    }

    public function updateStatusCategoria(int $id, int $status) {
        $this->intIdCategoria = $id;
        $this->intStatus = $status;
        $sql = "SELECT * FROM productos WHERE categoria_id = $this->intIdCategoria";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE categorias SET status = ? WHERE id = $this->intIdCategoria";
            $arrData = array($this->intStatus);
            $request = $this->update($query_update, $arrData);
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

?>