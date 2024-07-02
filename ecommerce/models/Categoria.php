<?php
class Categoria
{
    protected $id;
    protected $nombre;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);

        return $this;
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias ORDER BY id DESC";
        $categorias = $this->db->query($sql);
        return $categorias;
    }
    public function getCategoria()
    {
        $sql = "SELECT * FROM categorias WHERE id = {$this->getId()}";
        $categoria = $this->db->query($sql);
        return $categoria->fetch_object();
    }
    public function getAll()
    {
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }
    public function getOne(){
        $categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()}");
        return $categoria->fetch_object();
    }

    public function edit(){
        $sql = "UPDATE categorias SET nombre='{$this->getNombre()}' WHERE id={$this->id}";
        $save = $this->db->query($sql);
        
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function delete(){
        $sql = "DELETE FROM categorias WHERE id= {$this->id}";
        $delete = $this->db->query($sql);
        $result = false;
        if($delete){
            $result = true;
        }
        return $result;
    }
    public function save()
    {
        $sql = "INSERT INTO categorias VALUES(null, '{$this->getNombre()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
}
