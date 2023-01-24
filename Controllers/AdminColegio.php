<?php

/**
 * Description of AdminColegio
 *
 * @author mario
 */
class AdminColegio extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol'])) {
            $rutaDefecto = '';
            if ($_SESSION['rol'] != ROLADMINCOLE) {
                $rutaDefecto = '/dashboard';
            }
            header('Location: ' . base_url() . $rutaDefecto);
            die();
        }
    }

    public function admincolegio() {
        $data['page_tag'] = TITLE_ADMIN . "- Admins Colegio";
        $data['page_title'] = "Administrador(s)/Colegios";
        $data['page_name'] = "administrador(s) de colegios";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_admincolegio.js";
        $this->views->getView($this, "admincolegio", $data);
    }

    public function getAdminsColegio() {
        $arrData = $this->model->selectAdmins();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrData[$i]["nro"] = ($i + 1);
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver administrador"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar administrador"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar administrador"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver administrador" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar administrador" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['id'] . ')" title="Activar administrador"><i class="fas fa-check"></i></button>';
            }
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setAdmin() {
        if ($_POST) {
            if (empty($_POST['txtEmail']) || empty($_POST['txtNombre']) || empty($_POST['txtDni']) || empty($_POST["txtTelefono"])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdAdmin = intval($_POST['idAdmin']);
                $strNombre = ucwords($_POST['txtNombre']);
                $strEmail = strClean(ucwords($_POST['txtEmail']));
                $strPassword = md5($_POST['txtNombre'] . 1234);
                $strDni = $_POST['txtDni'];
                $strDireccion = strClean(ucfirst($_POST['txtDireccion']));
                $strTelefono = $_POST['txtTelefono'];
                $strRole = ROLADMINCOLE;
                $request_admin = "";
                if ($intIdAdmin == 0) {
                    //Crear
                    $request_admin = $this->model->insertAdmin($strNombre, $strEmail, $strPassword, $strDni, $strDireccion, $strTelefono, $strRole);
                    $option = 1;
                } else {
                    //Actualizar
                    $request_admin = $this->model->updateAdmin($intIdAdmin, $strNombre, $strEmail, $strPassword, $strDni, $strDireccion, $strTelefono);
                    $option = 2;
                }
                if ($request_admin > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Administrador registrado Exitosamente !!');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Administrador actualizado Exitosamente !!');
                    }
                } else if ($request_admin == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! El administrador ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getAdminColegio($idadmin) {
        $intIdadmin = intval($idadmin);
        if ($intIdadmin > 0) {
            $arrData = $this->model->selectAdmin($intIdadmin);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setStatusAdmin() {
        if ($_POST) {
            $intIdadmin = intval($_POST['idAdmin']);
            $status = intval($_POST['status']);
            $requestDelete = $this->model->updateStatusAdmin($intIdadmin, $status);
            if ($requestDelete == 'ok') {
                if ($status == 0) {
                    $arrResponse = array('status' => true, 'msg' => "Admin Inhabilitado Exitosamente...");
                } else {
                    $arrResponse = array('status' => true, 'msg' => "Admin Habilitado Exitosamente...");
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar este administrador..');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar/activar el administrador.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
