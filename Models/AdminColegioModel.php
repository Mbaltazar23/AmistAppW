<?php

/**
 * Description of AdminColegioModel
 *
 * @author mario
 */
class AdminColegioModel extends Mysql {

    public $intIdUsuario;
    public $strEmail;
    public $strPassword;
    public $strDni;
    public $strDireccion;
    public $strTelefono;
    public $intStatus;
    public $strRole;

    public function __construct() {
        parent::__construct();
    }

    public function selectAdmins($option = NULL) {
        $this->intStatus = $option != NULL ? " AND usuarios.status != 0" : "";
        $this->strRole = ROLADMINCOLE;
        $sql = "SELECT usuarios.id, usuarios.email, usuarios.dni, usuarios.direccion, usuarios.telefono, usuarios.status, roles_usuarios.role 
                FROM usuarios INNER JOIN roles_usuarios ON usuarios.id = roles_usuarios.user_id 
                WHERE roles_usuarios.role = '$this->strRole' $this->intStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertAdmin(string $email, string $password, string $dni, string $direccion, string $telefono, int $status, string $role) {
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->strDni = $dni;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $this->intStatus = $status;
        $this->strRole = $role;
        $return = 0;
        $sql = "SELECT * FROM usuarios WHERE email = '{$this->strEmail}' OR dni = '{$this->strDni}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(email,password,dni,direccion,telefono,status) VALUES(?,?,?,?,?,?)";
            $arrData = array($this->strEmail,
                $this->strPassword,
                $this->strDni,
                $this->strDireccion,
                $this->strTelefono,
                $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $query_insert_role = "INSERT INTO roles_usuarios (user_id, role) VALUES (?,?)";
            $arrData_role = array($request_insert, $this->strRole);
            $this->insert($query_insert_role, $arrData_role);

            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateAdmin(int $idusuario, string $email, string $password, string $dni, string $direccion, string $telefono) {
        $this->intIdusuario = $idusuario;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->strDni = $dni;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $sql = "SELECT * FROM usuarios WHERE email = '{$this->strEmail}' OR id != '{$this->intIdUsuario}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE usuarios SET email = ?, password = ?, dni = ?, direccion = ?, telefono = ? WHERE id = $this->intIdusuario";
            $arrData = array($this->strEmail,
                $this->strPassword,
                $this->strDni,
                $this->strDireccion,
                $this->strTelefono);
            $request = $this->update($query_update, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function updateStatusAdmin(int $idusuario, int $status) {
        $this->intIdusuario = $idusuario;
        $this->intStatus = $status;
        $sql = "SELECT * FROM colegios_usuarios WHERE user_id = $this->idAccion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_delete = "UPDATE usuarios SET status = ? WHERE id = $this->intIdusuario";
            $request = $this->update($query_delete, $this->intStatus);
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
