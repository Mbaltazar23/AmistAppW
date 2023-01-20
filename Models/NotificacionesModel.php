<?php

/**
 *
 * @author mario
 */
class NotificacionesModel extends Mysql {

    public $intIdNotificacion;
    public $intUserId;
    public $strMensaje;
    public $intStatus;

    public function __construct() {
        parent::__construct();
    }

    public function selectNotificaciones($option = NULL) {
        $this->intStatus = $option != NULL ? "WHERE status != 0" : "";
        $sql = "SELECT n.id, n.mensaje, n.status, u.email FROM notificaciones n 
                INNER JOIN usuario_notificaciones un ON n.id = un.notificacion_id 
                INNER JOIN usuarios u ON un.user_id = u.id $this->intStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectNotificacion(int $idNotificacion) {
        $this->intIdNotificacion = $idNotificacion;
        $sql = "SELECT n.id, n.mensaje, n.status, u.email FROM notificaciones n 
                INNER JOIN usuario_notificaciones un ON n.id = un.notificacion_id 
                INNER JOIN usuarios u ON un.user_id = u.id WHERE n.id = $this->intIdNotificacion";
        $request = $this->select($sql);
        return $request;
    }

    public function insertNotificacion(string $mensaje) {
        $this->strMensaje = $mensaje;
        $return = 0;
        $sql = "SELECT * FROM notificaciones WHERE mensaje = '$this->strMensaje'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO notificaciones (mensaje, status) VALUES (?,?,1)";
            $arrData = array($this->strMensaje);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exits";
        }
        return $request_insert;
    }

    public function updateNotificacion(int $id, string $mensaje) {
        $this->intId = $id;
        $this->strMensaje = $mensaje;
        $return = 0;
        $sql = "SELECT * FROM notificaciones WHERE mensaje = '$this->strMensaje'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE notificaciones SET  mensaje = ? WHERE id = $this->intId";
            $arrData = array($this->strMensaje);
            $return = $this->update($query_update, $arrData);
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateStatusNotificaciones(int $id, int $status) {
        $this->intIdNotificacion = $id;
        $this->intStatus = $status;
        $sql = "SELECT * FROM usuario_notificaciones WHERE notificacion_id = $this->intIdNotificacion";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE notificaciones SET status = ? WHERE id = $this->intIdNotificacion";
            $arrData = array($this->intStatus);
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
