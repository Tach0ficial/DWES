<?php

namespace App\Models;


class Usuario extends DBAbstractModel
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
    private $username;
    private $psw;
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
    public function getUsername()
    {
        return $this->user;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getPsw()
    {
        return $this->psw;
    }
    public function setPsw($psw)
    {
        $this->psw = $psw;
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
        $username = $this->username;
        $psw = $this->psw;
        $this->query = "INSERT INTO superheroes_usuarios(username, psw)
                        VALUES(:username, :psw)";
        $this->parametros['username'] = $username;
        $this->parametros['psw'] = $psw;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario registrado correctamente';
    }
    public function get($id = null)
    {
        $this->query = "SELECT * FROM superheroes_usuarios where id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario listado correctamente';
        $usuario = Usuario::getInstancia();
        $usuario->setUsername($this->rows[0]['username']);
        $usuario->setPsw($this->rows[0]['psw']);
        return $usuario;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM superheroes_usuarios";
        $this->get_results_from_query();
        $this->mensaje = 'Usuarios listados correctamente';
        return $this->rows;
    }
    public function edit()
    {
        $id = $this->id;
        $username = $this->username;
        $psw = $this->psw;
        $this->query = "UPDATE superheroes_usuarios SET username = :username, psw = :psw WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['username'] = $username;
        $this->parametros['psw'] = $psw;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario modificado correctamente';
    }
    public function editById()
    {
    }
    public function delete($id = null)
    {
        $this->query = "DELETE FROM superheroes_usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario borrado correctamente';
    }
    public function userExist($ussername)
    {
        $this->query = "SELECT * FROM superheroes_usuarios WHERE username = :username";
        $this->parametros['username'] = $ussername;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function login($username, $password)
    {
        $this->query = "SELECT * FROM superheroes_usuarios WHERE username = :username AND psw = :psw";
        $this->parametros['username'] = $username;
        $this->parametros['psw'] = $password;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getByUsername($username)
    {
        $this->query = "SELECT * FROM superheroes_usuarios where username = :username";
        $this->get_results_from_query();
        $this->mensaje = 'Usuario listado correctamente';
        $usuario = Usuario::getInstancia();
        $usuario->setId($this->rows[0]['id']);
        $usuario->setUsername($this->rows[0]['username']);
        $usuario->setPsw($this->rows[0]['psw']);
        return $usuario;
    }
    public function getPerfil()
    {
        $ciudadano = Ciudadano::getInstancia();
        $superheroe = Superheroe::getInstancia();
        $id = $this->id;
        if ($ciudadano->ciudadanoExist($id)) {
            return "ciudadano";
        }
        if ($superheroe->superheroeExist($id) && $superheroe->superheroeExperto($id)) {
            return "superheroeExperto";
        }
        if ($superheroe->superheroeExist($id)) {
            return "superheroe";
        }
        
    }
}
