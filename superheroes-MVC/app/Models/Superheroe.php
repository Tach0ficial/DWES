<?php

namespace App\Models;

require_once 'DBAbstractModel.php';
class Superheroe extends DBAbstractModel
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
    private $idUsuario;
    private $imagen;
    private $created_at;
    private $updated_at;

    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEvolucion()
    {
        return $this->evolucion;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function getCreated_at()
    {
        return $this->created_at;
    }
    public function getUpdated_at()
    {
        return $this->updated_at;
    }
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setEvolucion($evolucion)
    {
        $this->evolucion = $evolucion;
    }
    public function set()
    {
        $nombre = $this->nombre;
        $evolucion = "PRINCIPIANTE";
        $idUsuario = $this->idUsuario;
        $imagen = $this->imagen;
        $this->query = "INSERT INTO superheroes_superheroes(nombre, evolucion, idUsuario, imagen)
                        VALUES(:nombre, :evolucion, :idUsuario, :imagen)";
        $this->parametros['nombre'] = $nombre;
        $this->parametros['evolucion'] = $evolucion;
        $this->parametros['idUsuario'] = $idUsuario;
        $this->parametros['imagen'] = $imagen;
        $this->get_results_from_query();
        $this->mensaje = 'SH agregado correctamente';
    }
    public function get($id = null)
    {
        $this->query = "SELECT * FROM superheroes_superheroes where id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'SH listado correctamente';
        $sh = Superheroe::getInstancia(); //new Superheroe();
        $sh->setNombre($this->rows[0]['nombre']);
        $sh->setEvolucion($this->rows[0]['evolucion']);
        return $sh;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM superheroes_superheroes";
        $this->get_results_from_query();
        $this->mensaje = 'SHs listados correctamente';
        return $this->rows;
    }
    public function edit()
    {
        $id = $this->id;
        $nombre = $this->nombre;
        $imagen = $this->imagen;
        $this->query = "UPDATE superheroes_superheroes SET nombre = :nombre, imagen = :imagen WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['nombre'] = $nombre;
        $this->parametros['imagen'] = $imagen;
        $this->get_results_from_query();
        $this->mensaje = 'SH modificado correctamente';
    }
    public function editById($obj = null)
    {
        $id = $obj->getId();
        $nombre = $obj->getNombre();
        $evolucion = $obj->getVelocidad();
        $this->query = "UPDATE superheroes_superheroes SET nombre = :nombre, evolucion = :evolucion WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['nombre'] = $nombre;
        $this->parametros['evolucion'] = $evolucion;
        $this->get_results_from_query();
        $this->mensaje = 'SH modificado correctamente';
    }
    public function delete($id = null)
    {
        $this->query = "DELETE FROM superheroes_superheroes WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'SH borrado correctamente';
    }

    public function getLastSh($numero = 1)
    {
        $this->query = "SELECT nombre, evolucion, id FROM superheroes_superheroes ORDER BY id DESC LIMIT " . $numero;

        $this->get_results_from_query();
        return $this->rows;
        $this->mensaje = 'SH obtenidos correctamente';
    }

    public function buscar($nombre)
    {
        $this->query = "SELECT * FROM superheroes_superheroes WHERE nombre LIKE '%$nombre%'";
        $this->get_results_from_query();
        $this->mensaje = 'SH obtenidos correctamente';
        return $this->rows;
    }

    public function getHabilidades($id)
    {
        $habilidad = Habilidad::getInstancia();
        $habilidades = [];
        $this->query = "SELECT * FROM superheroes_superheroes_habilidades WHERE idSuperheroe = " . $id;
        $this->get_results_from_query();
        foreach ($this->rows as $key => $row) {
            array_push($habilidades, "|".$habilidad->get($row['idHabilidad'])->getNombre() . ", Valor: " . $habilidad->getValorById($row['idHabilidad'], $id)."| ");
        }
        return $habilidades;
    }

    public function superheroeExist($id)
    {
        $this->query = "SELECT * FROM superheroes_superheroes WHERE idUsuario = " . $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function superheroeExperto($id)
    {
        $this->query = "SELECT * FROM superheroes_superheroes WHERE evolucion = 'EXPERTO' AND idUsuario = " . $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function experto($id)
    {
        $this->query = "UPDATE superheroes_superheroes SET evolucion = 'EXPERTO' WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'SH modificado correctamente';
    }

    public function getIdSuperheroeByIdUser($idUser)
    {
        $this->query = "SELECT id FROM superheroes_superheroes WHERE idUsuario = " . $idUser;
        $this->get_results_from_query();
        return $this->rows[0]["id"];
    }

    public function setHabilidad($idHabilidad, $valor)
    {
        $sh = Superheroe::getInstancia();
        $idSuperheroe = $sh->getIdSuperheroeByIdUser($_SESSION['id']);
        $this->query = "INSERT INTO superheroes_superheroes_habilidades(idSuperheroe, idHabilidad, valor)
                        VALUES(:idSuperheroe, :idHabilidad, :valor)";
        $this->parametros['idSuperheroe'] = $idSuperheroe;
        $this->parametros['idHabilidad'] = $idHabilidad;
        $this->parametros['valor'] = $valor;
        $this->get_results_from_query();
        $this->mensaje = 'habilidad agregada correctamente';
    }

    public function setHabilidadById($idSuperheroe, $idHabilidad, $valor)
    {
        $this->query = "INSERT INTO superheroes_superheroes_habilidades(idSuperheroe, idHabilidad, valor)
                        VALUES(:idSuperheroe, :idHabilidad, :valor)";
        $this->parametros['idSuperheroe'] = $idSuperheroe;
        $this->parametros['idHabilidad'] = $idHabilidad;
        $this->parametros['valor'] = $valor;
        $this->get_results_from_query();
        $this->mensaje = 'habilidad agregada correctamente';
    }
}
