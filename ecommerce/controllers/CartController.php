<?php
require_once 'ecommerce/models/Producto.php';

class CartController
{

    function addToCart()
    {
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
            $index = 0;
            if (isset($_SESSION['carrito'])) {
                $counter = 0;
                foreach ($_SESSION['carrito'] as $indice => $elemento) {
                    if ($elemento['id_producto'] == $producto_id) {
                        $_SESSION['carrito'][$indice]['unidades']++;
                        $index = $indice;
                        $counter++;
                    }
                }
            }

            if (!isset($counter) || $counter == 0) {
                $producto = new Producto();
                $producto->setId($producto_id);
                $producto = $producto->getOne();

                if (is_object($producto)) {
                    $_SESSION['carrito'][] = array(
                        'id_producto' => $producto->id,
                        'precio' => $producto->precio,
                        'unidades' => 1,
                        'producto' => $producto
                    );
                }
            }
            $response = json_encode(['success' => true, 'producto' => $producto, 'quantity' => $_SESSION['carrito'][$index]['unidades']]);
            echo "<input id='response' type='text' value='$response'>";
        } else {
            $response = json_encode(['success' => false]);
            echo "<input id='response' type='text' value='$response'>";
        }
    }

    function deleteOne()
    {
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];

            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['id_producto'] == $producto_id) {
                    unset($_SESSION['carrito'][$indice]);
                    $response = json_encode(['success' => true]);
                    echo "<input id='response' type='text' value='$response'>";
                    return;
                }
            }

            $response = json_encode(['success' => false]);
            echo "<input id='response' type='text' value='$response'>";
        } else {

            $response = json_encode(['success' => false]);
            echo "<input id='response' type='text' value='$response'>";
        }
    }

    function up()
    {
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];

            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['id_producto'] == $producto_id) {
                    $_SESSION['carrito'][$indice]['unidades']++;

                    $response = json_encode(['success' => true]);
                    echo "<input id='response' type='text' value='$response'>";
                    return;
                }
            }

            $response = json_encode(['success' => false]);
            echo "<input id='response' type='text' value='$response'>";
        } else {

            $response = json_encode(['success' => false]);
            echo "<input id='response' type='text' value='$response'>";
        }
    }

    function down()
    {
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];

            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['id_producto'] == $producto_id && $_SESSION['carrito'][$indice]['unidades'] > 1) {
                    $_SESSION['carrito'][$indice]['unidades']--;

                    $response = json_encode(['success' => true]);
                    echo "<input id='response' type='text' value='$response'>";
                    return;
                }
            }


            $response = json_encode(['success' => false]);
            echo "<input id='response' type='text' value='$response'>";
        }
    }

    function deleteAll()
    {
        $_SESSION['carrito'] = array();


        $response = json_encode(['success' => true]);
        echo "<input id='response' type='text' value='$response'>";
    }
}
