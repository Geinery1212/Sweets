<?php
if (!isset($_SESSION)) {
    session_start();
}
ob_start(); // SOLUCIÓN DE SOBREACARGA DEL HEADER
require 'ecommerce/config/ConnectionDB.php';
require 'autoload.php';
require 'ecommerce/helpers/Utils.php';
require 'ecommerce/config/parameters.php';
require_once 'ecommerce/views/layout/header.php';

function show_error()
{
    $error = new ErrorController();
    $error->index();
}

if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = controller_default;
} else {
    show_error();
    exit();
}

if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = action_default;
        $controlador->$action_default();
    } else {
        show_error();
    }
} else {
    show_error();
}

require 'ecommerce/views/layout/footer.php';
