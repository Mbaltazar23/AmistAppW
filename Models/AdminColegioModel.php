<?php

/**
 * Description of AdminColegioModel
 *
 * @author mario
 */
class AdminColegioModel extends Mysql {

    public $intIdUsuario;
    public $intIdColegio;
    public $intIdVin;
    public $strNombre;
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
        $this->intStatus = $option != NULL ? " AND usr.status != 0" : "";
        $this->strRole = ROLADMINCOLE;
        $sql = "SELECT usr.id, usr.nombre, usr.email, usr.dni, usr.direccion, usr.telefono, usr.status, rl.role 
                FROM usuarios usr INNER JOIN roles_usuarios rl ON usr.id = rl.user_id 
                WHERE rl.role = '$this->strRole' $this->intStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectAdmin(int $idUser) {
        $this->intIdUsuario = $idUser;
        $sql = "SELECT usr.id, usr.nombre, usr.email, usr.dni, usr.direccion,
                usr.telefono, DATE_FORMAT(usr.created_at, '%d/%m/%Y') as fecha, DATE_FORMAT(usr.created_at, '%H:%i:%s') as hora,
                usr.status, rl.role FROM usuarios usr INNER JOIN roles_usuarios rl ON usr.id = rl.user_id 
                WHERE usr.id = $this->intIdUsuario";
        $request = $this->select($sql);
        if ($request["status"] != 1) {
            $sqlSchool = "SELECT cu.id as idVin, c.id,c.rut,c.nombre FROM colegios_usuarios cu 
                    INNER JOIN colegios c ON cu.colegio_id = c.id WHERE cu.user_id = $this->intIdUsuario";
            $requesSch = $this->select($sqlSchool);
            $request["school"] = $requesSch;
        }

        return $request;
    }

    public function insertAdmin(string $nombre, string $email, string $password, string $dni, string $direccion, string $telefono, string $role) {
        $this->strNombre = $nombre;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->strDni = $dni;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $this->strRole = $role;
        $return = 0;
        $sql = "SELECT * FROM usuarios WHERE email = '{$this->strEmail}' AND dni = '{$this->strDni}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(nombre,email,password,dni,direccion,telefono) VALUES(?,?,?,?,?,?)";
            $arrData = array($this->strNombre,
                $this->strEmail,
                $this->strPassword,
                $this->strDni,
                $this->strDireccion,
                $this->strTelefono);
            $request_insert = $this->insert($query_insert, $arrData);
            $query_insert_role = "INSERT INTO roles_usuarios (user_id, role) VALUES (?,?)";
            $arrData_role = array($request_insert,
                $this->strRole);
            $this->insert($query_insert_role, $arrData_role);

            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateAdmin(int $idusuario, string $nombre, string $email, string $password, string $dni, string $direccion, string $telefono) {
        $this->intIdUsuario = $idusuario;
        $this->strNombre = $nombre;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->strDni = $dni;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $sql = "SELECT * FROM usuarios WHERE id != $this->intIdUsuario AND email = '{$this->strEmail}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE usuarios SET nombre = ?, email = ?, password = ?, dni = ?,"
                    . " direccion = ?, telefono = ? WHERE id = $this->intIdUsuario";
            $arrData = array($this->strNombre,
                $this->strEmail,
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

    public function insertDetailSchool(int $idUsuario, int $idColegio) {
        $this->intIdUsuario = $idUsuario;
        $this->intIdColegio = $idColegio;
        $return = 0;
        $sql = "SELECT * FROM colegios_usuarios WHERE user_id = $this->intIdUsuario AND colegio_id = $this->intIdColegio";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO colegios_usuarios (user_id, colegio_id) VALUES (?,?)";
            $arrData = array($this->intIdUsuario,
                $this->intIdColegio);
            $return = $this->insert($query_insert, $arrData);
            $sqlUpdate = "UPDATE usuarios SET status = ? WHERE id = $this->intIdUsuario";
            $arrData = array(1);
            $this->update($sqlUpdate, $arrData);
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateDetailSchool(int $idUsuario, int $idColegio, int $idVin) {
        $this->intIdUsuario = $idUsuario;
        $this->intIdColegio = $idColegio;
        $this->intIdVin = $idVin;
        $sql = "SELECT * FROM colegios_usuarios WHERE colegio_id = $this->intIdColegio AND id != $this->intIdVin";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE colegios_usuarios SET colegio_id = ?, user_id = ? WHERE id = $this->intIdVin";
            $arrData = array($this->intIdColegio,
                $this->intIdUsuario);
            $request = $this->update($query_update, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function removeDetailSchool(int $idUsuario) {
        $this->intIdUsuario = $idUsuario;
        $sqlSelect = "SELECT * FROM colegios_usuarios WHERE user_id = $this->intIdUsuario";
        $requestUser = $this->select($sqlSelect);
        $this->intIdColegio = $requestUser["colegio_id"];
        $sql = "SELECT * FROM cursos WHERE school_id = $this->intIdColegio";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_delete = "DELETE FROM colegios_usuarios WHERE user_id = $this->intIdUsuario";
            $request = $this->delete($query_delete);
            if ($request) {
                $request = 'ok';
                $sqlUpdate = "UPDATE usuarios SET status = ? WHERE id = $this->intIdUsuario";
                $arrData = array(1);
                $this->update($sqlUpdate, $arrData);
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }

    public function updateStatusAdmin(int $idusuario, int $status) {
        $this->intIdUsuario = $idusuario;
        $this->intStatus = $status;
        $sql = "SELECT * FROM colegios_usuarios WHERE user_id = $this->intIdUsuario";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_delete = "UPDATE usuarios SET status = ? WHERE id = $this->intIdUsuario";
            $arrData = array($this->intStatus);
            $request = $this->update($query_delete, $arrData);
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
