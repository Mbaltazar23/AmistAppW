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
        $data['page_tag'] = NOMBRE_WEB . "- Admins Colegio";
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
            $btnSchool = '';
            $arrData[$i]["nro"] = ($i + 1);
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver administrador"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar administrador"><i class="fas fa-pencil-alt"></i></button>';
                $btnSchool = '<button class="btn btn-dark btn-sm" onClick="fntSchoolA(' . $arrData[$i]['id'] . ')" title="Vincular Colegio"><i class="fas fa-school"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar administrador"><i class="far fa-trash-alt"></i></button>';
            } else if ($arrData[$i]['status'] == 2) {
                $arrData[$i]['status'] = '<span class="badge badge-dark">Vinculado</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver administrador"><i class="far fa-eye"></i></button>';
                $btnSchool = '<button class="btn btn-dark btn-sm" onClick="fntSchoolU(' . $arrData[$i]['id'] . ')" title="Editar Colegio"><i class="fas fa-school"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar administrador"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelSchool(' . $arrData[$i]['id'] . ')" title="Eliminar Colegio"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver administrador" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar administrador" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnSchool = '<button class="btn btn-secondary btn-sm" onClick="fntSchoolA(' . $arrData[$i]['id'] . ')" title="Vincular Colegio" disabled><i class="fas fa-school"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['id'] . ')" title="Activar administrador"><i class="fas fa-check"></i></button>';
            }
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnSchool . ' ' . $btnDelete . '</div>';
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
                $strEmail = ucwords($_POST['txtEmail']);
                $strPassword = md5($_POST['txtNombre'] . 1234);
                $strDni = $_POST['txtDni'];
                $strDireccion = isset($_POST["txtDireccion"]) ? strClean(ucfirst($_POST['txtDireccion'])) : "";
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
    
     public function setDetailColegio() {
        if ($_POST) {
            if (empty($_POST['listColegios'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdColegio = intval($_POST['listColegios']);
                $intIdVinCulo = intval($_POST["idVinCol"]);
                $intIdUsuario = intval($_POST["idAdminC"]);
                $request_detail_colegio = "";
                if ($intIdVinCulo == 0) {
                    $request_detail_colegio = $this->model->insertDetailSchool($intIdUsuario, $intIdColegio);
                    $option = 1;
                } else {
                    $request_detail_colegio = $this->model->updateDetailSchool($intIdUsuario, $intIdColegio, $intIdVinCulo);
                    $option = 2;
                }

                if ($request_detail_colegio > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Colegio vinculado Exitosamente !!');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Colegio actualizado Exitosamente !!');
                    }
                } else if ($request_detail_colegio == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! El colegio ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function removeSchoolAdmin() {
        if ($_POST) {
            $intIdadmin = intval($_POST['idAdmin']);
            $requestDelete = $this->model->removeDetailSchool($intIdadmin);
            if ($requestDelete == 'ok') {
                $arrResponse = array('status' => true, 'msg' => "Colegio Removido Exitosamente...");
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible remover este colegio por ya estar en uso..');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar/activar el administrador.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
