<?php

class Dashboard extends Controllers {

    public function __construct() {
        parent::__construct();
    }

    public function dashboard() {
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
        $data['page_tag'] = NOMBRE_WEB . " - Dashboard";
        $data['page_title'] = NOMBRE_WEB . "- dashboard";
        $data['page_name'] = "dashboard";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_dashboard.js";
        $this->views->getView($this, "dashboard", $data);
    }

    public function profile() {
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
        $data['page_tag'] = NOMBRE_WEB . "- Perfil";
        $data['page_title'] = NOMBRE_WEB . "- perfil";

        $data['page_name'] = "perfil";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_perfil.js";
        $this->views->getView($this, "profile", $data);
    }

}

?>