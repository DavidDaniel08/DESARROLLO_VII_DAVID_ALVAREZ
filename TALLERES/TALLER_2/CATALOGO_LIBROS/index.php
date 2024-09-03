<?php
// Incluir los archivos necesarios
require_once 'includes/funciones.php';
include 'includes/header.php';

// Obtener la lista de libros
$libros = obtenerLibros();

// Mostrar la lista de libros con sus detalles
foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}

// Incluir el pie de página
include 'includes/footer.php';
?>
