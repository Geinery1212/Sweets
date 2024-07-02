<?php
require_once 'ecommerce/models/Producto.php';
class ProductoController
{
    public function index()
    {
        $producto = new Producto();
        $productos_por_pagina = 9;
        $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($pagina_actual - 1) * $productos_por_pagina;
        $productos = $producto->getProducts($offset, $productos_por_pagina);

        // Obtenemos el número total de productos
        $total_productos = $producto->getTotalProducts();

        // Calculamos el total de páginas
        $total_paginas = ceil($total_productos / $productos_por_pagina);
        require_once 'ecommerce/views/producto/algunos_productos.php';
    }
    public function ver()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $edit = true;

            $producto = new Producto();
            $producto->setId($id);
            $product = $producto->getOne();
        }
        require_once 'ecommerce/views/producto/ver.php';
    }
    public function busqueda()
    {
        if (isset($_POST['buscar'])) {
            $buscar = $_POST['buscar'];
            $producto = new Producto();
            $productos_por_pagina = 9;
            $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($pagina_actual - 1) * $productos_por_pagina;

            try {
                // Búsqueda de productos
                $productos = $producto->buscar($buscar, $offset, $productos_por_pagina);

                // Obtenemos el número total de productos
                if ($productos) {
                    $total_productos = $productos->num_rows;
                } else {
                    $total_productos = 0;
                }

                // Calculamos el total de páginas
                $total_paginas = ceil($total_productos / $productos_por_pagina);

                require_once 'ecommerce/views/producto/busqueda.php';
            } catch (Exception $e) {
                // Manejar el error adecuadamente (por ejemplo, mostrar un mensaje de error)
                echo "Ocurrió un error durante la búsqueda: " . $e->getMessage();
            }
        }
    }

    public function gestion()
    {
        Utils::isAdmin();
        $producto = new Producto();
        $productos = $producto->getAll();
        require_once 'ecommerce/views/producto/gestion.php';
    }

    public function crear()
    {
        Utils::isAdmin();
        require_once 'ecommerce/views/producto/crear.php';
    }
    public function save()
    {
        Utils::isAdmin();
        if (isset($_POST)) {
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : false;
            $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : false;
            $precio = isset($_POST["precio"]) ? $_POST["precio"] : false;
            $stock = isset($_POST["stock"]) ? $_POST["stock"] : false;
            $categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : false;
            if ($nombre && $descripcion && $precio && $stock && $categoria) {
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);

                // Guardar la imagen
                if (isset($_FILES['imagen'])) {
                    $file = $_FILES["imagen"];
                    $filename = $file["name"];
                    $mimetype = $file["type"];

                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {

                        // Crear un nombre único para la imagen
                        $unique_filename = uniqid() . '_' . $filename;

                        if (!is_dir('ecommerce/uploads/images')) {
                            mkdir('ecommerce/uploads/images', 0777, true);
                        }

                        move_uploaded_file($file['tmp_name'], 'ecommerce/uploads/images/' . $unique_filename);
                        $producto->setImagen($unique_filename);
                    }
                }

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $producto->setId($id);
                    $save = $producto->edit();
                } else {
                    $save = $producto->save();
                }

                if ($save) {
                    if (isset($_GET['id'])) {
                        $_SESSION['ProductoControllerMessageSuccess'] = 'El producto se editó de manera correcta.';
                    } else {
                        $_SESSION['ProductoControllerMessageSuccess'] = 'El producto se creó de manera correcta.';
                    }
                    $_SESSION['producto'] = 'complete';
                } else {
                    if (isset($_GET['id'])) {
                        $_SESSION['ProductoControllerMessageError'] = 'Hubo un error al editar el producto.';
                    } else {
                        $_SESSION['ProductoControllerMessageError'] = 'Hubo un error al crear el producto.';
                    }
                    $_SESSION['producto'] = 'failed';
                }
            } else {
                $_SESSION['ProductoControllerMessageError'] = 'Ha ocurrido un error.';
                $_SESSION['producto'] = 'failed';
            }
        } else {
            $_SESSION['ProductoControllerMessageError'] = 'Ha ocurrido un error.';
            $_SESSION['producto'] = 'failed';
        }
        header('Location:' . base_url . 'producto/gestion');
    }

    public function editar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $edit = true;

            $producto = new Producto();
            $producto->setId($id);
            $pro = $producto->getOne();
            require_once 'ecommerce/views/producto/crear.php';
        } else {
            header('Location:' . base_url . 'producto/gestion');
        }
    }

    public function eliminar()
    {
        Utils::isAdmin();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);

            $delete = $producto->delete();
            if ($delete) {
                $_SESSION['ProductoControllerMessageSuccess'] = 'El producto se eliminó de manera correcta.';
            } else {
                $_SESSION['ProductoControllerMessageError'] = 'Hubo un error al eliminar el producto.';
            }
        } else {
            $_SESSION['CategoriaControllerMessageError'] = 'Ha ocurrido un error.';
        }
        header('Location:' . base_url . 'producto/gestion');
    }
}
