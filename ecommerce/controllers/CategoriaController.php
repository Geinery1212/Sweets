<?php
require_once 'ecommerce/models/Categoria.php';
require_once 'ecommerce/models/Producto.php';
class CategoriaController
{
    public function index()
    {
        $catagoria = new Categoria();
        $categorias = $catagoria->getAll();
        require_once 'ecommerce/views/categoria/index.php';
    }
    public function ver()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Conseguir categoria 
            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria = $categoria->getOne();

            // Conseguir productos
            $producto = new Producto();
            $producto->setCategoria_id($id);
            $productos = $producto->getAllCategory();
        }
        require_once 'ecommerce/views/categoria/ver.php';
    }

    public function crear()
    {
        Utils::isAdmin(); // asi se llama a un método estatico
        require_once 'ecommerce/views/categoria/crear.php';
    }
    public function editar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $edit = true;

            $categoria = new Categoria();
            $categoria->setId($id);
            $cat = $categoria->getOne();
            require_once 'ecommerce/views/categoria/crear.php';
        } else {
            header('Location:' . base_url . 'categoria/index');
        }
    }

    public function eliminar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $categoria = new Categoria();
            $categoria->setId($id);

            $delete = $categoria->delete();
            if ($delete) {
                $_SESSION['CategoriaControllerMessageSuccess'] = 'La categoria se eliminó de manera correcta.';
            } else {
                $_SESSION['CategoriaControllerMessageError'] = 'Hubo un error al eliminar la categoria.';
            }
        } else {
            $_SESSION['CategoriaControllerMessageError'] = 'Ha ocurrido un error.';
        }
        header('Location:' . base_url . 'categoria/index');
    }
    public function save()
    {
        Utils::isAdmin();
        if (isset($_POST)) {
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : false;

            if ($nombre) {
                $categoria = new Categoria();
                $categoria->setNombre($nombre);

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $categoria->setId($id);
                    $save = $categoria->edit();
                } else {
                    $save = $categoria->save();
                }

                if ($save) {
                    if (isset($_GET['id'])) {
                        $_SESSION['CategoriaControllerMessageSuccess'] = 'La categoría se editó correctamente.';
                    } else {
                        $_SESSION['CategoriaControllerMessageSuccess'] = 'La categoría se creó correctamente.';
                    }
                } else {
                    if (isset($_GET['id'])) {
                        $_SESSION['CategoriaControllerMessageError'] = 'Hubo un error al editar la categoría.';
                    } else {
                        $_SESSION['CategoriaControllerMessageError'] = 'Hubo un error al crear la categoría.';
                    }
                }
            } else {
                $_SESSION['CategoriaControllerMessageError'] = 'Ha ocurrido un error.';
            }
        } else {
            $_SESSION['CategoriaControllerMessageError'] = 'Ha ocurrido un error.';
        }

        header('Location: ' . base_url . 'categoria/index');
    }
}
