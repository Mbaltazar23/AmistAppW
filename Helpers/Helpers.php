<?php

//Retorla la url del proyecto
function base_url() {
    return BASE_URL;
}

//Retorla la url de Assets
function media() {
    return BASE_URL . "/Assets";
}

function headerLogin($data = "") {
    $view_header = "Views/Template/Login/header.php";
    require_once ($view_header);
}

function footerLogin($data = "") {
    $view_footer = "Views/Template/Login/footer.php";
    require_once ($view_footer);
}

function headerAdmin($data = "") {
    $view_header = "Views/Template/Dashboard/header_admin.php";
    require_once ($view_header);
}

function footerAdmin($data = "") {
    $view_footer = "Views/Template/Dashboard/footer_admin.php";
    require_once ($view_footer);
}

//Muestra información formateada
function dep($data) {
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function darFormatoFecha($fechaTex) {
    $fecha = substr($fechaTex, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombreMes . " de " . $anio;
}

function getModal(string $nameModal, $data) {
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}

//Envio de correos
function sendEmail($data, $template) {
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}

//metodo que servira para la subida de imagenes
function uploadImage(array $data, string $name, string $ruta) {
    $url_temp = $data['tmp_name'];
    $destino = 'Assets/img/' . $ruta . '/' . $name;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function deleteFile(string $name, string $ruta) {
    unlink($destino = 'Assets/img/' . $ruta . '/' . $name);
}

//Elimina exceso de espacios entre palabras
function strClean($strCadena) {
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

//Genera una contraseña de 10 caracteres
function passGenerator($length = 10) {
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

//Genera un token
function token() {
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}

//Formato para valores monetarios
function formatMoney($cantidad) {
    $cantidad = number_format($cantidad, 0, SPD, SPM);
    return $cantidad;
}

function clear_cadena(string $cadena) {
    //Reemplazamos la A y a
    $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'), array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'), $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'), array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'), $cadena);

    //Reemplazamos la I y i
    $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'), array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'), $cadena);

    //Reemplazamos la O y o
    $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'), array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'), $cadena);

    //Reemplazamos la U y u
    $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'), array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'), $cadena);

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç', ',', '.', ';', ':'), array('N', 'n', 'C', 'c', '', '', '', ''), $cadena
    );
    return $cadena;
}

function getFile(string $url, $data) {
    ob_start();
    require_once("Views/{$url}.php");
    $file = ob_get_clean();
    return $file;
}

function Meses() {
    $meses = array("Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre");
    return $meses;
}

function navDashboardAdmin() {
    $navAdmin = "";
    if ($_SESSION['rol'] == ROLADMIN) {
        $navAdmin = array(
            "Canjeo de Puntos" => array(
                "icon" => "fas fa-regular fa-award",
                "submodulos" => array(
                    "Acciones" => array("pagina" => "acciones"),
                    "Notificaciones" => array("pagina" => "notificaciones")
                )
            ),
            "Educacion" => array(
                "icon" => "fas fa-solid fa-school",
                "submodulos" => array(
                    "Adminstrador(s) Colegio" => array("pagina" => "admincolegio"),
                    "Colegios" => array("pagina" => "colegios")
                )
            ),
            "Catalogo" => array(
                "icon" => "fas fa-solid fa-store",
                "submodulos" => array(
                    "Categorias" => array("pagina" => "categorias"),
                    "Productos" => array("pagina" => "productos")
                )
            )
        );
    }
    return $navAdmin;
}

?>