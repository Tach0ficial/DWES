<?php

/**
 * @author Carlos Hidalgo Risco
 */

require_once 'vendor/autoload.php';

use App\Models\{Circulo, Rectangulo};

//Crea un circulo
$circulo = new Circulo(30);
//Dibuja el circulo
$circulo->dibujar();
echo "<br>";
//Calcula su area
echo "Area del circulo: " . $circulo->calculaArea() . "<br>";
//Modifica el circulo
$circulo->setRadio(20);
//Dibuja el circulo
$circulo->dibujar();
echo "<br>";
//Calcula su area
echo "Area del circulo: " . $circulo->calculaArea() . "<br>";

//Crea un rectangulo
$rectangulo = new Rectangulo(300, 200);
//Dibuja el rectangulo
$rectangulo->dibujar();
echo "<br>";
//Calcula su area
echo "Area del rectangulo: " . $rectangulo->calculaArea() . "<br>";
//Modifica el rectangulo
$rectangulo->redimensionar(2);
//Dibuja el rectangulo
$rectangulo->dibujar();
echo "<br>";
