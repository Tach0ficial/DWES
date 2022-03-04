<?php

namespace App\Models;

require_once 'DBAbstractModel.php';
class Ciudadano extends DBAbstractModel
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
    private $email;
    private $idUsuario;
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
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
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
        $email = $this->email;
        $idUsuario = $this->idUsuario;
        $this->query = "INSERT INTO superheroes_ciudadanos(nombre, email, idUsuario)
                        VALUES(:nombre, :email, :idUsuario)";
        $this->parametros['nombre'] = $nombre;
        $this->parametros['email'] = $email;
        $this->parametros['idUsuario'] = $idUsuario;
        $this->get_results_from_query();
        $this->mensaje = 'Ciudadano registrado correctamente';
    }
    public function get($id = null)
    {
        $this->query = "SELECT * FROM superheroes_ciudadanos where id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Cuidadano listado correctamente';
        $ciudadano = Ciudadano::getInstancia();
        $ciudadano->setNombre($this->rows[0]['nombre']);
        $ciudadano->setEmail($this->rows[0]['email']);
        $ciudadano->setIdUsuario($this->rows[0]['idUsuario']);
        return $ciudadano;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM superheroes_ciudadanos";
        $this->get_results_from_query();
        $this->mensaje = 'Ciudadanos listados correctamente';
        return $this->rows;
    }
    public function edit()
    {
        $id = $this->id;
        $nombre = $this->nombre;
        $email = $this->email;
        $this->query = "UPDATE superheroes_ciudadanos SET nombre = :nombre, email = :email, idUsuario = :idUsuario WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['nombre'] = $nombre;
        $this->parametros['email'] = $email;
        $this->parametros['idUsuario'] = $this->idUsuario;
        $this->get_results_from_query();
        $this->mensaje = 'Ciudadano modificado correctamente';
    }
    public function editById()
    {
    }
    public function delete($id = null)
    {
        $this->query = "DELETE FROM superheroes_ciudadanos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Ciudadano borrado correctamente';
    }
    public function ciudadanoExist($id)
    {
        $this->query = "SELECT * FROM superheroes_ciudadanos WHERE idUsuario = " . $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getIdCiudadanoByIdUser($idUser)
    {
        $this->query = "SELECT id FROM superheroes_ciudadanos WHERE idUsuario = " . $idUser;
        $this->get_results_from_query();
        return $this->rows[0]["id"];
    }
}
