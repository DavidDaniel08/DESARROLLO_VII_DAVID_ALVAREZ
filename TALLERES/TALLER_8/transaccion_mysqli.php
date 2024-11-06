<?php
require_once "config_pdo.php";

function log_error($message) {
    file_put_contents("error_log.txt", date("Y-m-d H:i:s") . " - " . $message . "\n", FILE_APPEND);
}

try {
    $pdo->beginTransaction();

    // Insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => 'Nuevo Usuario', ':email' => 'nuevo@example.com']);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }
    $usuario_id = $pdo->lastInsertId();

    // Insertar una publicación para ese usuario
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Nueva Publicación',
        ':contenido' => 'Contenido de la nueva publicación'
    ]);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    $pdo->commit();
    echo "Transacción completada con éxito.";
} catch (Exception $e) {
    $pdo->rollBack();
    log_error($e->getMessage());
    echo "Error en la transacción: " . $e->getMessage();
}
?>
