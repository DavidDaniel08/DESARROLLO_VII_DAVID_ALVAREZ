<?php
// Patrón de triángulo rectángulo usando un bucle for
echo "<h3>Patrón de triángulo rectángulo:</h3>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>"; // Salto de línea después de cada fila
}

echo "<br>"; // Salto de línea para separar secciones

// Generación de números impares del 1 al 20 usando un bucle while
echo "<h3>Números impares del 1 al 20:</h3>";
$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) {
        echo $numero . " ";
    }
    $numero++;
}
echo "<br><br>"; // Salto de línea después de la lista de números impares

// Contador regresivo desde 10 hasta 1 usando un bucle do-while, saltando el número 5
echo "<h3>Contador regresivo desde 10 hasta 1 (sin mostrar el número 5):</h3>";
$contador = 10;
do {
    if ($contador != 5) {
        echo $contador . " ";
    }
    $contador--;
} while ($contador >= 1);

echo "<br>"; // Salto de línea al final del contador regresivo

?>
