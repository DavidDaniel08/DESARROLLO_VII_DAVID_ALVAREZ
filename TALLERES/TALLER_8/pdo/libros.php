<?php
require_once "config.php";

function agregarLibro($pdo, $titulo, $autor, $isbn, $anio, $cantidad) {
    $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor, isbn, anio, cantidad) VALUES (:titulo, :autor, :isbn, :anio, :cantidad)");
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn,
        ':anio' => $anio,
        ':cantidad' => $cantidad
    ]);
    echo "Libro agregado con éxito.";
}

function listarLibros($pdo, $pagina, $registrosPorPagina) {
    $inicio = ($pagina - 1) * $registrosPorPagina;
    $stmt = $pdo->prepare("SELECT * FROM libros LIMIT :inicio, :limite");
    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->bindValue(':limite', $registrosPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    $libros = $stmt->fetchAll();
    foreach ($libros as $libro) {
        echo $libro['titulo'] . " - " . $libro['autor'] . "<br>";
    }
}

// Ejemplo de uso
try {
    agregarLibro($pdo, "Libro Ejemplo", "Autor Ejemplo", "123456789", 2022, 10);
    listarLibros($pdo, 1, 10);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
