<?php


/**
 * Description of Acciones
 *
 * @author mario
 */
class Acciones extends Controllers{

     public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }
    
    public function acciones() {
        
    }
    
    public function setAccion() {
        
    }
    
    public function getAcciones() {
        
    }
    
    public function getAccion($IdAccion) {
        
    }
    
    public function setStatusAccion() {
        
    }
    
    public function getSelectAcciones() {
        
    }
}
