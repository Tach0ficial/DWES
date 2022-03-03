<?php
/**
 *  Crear un array con los alumnos de clase y permitir la selección aleatoria de uno de ellos. El resultado
    debe mostrar nombre y fotografía.

 *  @author Carlos Hidalgo Risco.
 */

$clase = array(
    "Jesus Díaz Rivas" => "JesusDiazRivas.jpg",
    "Manuel Brito Guerrero" => "ManuelBrito.jpg",
    "Joaquín Baena Salas" => "JoaquinBaenaSalas.jpg",
    "Laura Hidalgo Rivera" => "LauraHidalgoRivera.jpg",
    "Tomas Hidalgo Martin" => "TomasHidalgoMartin.jpg",
    "Carlos Hidalgo Risco" => "CarlosHidalgoRisco.PNG",
    "Daniel Ayala Cantador" => "DanielAyalaCantador.jpg",
    "Javier Cebrián Muñoz" => "JavierCebrianMuñoz.jpeg",
    "Javier Fernández Rubio" => "javierfernandezrubio.jpg",
    "Rubén Ramírez Rivera" => "RubenRamirezRivera.jpeg",
    "David Pérez Ruiz" => "DavidPerezRuiz.png",
    "Alejandro Rabadán Rivas" => "AlejandroRabadanRivas.jpg",
    "David Rosas Alcatraz" => "DavidRosasAlcaraz.jpg",
    "Guillermo Tamajon Hernandez" => "GuillermoTamajonHernandez.jpg",
    "Sergio Vera Jurado" => "sergiovera.png",
    "Manuel Solar Bueno" => "ManuelSolarBueno.jpg",
    "Andrea Solís Tejada" => "AndreaSolisTejada.jpeg",
    "Juan Manuel González Prófumo" => "JuanManuelGonzalezProfumo.jpg",
    "Rafael Yuste Barrera" => "RafaelYuste.png",
    "Javier Epifanio López" => "JavierEpifanioLopez.jpg"
);

$random = array_rand($clase);
$path = "./img/";
$file = $clase[$random];
echo "<h1>".$random."</h1>";
echo "<img src=".$path.$file."> ";
?>