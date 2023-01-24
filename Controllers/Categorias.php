<?php

class Categorias extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function Categorias() {
        $data['page_tag'] = TITLE_ADMIN . "- Categorias";
        $data['page_title'] = "Categorias";
        $data['page_name'] = "categorias";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_categorias.js";
        $this->views->getView($this, "categorias", $data);
    }

    public function setCategoria() {
        if ($_POST) {
            if (empty($_POST['txtNombre'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdcategoria = intval($_POST['idCategoria']);
                $strCategoria = ucwords(strClean($_POST['txtNombre']));
                $request_categoria = "";
                if ($intIdcategoria == 0) {
                    //Crear
                    $request_categoria = $this->model->insertCategoria($strCategoria);
                    $option = 1;
                } else {
                    //Actualizar
                    $request_categoria = $this->model->updateCategoria($intIdcategoria, $strCategoria);
                    $option = 2;
                }
                if ($request_categoria > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Categoria registrada Exitosamente !!');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Categoria actualizada Exitosamente !!');
                    }
                } else if ($request_categoria == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La categoría ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getCategorias() {
        $arrData = $this->model->selectCategorias();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrData[$i]["nro"] = ($i + 1);
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . ($i + 1) . ',' . $arrData[$i]['id'] . ')" title="Ver categoría"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . ($i + 1) . ',' . $arrData[$i]['id'] . ')" title="Ver categoría" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar categoría" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['id'] . ')" title="Activar categoría"><i class="fas fa-toggle-on"></i></button>';
            }

            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . '  ' . $btnEdit . '  ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getCategoria($idcategoria) {
        $intIdcategoria = intval($idcategoria);
        if ($intIdcategoria > 0) {
            $arrData = $this->model->selectCategoria($intIdcategoria);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setStatusCategoria() {
        if ($_POST) {
            $intIdcategoria = intval($_POST['idCategoria']);
            $status = intval($_POST['status']);
            $requestDelete = $this->model->updateStatusCategoria($intIdcategoria, $status);
            if ($requestDelete == 'ok') {
                if ($status == 0) {
                    $arrResponse = array('status' => true, 'msg' => "Categoria Inhabilitada Exitosamente...");
                } else {
                    $arrResponse = array('status' => true, 'msg' => "Categoria Habiitada Exitosamente...");
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar esta categoría..');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar/activar la categoría.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectCategorias() {
        $htmlOptions = "";
        $arrData = $this->model->selectCategorias(1);
        echo '<option value="0">Seleccione una categoria</option>';
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

}

?>