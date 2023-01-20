<?php

/**
 *
 * @author mario
 */
class ColegiosModel extends Mysql {

    public $intIdColegio;
    public $strNombre;
    public $strRut;
    public $strDireccion;
    public $strTelefono;
    public $intStatus;

    public function __construct() {
        parent::__construct();
    }

    public function selectColegios($option = NULL) {
        $this->intStatus = $option != NULL ? "WHERE status != 0" : "";
        $sql = "SELECT c.id, c.nombre, c.rut, c.direccion, c.telefono, c.status, u.email, u.dni 
            FROM colegios c INNER JOIN colegios_usuarios cu ON c.id = cu.colegio_id 
            INNER JOIN usuarios u ON cu.user_id = u.id $this->intStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectColegio(int $idColegio) {
        $this->intIdColegio = $idColegio;
        $sql = "SELECT c.id, c.nombre, c.rut, c.direccion, c.telefono, c.status, u.email, u.dni 
            FROM colegios c INNER JOIN colegios_usuarios cu ON c.id = cu.colegio_id 
            INNER JOIN usuarios u ON cu.user_id = u.id WHERE c.id = $this->intIdColegio";
        $request = $this->select($sql);
        return $request;
    }

    public function insertColegio(string $nombre, string $rut, string $direccion, string $telefono) {
        $return = 0;
        $this->strNombre = $nombre;
        $this->strRut = $rut;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $sql = "SELECT * FROM colegios WHERE rut = '{$this->strRut}' ";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO colegios (nombre, rut, direccion, telefono, status) VALUES (?,?,?,?,1)";
            $arrData = array($this->strNombre,
                $this->strRut,
                $this->strDireccion,
                $this->strTelefono);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateColegio($id, $nombre, $rut, $direccion, $telefono) {
        $this->intIdcolegio = $id;
        $this->strNombre = $nombre;
        $this->strRut = $rut;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $sql = "SELECT * FROM colegios WHERE id != $this->intIdcolegio AND nombre = '$this->strNombre'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE colegios SET nombre = ?, rut = ?, direccion = ?, telefono = ? WHERE id = $this->intIdColegio";
            $arrData = array($this->strNombre,
                $this->strRut,
                $this->strDireccion,
                $this->strTelefono);
            $request_update = $this->update($query_update, $arrData);
            $return = $request_update;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateStatusColegio($id, $status) {
        $this->intIdcolegio = $id;
        $this->intStatus = $status;
        $sql = "SELECT * FROM colegios_usuarios WHERE colegio_id = $this->intIdcolegio";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE colegios SET status = ? WHERE id = $this->intIdcolegio";
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
