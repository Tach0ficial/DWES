<?php

/**
 * @author Carlos Hidalgo Risco
 */

namespace App\Models;

class Alumno extends Usuario
{
    private $_numeroIdEscolar;
    private $_notas = array(
        "Servidor" => array("1" => 0, "2" => 0, "3" => 0),
        "Cliente" => array("1" => 0, "2" => 0, "3" => 0),
        "Empresas" => array("1" => 0, "2" => 0, "3" => 0),
        "HLC" => array("1" => 0, "2" => 0, "3" => 0),
        "Despliegues" => array("1" => 0, "2" => 0, "3" => 0),
        "Diseño" => array("1" => 0, "2" => 0, "3" => 0)
    );

    public function getNotas()
    {
        foreach ($this->_notas as $modulo => $evaluaciones) {
            $media = 0;
            echo "<br> Notas del módulo " . $modulo . ": ";
            foreach ($evaluaciones as $evaluacionNombre => $evaluacionNota) {
                echo "<br>" . $evaluacionNombre . "ª Evaluación: " . $evaluacionNota;
                $media += $evaluacionNota;
            }
            echo "<br> Media de " . $modulo . ": " . $media / 3;
        }
    }

    public function setNota($modulo, $nota, $evaluacion)
    {
        if ($nota >= 0 && $nota <= 10) {
            $this->_notas[$modulo][$evaluacion] = $nota;
        } else {
            echo "La nota no es válida";
        }
    }

    public function getNumeroIdEscolar()
    {
        return $this->_numeroIdEscolar;
    }
}
