<?php


class NotificacionesModel extends Mysql {

    private $idNotificacion;
    private $idPregunta;
    private $mensajeNotificacion;
    private $preguntaNotificacion;
    private $respuestaNotificacion;
    private $consejoNotificacion;
    private $tipoNotificacion;
    private $puntosNotificacion;
    private $statusNotificacion;

    public function __construct() {
        parent::__construct();
    }

    public function selectNotificaciones($opcion = NULL) {
        $validateStatus = "";
        if ($opcion != NULL) {
            $validateStatus = "WHERE status != 0";
        }
        $sql = "SELECT id, mensaje, tipo, DATE_FORMAT(created_at, '%d/%m/%Y') as fecha, 
            DATE_FORMAT(created_at, '%H:%i:%s') as hora,status FROM notificaciones $validateStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectNotificacion(int $idNotificacion) {
        $this->idNotificacion = $idNotificacion;
        $sql = "SELECT id, mensaje, tipo, DATE_FORMAT(created_at, '%d/%m/%Y') as fecha, 
            DATE_FORMAT(created_at, '%H:%i:%s') as hora, status FROM notificaciones WHERE id = $this->idNotificacion";
        $request = $this->select($sql);
        return $request;
    }

    public function insertNotificacion(string $mensajeNotificacion, string $tipoNotificacion, int $puntosNotificacion) {
        $this->mensajeNotificacion = $mensajeNotificacion;
        $this->puntosNotificacion = $puntosNotificacion;
        $this->tipoNotificacion = $tipoNotificacion;
        $return = 0;
        $sql = "SELECT * FROM notificaciones WHERE mensaje = '$this->mensajeNotificacion'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO notificaciones (mensaje, tipo, puntos) VALUES (?,?,?)";
            $arrData = array($this->mensajeNotificacion,
                $this->tipoNotificacion,
                $this->puntosNotificacion);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateNotificacion(int $idNotificacion, string $tipoNotificacion, string $mensajeNotificacion) {
        $this->idNotificacion = $idNotificacion;
        $this->mensajeNotificacion = $mensajeNotificacion;
        $this->tipoNotificacion = $tipoNotificacion;
        $sql = "SELECT * FROM notificaciones WHERE mensaje = '$this->mensajeNotificacion' AND id != $this->idNotificacion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sqlU = "UPDATE notificaciones SET mensaje = ?, tipo = ? WHERE id = $this->idNotificacion";
            $arrData = array($this->mensajeNotificacion,
                $this->tipoNotificacion);
            $request = $this->update($sqlU, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function insertQuestion(int $idNotificacion, string $pregunta) {
        $this->idNotificacion = $idNotificacion;
        $this->preguntaNotificacion = $pregunta;
        $sql = "INSERT INTO preguntas(pregunta, notificacion_id) VALUES (?,?)";
        $arrData = array($this->preguntaNotificacion,
            $this->idNotificacion);
        $request_insert = $this->insert($sql, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function insertAnswer(int $idQuestion, string $respuesta, string $consejo) {
        $this->idPregunta = $idQuestion;
        $this->respuestaNotificacion = $respuesta;
        $this->consejoNotificacion = $consejo;
        $sql = "INSERT INTO respuestas(pregunta_id,respuesta,consejo) VALUES (?,?,?)";
        $arrData = array($this->idPregunta,
            $this->respuestaNotificacion,
            $this->consejoNotificacion);
        $request_insert = $this->insert($sql, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function updateStatusNotificaciones(int $id, int $status) {
        $this->idNotificacion = $id;
        $this->statusNotificacion = $status;
        $sql = "SELECT * FROM usuario_notificaciones WHERE notificacion_id = $this->idNotificacion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE notificaciones SET status = ? WHERE id = $this->statusNotificacion";
            $arrData = array($this->statusNotificacion);
            $request = $this->update($query_update, $arrData);
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
