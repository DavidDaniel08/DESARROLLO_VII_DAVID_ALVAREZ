<?php
// Declaración de la variable calificación
$calificacion = 85; 

// Determinación de la letra correspondiente usando if-elseif-else
if ($calificacion >= 90 && $calificacion <= 100) {
    $letra = "A";
} elseif ($calificacion >= 80 && $calificacion < 90) {
    $letra = "B";
} elseif ($calificacion >= 70 && $calificacion < 80) {
    $letra = "C";
} elseif ($calificacion >= 60 && $calificacion < 70) {
    $letra = "D";
} else {
    $letra = "F";
}

// Impresión de la calificación en letra
echo "Tu calificación es $letra. ";

// Uso del operador ternario para determinar si es aprobado o reprobado
echo ($letra != "F") ? "Aprobado" : "Reprobado";

// Mensaje adicional basado en la letra de la calificación usando switch
switch ($letra) {
    case "A":
        echo " - Excelente trabajo.";
        break;
    case "B":
        echo " - Buen trabajo.";
        break;
    case "C":
        echo " - Trabajo aceptable.";
        break;
    case "D":
        echo " - Necesitas mejorar.";
        break;
    case "F":
        echo " - Debes esforzarte más.";
        break;
}

?>
