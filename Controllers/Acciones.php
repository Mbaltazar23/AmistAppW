<?php

/**
 * Description of Acciones
 *
 * @author mario
 */
class Acciones extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function acciones() {
        $data['page_tag'] = NOMBRE_WEB . "- Acciones";
        $data['page_title'] = "Acciones";
        $data['page_name'] = "acciones";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_acciones.js";
        $this->views->getView($this, "acciones", $data);
    }

    public function setAccion() {
        if ($_POST) {
            if (empty($_POST['txtNombre'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdAccion = intval($_POST['idAccion']);
                $strAccion = ucwords(strClean($_POST['txtNombre']));
                $request_accion = "";
                if ($intIdAccion == 0) {
                    //Crear
                    $request_accion = $this->model->insertAccion($strAccion);
                    $option = 1;
                } else {
                    //Actualizar
                    $request_accion = $this->model->updateAccion($intIdAccion, $strAccion);
                    $option = 2;
                }
                if ($request_accion > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Acción registrada Exitosamente !!');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Acción actualizada Exitosamente !!');
                    }
                } else if ($request_accion == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La acción ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getAcciones() {
        $arrData = $this->model->selectAcciones();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrData[$i]["nro"] = ($i + 1);
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . ($i + 1) . ',' . $arrData[$i]['id'] . ')" title="Ver acción"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar acción"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar acción"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . ($i + 1) . ',' . $arrData[$i]['id'] . ')" title="Ver acción" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar acción" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['id'] . ')" title="Activar acción"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . '  ' . $btnEdit . '  ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getAccion($IdAccion) {
        $intIdAccion = intval($IdAccion);
        if ($intIdAccion > 0) {
            $arrData = $this->model->selectAccion($intIdAccion);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setStatusAccion() {
        if ($_POST) {
            $intIdAccion = intval($_POST['idAccion']);
            $status = intval($_POST['status']);
            $requestDelete = $this->model->updateStatusAccion($intIdAccion, $status);
            if ($requestDelete == 'ok') {
                if ($status == 0) {
                    $arrResponse = array('status' => true, 'msg' => "Accion Inhabilitada Exitosamente...");
                } else {
                    $arrResponse = array('status' => true, 'msg' => "Accion Habiitada Exitosamente...");
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar esta acción..');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar/activar la acción.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectAcciones() {
        $htmlOptions = "";
        $arrData = $this->model->selectAcciones(1);
        echo '<option value="0">Seleccione una acción</option>';
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getAccionesReport() {
        $listAcciones = $this->model->selectAcciones();
        echo json_encode($listAcciones, JSON_UNESCAPED_UNICODE);
    }

}
