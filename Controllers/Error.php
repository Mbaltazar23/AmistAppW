<?php

class Errors extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function notFound() {
        $data['page_tag'] = NOMBRE_WEB . "- Pagina no Encontrada";
        $data['page_title'] = NOMBRE_WEB;
        $data['page_name'] = "error";
        $this->views->getView($this, "error", $data);
    }

}

$notFound = new Errors();
$notFound->notFound();
?>