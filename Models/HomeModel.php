<?php

class HomeModel extends Mysql {

    private $id;
    private $rol;
    private $dni;
    private $nombre;
    private $correo;
    private $telefono;
    private $contrasena;
    private $direccion;

    public function __construct() {
        parent::__construct();
    }

    public function login(string $dni, string $password) {
        $this->dni = $dni;
        $this->contrasena = $password;
        $sql = "SELECT user.id,user.dni, user.nombre, user.email, user.password, user.status "
                . "FROM usuarios user WHERE user.dni = '$this->dni' AND user.password = '$this->contrasena'";
        $request = $this->select($sql);
        return $request;
    }

    public function sessionLogin(int $iduser) {
        $this->id = $iduser;
        //BUSCAR USUARIO 
        $sql = "SELECT user.id,user.dni, user.nombre, user.email,user.telefono, user.password, user.created_at, user.direccion,"
                . " user.status, r.role as nombreRol, user.status FROM usuarios user INNER JOIN roles_usuarios r ON user.id = r.user_id "
                . "WHERE user.id = $this->id";
        $request = $this->select($sql);
        $_SESSION['userData'] = $request;

        if ($_SESSION['userData']["nombreRol"] == ROLADMIN) {
            $_SESSION['userData']["imgPerfil"] = "avatar5.png";
        } else if ($_SESSION["rol"] == ROLPROFE) {
            $_SESSION['userData']["imgPerfil"] = "avatar5.png";
        } else {
            $_SESSION['userData']["imgPerfil"] = "avatarAlum.jpg";
        }

        return $request;
    }

    public function registerAlum(string $dni, string $nombre, string $correo, string $telefono, string $contrasna, string $direccion, int $rol) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->contrasena = $contrasna;
        $this->direccion = $direccion;
        $this->rol = $rol;
        $sql = "SELECT * FROM usuarios WHERE dni = '$this->dni' AND email = '$this->correo'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(dni, nombre, email, telefono,password, direccion) VALUES (?,?,?,?,?,?)";
            $arrData = array($this->dni,
                $this->nombre,
                $this->correo,
                $this->telefono,
                $this->contrasena,
                $this->direccion);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

}

?>