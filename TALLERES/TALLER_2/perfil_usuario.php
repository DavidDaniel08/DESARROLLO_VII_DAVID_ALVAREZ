<?php
// Definición de variables
$nombre_completo = "David Daniel Alvarez";
$edad = 23;
$correo = "dvalvarez08@gmail.com";
$telefono = "69262963";

// Definición de constante
define("OCUPACION", "Estudiante y Soporte Técnico en el Xtra");

// Métodos de impresión y concatenación
echo "<p>Nombre Completo: " . $nombre_completo . "</p>";
print "<p>Edad: " . $edad . " años</p>";
printf("<p>Correo Electrónico: %s</p>", $correo);
echo "<p>Teléfono: " . $telefono . "</p>";
echo "<p>Ocupación: " . OCUPACION . "</p>";

// Uso de var_dump para mostrar tipo y valor
echo "<p>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
echo "</p>";
?>
