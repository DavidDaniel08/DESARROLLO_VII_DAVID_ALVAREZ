
<?php
require_once "config.php";

function registrarPrestamo($pdo, $usuario_id, $libro_id) {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (:usuario_id, :libro_id, NOW())");
        $stmt->execute([':usuario_id' => $usuario_id, ':libro_id' => $libro_id]);

        $stmt = $pdo->prepare("UPDATE libros SET cantidad = cantidad - 1 WHERE id = :libro_id");
        $stmt->execute([':libro_id' => $libro_id]);

        $pdo->commit();
        echo "Préstamo registrado con éxito.";
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
?>
