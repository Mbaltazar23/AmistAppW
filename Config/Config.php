<?php

const BASE_URL = "http://localhost/AmistAppWeb";

//Zona horaria
date_default_timezone_set('America/Santiago');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "amistapp";
const DB_USER = "root";
const DB_PASSWORD = "1234";
const DB_CHARSET = "utf8";
//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";
//Simbolo de moneda
const SMONEY = "$";
//Datos envio de correo
const TITLE = "AmistApp - Pagina";
const TITLE_ADMIN = "Panel Administrativo";
const NOMBRE_WEB= "AmistApp";
const WEB_EMPRESA = "www.AmistApp.com";
//metodo de encriptacion
const KEY = 'mbaltazar';
const METHODENCRIPT = "AES-128-ECB";


const ROLADMIN = "Administrador";
const ROLADMINCOLE = "Adminitrador de Colegio";
const ROLALU = "Alumno";
const ROLPROFE = "Profesor";
?>