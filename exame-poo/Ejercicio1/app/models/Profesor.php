<?php

/**
 * @author Carlos Hidalgo Risco
 */

namespace App\Models;

class Profesor extends Usuario
{
    private $_funcion;

    public function getFuncion()
    {
        echo "<br>La función del profesor " . $this->getNombreCompleto() . " es: " . $this->_funcion;
    }

    public function setFuncion($funcion)
    {
        $this->_funcion = $funcion;
    }
}
