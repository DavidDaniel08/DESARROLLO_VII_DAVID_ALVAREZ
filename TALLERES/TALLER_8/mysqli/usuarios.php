<?php
require_once "config.php";

function agregarUsuario($conn, $nombre, $email, $contrasena) {
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $contrasena_hash);
    if (!$stmt->execute()) {
        throw new Exception("Error al agregar el usuario: " . $stmt->error);
    }
    echo "Usuario agregado con éxito.<br>";
}

function listarUsuarios($conn, $pagina, $registrosPorPagina) {
    $inicio = ($pagina - 1) * $registrosPorPagina;
    $result = $conn->query("SELECT * FROM usuarios LIMIT $inicio, $registrosPorPagina");
    while ($row = $result->fetch_assoc()) {
        echo $row['nombre'] . " - " . $row['email'] . "<br>";
    }
}

function buscarUsuarioPorNombre($conn, $nombre) {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre LIKE ?");
    $nombre = "%$nombre%";
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo $row['nombre'] . " - " . $row['email'] . "<br>";
    }
}

function actualizarUsuario($conn, $id, $nombre, $email, $contrasena = null) {
    if ($contrasena) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, contrasena = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $email, $contrasena_hash, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $email, $id);
    }
    if (!$stmt->execute()) {
        throw new Exception("Error al actualizar el usuario: " . $stmt->error);
    }
    echo "Usuario actualizado con éxito.<br>";
}

function eliminarUsuario($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        throw new Exception("Error al eliminar el usuario: " . $stmt->error);
    }
    echo "Usuario eliminado con éxito.<br>";
}

// Ejemplo de uso
try {
    agregarUsuario($conn, "Carlos Rivas", "carlos@example.com", "segura123");
    listarUsuarios($conn, 1, 10);
    buscarUsuarioPorNombre($conn, "Carlos");
    actualizarUsuario($conn, 1, "Carlos R", "carlosr@example.com");
    eliminarUsuario($conn, 1);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

