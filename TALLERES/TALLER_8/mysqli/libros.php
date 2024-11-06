<?php
require_once "config.php";

function agregarLibro($conn, $titulo, $autor, $isbn, $anio, $cantidad) {
    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, isbn, anio, cantidad) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $titulo, $autor, $isbn, $anio, $cantidad);
    if (!$stmt->execute()) {
        throw new Exception("Error al agregar el libro: " . $stmt->error);
    }
    echo "Libro agregado con éxito.";
}

function listarLibros($conn, $pagina, $registrosPorPagina) {
    $inicio = ($pagina - 1) * $registrosPorPagina;
    $result = $conn->query("SELECT * FROM libros LIMIT $inicio, $registrosPorPagina");
    while ($row = $result->fetch_assoc()) {
        echo $row['titulo'] . " - " . $row['autor'] . "<br>";
    }
}

// Ejemplo de uso
try {
    agregarLibro($conn, "Libro Ejemplo", "Autor Ejemplo", "123456789", 2022, 10);
    listarLibros($conn, 1, 10);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
