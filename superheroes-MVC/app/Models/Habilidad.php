<?php

namespace App\Models;

require_once 'DBAbstractModel.php';
class Habilidad extends DBAbstractModel
{
    /*CONSTRUCCIÓN DEL MODELO SINGLETON*/
    private static $instancia;
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    public function __clone()
    {
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }
    /*FIN DE LA CONSTRUCCIÓN DEL MODELO SINGLETON*/
    private $id;
    private $nombre;
    private $created_at;
    private $updated_at;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getCreated_at()
    {
        return $this->created_at;
    }
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }
    public function getUpdated_at()
    {
        return $this->updated_at;
    }
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function set()
    {
        $nombre = $this->nombre;
        $this->query = "INSERT INTO superheroes_habilidades(nombre)
                        VALUES(:nombre)";
        $this->parametros['nombre'] = $nombre;
        $this->get_results_from_query();
    }
    public function get($id = null)
    {
        $this->query = "SELECT * FROM superheroes_habilidades where id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario listado correctamente';
        $habilidad = Habilidad::getInstancia();
        $habilidad->setNombre($this->rows[0]['nombre']);
        return $habilidad;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM superheroes_habilidades";
        $this->get_results_from_query();
        $this->mensaje = 'Habilidades listadas correctamente';
        return $this->rows;
    }
    public function edit()
    {
        $id = $this->id;
        $nombre = $this->nombre;
        $this->query = "UPDATE superheroes_habilidades SET nombre = :nombre WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['nombre'] = $nombre;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad modificada correctamente';
    }
    public function editById()
    {
        
    }
    public function delete($id = null)
    {
        $this->query = "DELETE FROM superheroes_habilidades WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario borrado correctamente';
    }
    public function getValorById($idHabilidad ,$idSuperheroe)
    {
        $this->query = "SELECT valor FROM superheroes_superheroes_habilidades where idHabilidad = :idHabilidad AND idSuperheroe = :idSuperheroe";
        $this->parametros['idHabilidad'] = $idHabilidad;
        $this->parametros['idSuperheroe'] = $idSuperheroe;
        $this->get_results_from_query();
        return $this->rows[0]['valor'];
    }
}
