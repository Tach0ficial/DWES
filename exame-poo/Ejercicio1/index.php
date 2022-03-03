<?php

/**
 * @author Carlos Hidalgo Risco
 */

require_once 'vendor/autoload.php';

use App\Models\{Alumno, Profesor};

//Crea un alumno
$carlos = new Alumno('Carlos', 'Hidalgo Risco');
//Comprueba el nombre completo
echo $carlos->getNombreCompleto() . "<br>";
//Establece una contraseña
$carlos->setPassword('1234');
//Detecta una contraseña en formato incorrecto
echo "Contraseña incorrecta: <br>";
$carlos->setPassword('12345');
echo "<br>";
echo "Credenciales correctas: <br>";
if ($carlos->userValidate('Carlos', '1234')) {
    echo "El usuario es correcto <br>";
} else {
    echo "El usuario o contraseña no son correctos <br>";
}
echo "Credenciales incorrectas: <br>";
if ($carlos->userValidate('Carlos', '12345')) {
    echo "El usuario es correcto";
} else {
    echo "El usuario o contraseña no son correctos <br>";
}

//Añade notas al alumno
$carlos->setNota("Servidor", 8, "1");
$carlos->setNota("Servidor", 8, "2");
$carlos->setNota("Servidor", 8, "3");
$carlos->setNota("Cliente", 8, "1");
$carlos->setNota("Cliente", 8, "2");
$carlos->setNota("Cliente", 8, "3");

//Muestra las notas del alumno
$carlos->getNotas();


//Crea un profesor
$jose = new Profesor('José', 'Pérez Martín');
//Establece una función al profesor
$jose->setFuncion('Tutor');
//Muestra la función del profesor
echo $jose->getFuncion();
//Modifica la función del profesor
$jose->setFuncion('Programador');
//Muestra la función del profesor
echo $jose->getFuncion();
