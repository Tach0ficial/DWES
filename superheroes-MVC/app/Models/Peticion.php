<?php

namespace App\Models;

require_once 'DBAbstractModel.php';
class Peticion extends DBAbstractModel
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
    private $titulo;
    private $descripcion;
    private $realizada;
    private $idSuperheroe;
    private $idCiudadano;
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
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function getRealizada()
    {
        return $this->realizada;
    }
    public function setRealizada($realizada)
    {
        $this->realizada = $realizada;
    }
    public function getIdSuperheroe()
    {
        return $this->idSuperheroe;
    }
    public function setIdSuperheroe($idSuperheroe)
    {
        $this->idSuperheroe = $idSuperheroe;
    }
    public function getIdCiudadano()
    {
        return $this->idCiudadano;
    }
    public function setIdCiudadano($idCiudadano)
    {
        $this->idCiudadano = $idCiudadano;
    }
    public function set()
    {
        $titulo = $this->titulo;
        $descripcion = $this->descripcion;
        $realizada = false;
        $idSuperheroe = $this->idSuperheroe;
        $idCiudadano = $this->idCiudadano;
        $this->query = "INSERT INTO peticiones(titulo, descripcion, realizada, idSuperheroe, idCiudadano)
                        VALUES(:titulo, :descripcion, :realizada, :idSuperheroe, :idCiudadano)";
        $this->parametros['titulo'] = $titulo;
        $this->parametros['descripcion'] = $descripcion;
        $this->parametros['realizada'] = $realizada;
        $this->parametros['idSuperheroe'] = $idSuperheroe;
        $this->parametros['idCiudadano'] = $idCiudadano;
        $this->get_results_from_query();
        $this->mensaje = 'Peticion realizada correctamente';
    }
    public function get($id = null)
    {
        $this->query = "SELECT * FROM peticiones where id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Peticion listada correctamente';
        $peticion = Peticion::getInstancia(); //new Superheroe();
        $peticion->setTitulo($this->rows[0]['titulo']);
        $peticion->setDescripcion($this->rows[0]['descripcion']);
        $peticion->setRealizada($this->rows[0]['realizada']);
        $peticion->setIdSuperheroe($this->rows[0]['idSuperheroe']);
        $peticion->setIdCiudadano($this->rows[0]['idCiudadano']);
        return $peticion;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM peticiones";
        $this->get_results_from_query();
        $this->mensaje = 'Peticiones listadas correctamente';
        return $this->rows;
    }
    public function getAllByIdSuperheroe($idSuperheroe)
    {
        $this->query = "SELECT * FROM peticiones WHERE idSuperheroe = ".$idSuperheroe;
        $this->get_results_from_query();
        $this->mensaje = 'Peticiones listadas correctamente';
        return $this->rows;
    }
    public function edit()
    {
        $id = $this->id;
        $titulo = $this->titulo;
        $descripcion = $this->descripcion;
        $realizada = $this->realizada;
        $idSuperheroe = $this->idSuperheroe;
        $idCiudadano = $this->idCiudadano;
        $this->query = "UPDATE peticiones SET titulo = :titulo, descripcion = :descripcion, realizada = :realizada , idSuperheroe = :idSuperheroe ,idCiudadano = : idCiudadano WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['titulo'] = $titulo;
        $this->parametros['descripcion'] = $descripcion;
        $this->parametros['realizada'] = $realizada;
        $this->parametros['idSuperheroe'] = $idSuperheroe;
        $this->parametros['idCiudadano'] = $idCiudadano;
        $this->get_results_from_query();
        $this->mensaje = 'SH modificado correctamente';
    }
    public function editById($obj = null)
    {
    }
    public function delete($id = null)
    {
        $this->query = "DELETE FROM peticiones WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Peticion borrado correctamente';
    }
    public function realizada($id = null)
    {
        $this->query = "UPDATE peticiones SET realizada = true WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Peticion realizada correctamente';
    }
    public function getNumOfPeticiones($idSuperheroe)
    {
        $this->query = "SELECT COUNT(*) as num FROM peticiones WHERE idSuperheroe = ".$idSuperheroe;
        $this->get_results_from_query();
        $this->mensaje = 'Peticiones listadas correctamente';
        return $this->rows[0]['num'];
    }
}
