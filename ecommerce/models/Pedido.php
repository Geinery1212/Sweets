<?php
class Pedido
{
    private $id;
    private $usuario_id;
    private $municipio;
    private $localidad;
    private $direccion;
    private $referencia;
    private $telefono;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    private $db;

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
    
    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getMunicipio()
    {
        return $this->municipio;
    }

    public function setMunicipio($municipio)
    {
        $this->municipio = $this->db->real_escape_string($municipio);

        return $this;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function setLocalidad($localidad)
    {
        $this->localidad = $this->db->real_escape_string($localidad);

        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $this->db->real_escape_string($direccion);

        return $this;
    }

    public function getCoste()
    {
        return $this->coste;
    }

    public function setCoste($coste)
    {
        $this->coste = $coste;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

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

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }
    public function getReferencia()
    {
        return $this->referencia;
    }

    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
        return $this;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

    public function getPedido()
    {
        $sql = "SELECT p.*, concat(u.nombre) as nombre, u.email FROM pedidos p
        INNER JOIN usuarios u ON p.usuario_id = u.id WHERE p.id = {$this->getId()}";
        $producto = $this->db->query($sql);
        return $producto->fetch_object();
    }
    public function getPedidos()
    {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $productos = $this->db->query($sql);
        return $productos;
    }
    public function getPedidoByUser()
    {
        $sql = "SELECT id, coste FROM pedidos WHERE usuario_id = {$this->getUsuario_id()} ORDER BY
        id DESC LIMIT 1";
        $pedido = $this->db->query($sql);
        return $pedido->fetch_object();
    }
    public function getPedidosByUser()
    {
        $sql = "SELECT * FROM pedidos WHERE usuario_id = {$this->getUsuario_id()} ORDER BY id DESC";
        $pedido = $this->db->query($sql);
        return $pedido;
    }
    public function getProductosByPedido()
    {
        $sql = "SELECT p.*, lp.unidades FROM productos p INNER JOIN lineas_pedidos lp
        ON p.id = lp.producto_id WHERE lp.pedido_id = {$this->getId()}";
        $productos = $this->db->query($sql);
        return $productos;
    }
    public function save()
    {
        $sql = "INSERT INTO pedidos VALUES(null, {$this->getUsuario_id()}, '{$this->getMunicipio()}',
                    '{$this->getLocalidad()}', '{$this->getDireccion()}', '{$this->getReferencia()}' , '{$this->getTelefono()}', {$this->getCoste()}, 'confirm', curdate(), curtime())";
        $save = $this->db->query($sql);
        error_log('save pedido ');
        error_log($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function save_linea() {
        $sql = "SELECT LAST_INSERT_ID() AS 'pedido'";
        $query = $this->db->query($sql);
    
        if ($query) {
            $pedido_id = $query->fetch_object()->pedido;
        } else {
            error_log("Error al obtener el ID del último pedido: " . $this->db->error);
            return false;
        }
    
        $result = true;
    
        foreach ($_SESSION['carrito'] as $indice => $elemento) {
            $producto = $elemento['producto'];
            $insert = "INSERT INTO lineas_pedidos VALUES (null, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
            $save = $this->db->query($insert);
    
            if (!$save) {
                $result = false;
                error_log("Error al guardar la línea del pedido: " . $this->db->error);
            }
        }
    
        return $result;
    }
    
    public function update() {
        $sql = "UPDATE pedidos SET estado ='{$this->getEstado()}' WHERE id = {$this->getId()};";
        $update = $this->db->query($sql);
    
        $result = false;
        if ($update) {
            $result = true;
        } else {
            error_log("Error al actualizar el pedido: " . $this->db->error);
        }
        return $result;
    }
    
}