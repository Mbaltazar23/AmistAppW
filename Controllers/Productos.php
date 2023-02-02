<?php

class Productos extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function productos() {
        $data['page_tag'] = NOMBRE_WEB . "- Productos";
        $data['page_title'] = "Productos";
        $data['page_name'] = "productos";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_products.js";
        $this->views->getView($this, "productos", $data);
    }

    public function getProductos() {
        $arrData = $this->model->selectProductos();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver producto"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id'] . ')" title="Ver producto" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar producto" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActiveInfo(' . $arrData[$i]['id'] . ')" title="Activar producto"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]["nombreP"] = "<img src='" . media() . "/img/products/" . $arrData[$i]["imagen"] . "'alt='" . $arrData[$i]["nombre"] . "' class='img-circle img-size-32 mr-2'>" . $arrData[$i]["nombre"];

            $arrData[$i]['precioP'] = SMONEY . '' . formatMoney($arrData[$i]['precio']);


            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setProducto() {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['txtStock'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idProducto = intval($_POST['idProducto']);
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $intCategoriaId = intval($_POST['listCategoria']);
                $strPrecio = intval($_POST['txtPrecio']);
                $intStock = intval($_POST['txtStock']);

                $foto = $_FILES['foto'];
                $nombre_foto = $foto['name'];
                $imgPortada = 'product.png';
                if ($nombre_foto != '') {
                    $imgPortada = 'prod_' . md5(date('d-m-Y H:i:s')) . '.jpg';
                }


                $request_producto = "";

                if ($idProducto == 0) {
                    $option = 1;
                    $request_producto = $this->model->insertProducto($strNombre, $intCategoriaId, $strPrecio, $intStock, $imgPortada);
                } else {
                    if ($nombre_foto == '') {
                        if ($_POST['foto_actual'] != 'product.png' && $_POST['foto_remove'] == 0) {
                            $imgPortada = $_POST['foto_actual'];
                        }
                    }
                    $option = 2;
                    $request_producto = $this->model->updateProducto($idProducto, $strNombre, $intCategoriaId, $strPrecio, $intStock, $imgPortada);
                }
                if ($request_producto > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Producto Registrado Exitosamente !!');
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada, "products");
                        }
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Producto Actualizado Exitosamente !!');
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada, "products");
                        }

                        if (($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'product.png') || ($nombre_foto != '' && $_POST['foto_actual'] != 'product.png')) {
                            deleteFile($_POST['foto_actual'], "products");
                        }
                    }
                } else if ($request_producto == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el nombre Ingresado.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getProducto($id) {
        $idproducto = intval($id);
        if ($idproducto > 0) {
            $arrData = $this->model->selectProducto($idproducto);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrData['precioP'] = SMONEY . '' . formatMoney($arrData['precio']);
                $arrData['url_productImg'] = media() . '/img/products/' . $arrData['imagen'];
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setStatusProducto() {
        if ($_POST) {
            $intIdproducto = intval($_POST['idProducto']);
            $status = intval($_POST["status"]);
            $requestDelete = $this->model->updateStatusProducto($intIdproducto, $status);
            if ($requestDelete == 'ok') {
                if ($status == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha activado el producto');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado el producto');
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar este producto al ser uno preferido...');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar este produccto..');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>