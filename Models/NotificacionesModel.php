<?php

/**
 *
 * @author mario
 */
class NotificacionesModel extends Mysql {

    private $idNotificacion;
    private $mensajeNotificacion;
    private $tipoNotificacion;
    private $puntosNotificacion;
    private $statusNotificacion;

    public function __construct() {
        parent::__construct();
    }

    public function selectNotificaciones($opcion = NULL) {
        $validateStatus = "";
        if ($opcion != NULL) {
            $validateStatus = "WHERE statusNotificacion != 0";
        }
        $sql = "SELECT * FROM notificaciones $validateStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectNotificacion(int $idNotificacion) {
        $this->idNotificacion = $idNotificacion;
        $sql = "SELECT * FROM notificaciones WHERE id = $this->idNotificacion";
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
            $query_insert = "INSERT INTO notificaciones (mensaje,tipo, puntos) VALUES (?,?,?)";
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

    public function updateNotificacion(int $idNotificacion, string $tipoNotificacion, string $mensajeNotificacion, int $puntosNotificacion) {
        $this->idNotificacion = $idNotificacion;
        $this->mensajeNotificacion = $mensajeNotificacion;
        $this->puntosNotificacion = $puntosNotificacion;
        $this->tipoNotificacion = $tipoNotificacion;
        $sql = "SELECT * FROM notificaciones WHERE mensaje = '$this->mensajeNotificacion' AND id != $this->idNotificacion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sqlU = "UPDATE notificaciones SET mensaje= ?,tipo = ?, puntos= ? WHERE id = $this->idNotificacion";
            $arrData = array($this->mensajeNotificacion,
                $this->tipoNotificacion,
                $this->puntosNotificacion);
            $request = $this->update($sqlU, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
    
    public function insertQuestion(int $idNotificacion, string $pregunta) {
        
    }
    
    public function insertAnswer(int $idQuestion, string $respuesta, string $consejo) {
        
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
