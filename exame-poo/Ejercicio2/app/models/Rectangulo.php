<?php

/**
 * @author Carlos Hidalgo Risco
 */

namespace App\Models;

class Rectangulo implements AreaYDibujo
{
    private $_color;
    private $_base;
    private $_altura;

    public function __construct($base, $altura)
    {
        $this->_base = $base;
        $this->_altura = $altura;
    }

    public function getColor()
    {
        return $this->_color;
    }

    public function setColor($color)
    {
        $this->_color = $color;
    }

    public function redimensionar($factor)
    {
        $this->_base = $this->_base * $factor;
        $this->_altura = $this->_altura * $factor;
    }
    public function calculaArea()
    {
        return $this->_base * $this->_altura;
    }
    public function dibujar()
    {
        echo "<svg width=\"$this->_base\" height=\"$this->_altura\"><rect x=\"10\" y=\"10\" width=\"$this->_base\" height=\"$this->_altura\"/></svg>";
    }
}
