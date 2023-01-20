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
        $data['page_tag'] = "Dashboard -" . TITLE_ADMIN;
        $data['page_title'] = "Dashboard -" . TITLE_ADMIN;
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
        $data['page_tag'] = "Dashboard: Perfil -" . TITLE_ADMIN;
        $data['page_title'] = "Dashboard: Perfil -" . TITLE_ADMIN;

        $data['page_name'] = "perfil";
        $data["imgPerfil"] = "";
        if ($_SESSION["rol"] == ROLADMIN) {
            $data["imgPerfil"] = "avatar5.png";
        } else if ($_SESSION["rol"] == ROLPROFE) {
            $data["imgPerfil"] = "avatar5.png";
        } else {
            $data["imgPerfil"] = "avatarAlum.jpg";
        }
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_perfil.js";
        $this->views->getView($this, "profile", $data);
    }

}

?>