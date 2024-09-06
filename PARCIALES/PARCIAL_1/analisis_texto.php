<?php
include 'utilidades_texto.php';

$frases = [
    "Me gusta jugar valorant",
    "Trabajo como soporte tecnico",
    "Me gusta dormir y esscuchar musica"
];

echo "<table border='10' cellpadding='25'>";
echo "<tr><th>Frase</th><th>Conteo de Palabras</th><th>Conteo de Vocales</th><th>Frase Invertida</th></tr>";

foreach ($frases as $frase) {
    $conteo_palabras = contar_palabras($frase);
    $conteo_vocales = contar_vocales($frase);
    $frase_invertida = invertir_palabras($frase);
    
    echo "<tr>";
    echo "<td>$frase</td>";
    echo "<td>$conteo_palabras</td>";
    echo "<td>$conteo_vocales</td>";
    echo "<td>$frase_invertida</td>";
    echo "</tr>";
}

echo "</table>";
?>
