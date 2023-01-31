<?php

/**
 * Description of Notificaciones
 *
 * @author mario
 */
class Notificaciones extends Controllers {

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

    public function notificaciones() {
        $data['page_tag'] = NOMBRE_WEB . "- Notificaciones";
        $data['page_title'] = "Notificaciones";
        $data['page_name'] = "notificaciones";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_notificaciones.js";
        $this->views->getView($this, "notificaciones", $data);
    }

    public function getNotificaciones() {
        $arrData = $this->model->selectNotificaciones();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrData[$i]["nro"] = ($i + 1);
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">En Espera</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver Notificacion"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar Notificacion"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar Notificacion"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver Notificacion" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar Notificacion" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['id'] . ')" title="Activar Notificacion"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setNotificacion() {
        if ($_POST) {
            if (empty($_POST['listTipoNotificacion'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getNotificacion() {
        
    }

}
