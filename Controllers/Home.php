<?php

class Home extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function home() {
        $data['page_tag'] = NOMBRE_WEB . " - Inicio";
        $data['page_title'] = NOMBRE_WEB;
        $data['page_name'] = "home";
        $data['page_functions_js'] = "functions_home.js";
        $this->views->getView($this, "home", $data);
    }

    public function register() {
        $data['page_tag'] = NOMBRE_WEB . " - Nuevo Alumno";
        $data['page_title'] = NOMBRE_WEB;
        $data['page_name'] = "register";
        $data['page_functions_js'] = "functions_home.js";
        $this->views->getView($this, "register", $data);
    }

    public function loginUser() {
        //dep($_POST);
        if ($_POST) {
            if (empty($_POST['txtRut']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strUsuarioRut = $_POST['txtRut'];
                $strPassword = md5($_POST['txtPassword']);
                $requestUser = $this->model->login($strUsuarioRut, $strPassword);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El rut o la contraseña es incorrecto.');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['status'] != 0) {
                        $_SESSION['idUser'] = $arrData['id'];
                        $_SESSION['login'] = true;
                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        $_SESSION['rol'] = $arrData['nombreRol'];
                        $arrResponse = array('status' => true, 'msg' => 'ok', 'userData' => $arrData);
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function registerUser() {
        if ($_POST) {
            if (empty($_POST['txtNombreRegister']) || empty($_POST['txtApellidoRegister']) || empty($_POST['txtTelefonoRegister']) || empty($_POST['txtEmailRegister']) || empty($_POST['txtPassRegister'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $strNombre = ucwords(strClean($_POST['txtNombreRegister']));
                $strApellido = ucwords(strClean($_POST['txtApellidoRegister']));
                $strEmail = ucwords(strClean($_POST['txtEmailRegister']));
                $intTelefono = $_POST['txtTelefonoRegister'];
                $strPass = ucwords(strClean($_POST['txtPassRegister']));
                $intRolId = ROLCLIENTE;
                $estadoCliente = 1;
                $strComentario = "";
                if (!empty($_POST['txtComentRegister'])) {
                    $strComentario = ucwords(strClean($_POST['txtComentRegister']));
                }
                $strPassEncrypt = md5($strPass);
                $request_user = $this->insertCliente($strNombre, $strApellido, $intTelefono, $strEmail, $strPassEncrypt, $intRolId, $strComentario, $estadoCliente);
                if ($request_user > 0) {
                    $_SESSION['idUser'] = $request_user;
                    $_SESSION['login'] = true;
                    $_SESSION['rol'] = ROLCLI;
                    $arrData = $this->model->sessionLogin($request_user);
                    $this->insertNegocioDefault($_SESSION['idUser'], SINNEGOCIO, "");
                    sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.', 'userData' => $arrData);
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>