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
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . ($i + 1) . "," . $arrData[$i]['id'] . ')" title="Ver Notificacion"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar Notificacion"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id'] . ')" title="Eliminar Notificacion"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . ($i + 1) . "," . $arrData[$i]['id'] . ')" title="Ver Notificacion" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id'] . ')" title="Editar Notificacion" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['id'] . ')" title="Activar Notificacion"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getQuestionsNotificacion($idNotificacion) {
        $intIdNotificacion = intval($idNotificacion);
        if ($intIdNotificacion > 0) {
            $arrData = $this->model->selectQuestions($intIdNotificacion);
            for ($i = 0; $i < count($arrData); $i++) {

                $arrData[$i]["nro"] = ($i + 1);
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditQuestionInfo(this,' . $arrData[$i]['id'] . ')" title="Editar Pregunta"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelQuestionInfo(' . $arrData[$i]['id'] . ')" title="Eliminar Pregunta"><i class="far fa-trash-alt"></i></button>';

                $arrData[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setNotificacion() {
        if ($_POST) {
            if (empty($_POST['listTipoNotificacion'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idNotificacion = intval($_POST["idNotificacion"]);
                $titleNotificacion = ucwords($_POST["title"]);
                $listTypeNotificacion = strClean($_POST["listTipoNotificacion"]);
                $Question = isset($_POST["Question"]) ? ucwords($_POST["Question"]) : ucwords($_POST["Message"]);
                $ArrAnswers = $_POST["Answers"];
                $idQuestion = isset($_POST["idQuestion"]) ? intval($_POST["idQuestion"]) : "";
                $Message = isset($_POST["Message"]) ? ucwords($_POST["Message"]) : "";
                $Response = isset($_POST["Response"]) ? ucfirst($_POST["Response"]) : "";
                $Advice = isset($_POST["Advice"]) ? ucfirst($_POST["Advice"]) : "";
                $request_notificacion = "";

                if ($idNotificacion == 0) {
                    $request_notificacion = $this->model->insertNotificacion($titleNotificacion, $listTypeNotificacion);
                    $option = 1;
                } else {
                    $request_notificacion = $this->model->updateNotificacion($idNotificacion, $titleNotificacion, $listTypeNotificacion);
                    $option = 2;
                }

                if ($request_notificacion > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Notificacion registrada Exitosamente !!');

                        if ($listTypeNotificacion == "Pregunta") {
                            $request_question = $this->model->insertQuestion($request_notificacion, $Question);

                            foreach ($ArrAnswers['answers'] as $answer) {
                                $respuesta = ucfirst($answer["answer"]);
                                $consejo = ucfirst($answer["advice"]);
                                $this->model->insertAnswer($request_question, $respuesta, $consejo);
                            }
                        } else {
                            $request_question = $this->model->insertQuestion($request_notificacion, $Message);

                            $this->model->insertAnswer($request_question, $Response, $Advice);
                        }
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Notificacion actualizada Exitosamente !!');
                    }
                } else if ($request_notificacion == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La notificacion ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getNotificacion($idNotificacion) {
        $intIdNotificacion = intval($idNotificacion);
        if ($intIdNotificacion > 0) {
            $arrData = $this->model->selectNotificacion($intIdNotificacion);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getQuestion($idQuestion) {
        $intIdQuestion = intval($idQuestion);
        if ($intIdQuestion > 0) {
            $arrData = $this->model->selectQuestion($intIdQuestion);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setStatusColegio() {
        if ($_POST) {
            $intIdNotificacion = intval($_POST['idNotificacion']);
            $status = intval($_POST['status']);
            $requestDelete = $this->model->updateStatusNotificaciones($intIdNotificacion, $status);
            if ($requestDelete == 'ok') {
                if ($status == 0) {
                    $arrResponse = array('status' => true, 'msg' => "Notificacion Inhabilitada Exitosamente...");
                } else {
                    $arrResponse = array('status' => true, 'msg' => "Notificacion Habiitada Exitosamente...");
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar esta notificacion..');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar/activar el colegio.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
