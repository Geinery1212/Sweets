<?php
class Producto
{
    protected $id;
    protected $categoria_id;
    protected $nombre;
    protected $descripcion;
    protected $precio;
    protected $stock;
    protected $oferta;
    protected $fecha;
    protected $imagen;
    protected $db;
    public function __construct()
    {
        $this->db = ConnectionDB::connect();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);

        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $this->db->real_escape_string($descripcion);

        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $this->db->real_escape_string($precio);

        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $this->db->real_escape_string($stock);

        return $this;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $oferta;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
    public function getAllCategory()
    {
        $sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p INNER JOIN  categorias c ON c.id = p.categoria_id WHERE p.categoria_id = {$this->getCategoria_id()} AND p.stock >= 1 ORDER BY id DESC";
        $productos = $this->db->query($sql);
        return $productos;
    }

    public function getAll()
    {
        $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        return $productos;
    }
    public function getOne()
    {
        $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
        return $producto->fetch_object(); // devuelto siendo un objeto usable
    }

    public function getProducts($offset, $limit)
    {
        $sql = "SELECT * FROM productos WHERE stock >= 1 LIMIT $offset, $limit";
        $productos = $this->db->query($sql);
        return $productos;
    }

    public function getTotalProducts()
    {
        $total_productos_query = $this->db->query("SELECT COUNT(*) as total FROM productos");
        $total_productos = $total_productos_query->fetch_object()->total;
        return $total_productos;
    }
    public function buscar($buscar, $offset, $limit)
    {
        $sql = "SELECT * FROM productos ";
        if (!empty($buscar) && $buscar != null) {
            $sql .= "WHERE nombre LIKE '%$buscar%' OR categoria_id IN (SELECT id FROM categorias WHERE nombre LIKE '%$buscar%') ";
        }
        $sql .= 'ORDER BY id DESC ';
        if (!empty($limit) && $limit != null) {
            $sql .= "LIMIT $offset, $limit";
        }
        $resultados = $this->db->query($sql);
        if ($resultados->num_rows > 0) {
            return $resultados;
        }
        return false;
    }

    public function save()
    {
        $sql = "INSERT INTO productos VALUES (NULL,'{$this->getCategoria_id()}', '{$this->getNombre()}','{$this->getDescripcion()}',{$this->getPrecio()},{$this->getStock()},NULL,CURDATE(), '{$this->getImagen()}');";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    public function edit()
    {
        $sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}',precio = {$this->getPrecio()}, stock={$this->getStock()}";

        if ($this->getImagen() != null) {
            $sql .= ", imagen='{$this->getImagen()}'";
        }
        $sql .= " WHERE id={$this->id}";

        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    public function delete()
    {
        $sql = "DELETE FROM productos WHERE id= {$this->id}";
        $delete = $this->db->query($sql);
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    public function updateStock($id, $newStock)
    {
        $sql = "UPDATE productos SET stock = $newStock WHERE id = $id";

        $update = $this->db->query($sql);

        $result = false;
        if ($update) {
            $result = true;
        }
        return $result;
    }
}
