<?php

/**
 * @author Carlos Hidalgo Risco
 */

namespace App\Models;

class Usuario
{
    private $_nombre;
    private $_apellidos;
    private $_usuario;
    private $_password;
    private static $formatoPassword = "/^[0-9]{4}$/";

    public function __construct($nombre, $apellidos)
    {
        $this->_nombre = $nombre;
        $this->_apellidos = $apellidos;
    }

    public function getNombreCompleto()
    {
        return $this->_nombre . " " . $this->_apellidos;
    }

    public function setPassword($password)
    {
        if (preg_match(self::$formatoPassword, $password)) {
            $this->_password = $password;
        } else {
            echo "El password no cumple con el formato";
        }
    }

    public function userValidate($nombre, $password)
    {
        if ($nombre == $this->_nombre && $password == $this->_password) {
            return true;
        } else {
            return false;
        }
    }
}
