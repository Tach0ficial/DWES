<?php

/**
 * @author Carlos Hidalgo Risco
 */


namespace App\Models;

class Circulo implements AreaYDibujo
{

    private $_color;
    private $_radio;

    public function __construct($radio)
    {
        $this->_radio = $radio;
    }

    public function getColor()
    {
        return $this->_color;
    }

    public function setColor($color)
    {
        $this->_color = $color;
    }

    public function getRadio()
    {
        return $this->_radio;
    }

    public function setRadio($radio)
    {
        $this->_radio = $radio;
    }

    public function calculaArea()
    {
        return pi() * pow($this->_radio, 2);
    }
    public function dibujar()
    {
        echo "<svg><circle cx=\"60\" cy=\"60\" r=\"$this->_radio\"/></svg>";
    }
}
