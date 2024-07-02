<?php
if (!isset($_SESSION)) {
    session_start();
}

//No redirecciones go back para prevenir errores 
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
header('Pragma: no-cache'); // HTTP 1.0
header('Expires: 0'); // Proxies

define('base_url', 'https://enjoyyoursweets.000webhostapp.com/ecommerce/');
define('pagination_url', 'https://enjoyyoursweets.000webhostapp.com/');
define('controller_default', 'ProductoController');
define('action_default', 'index');
define('imagen_defecto', 'https://enjoyyoursweets.000webhostapp.com/assets/img/imagen-defecto.png');
