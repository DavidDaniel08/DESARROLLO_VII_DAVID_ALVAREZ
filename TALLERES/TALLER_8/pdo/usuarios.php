<?php
require_once "config.php";

function agregarUsuario($pdo, $nombre, $email, $contrasena) {
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)");
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':contrasena' => $contrasena_hash
    ]);
    echo "Usuario agregado con éxito.<br>";
}

function listarUsuarios($pdo, $pagina, $registrosPorPagina) {
    $inicio = ($pagina - 1) * $registrosPorPagina;
    $stmt = $pdo->prepare("SELECT * FROM usuarios LIMIT :inicio, :limite");
    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->bindValue(':limite', $registrosPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();
    foreach ($usuarios as $usuario) {
        echo $usuario['nombre'] . " - " . $usuario['email'] . "<br>";
    }
}

function buscarUsuarioPorNombre($pdo, $nombre) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre LIKE :nombre");
    $stmt->execute([':nombre' => "%$nombre%"]);
    $usuarios = $stmt->fetchAll();
    foreach ($usuarios as $usuario) {
        echo $usuario['nombre'] . " - " . $usuario['email'] . "<br>";
    }
}

function actualizarUsuario($pdo, $id, $nombre, $email, $contrasena = null) {
    if ($contrasena) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, email = :email, contrasena = :contrasena WHERE id = :id");
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':contrasena' => $contrasena_hash,
            ':id' => $id
        ]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id");
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':id' => $id
        ]);
    }
    echo "Usuario actualizado con éxito.<br>";
}

function eliminarUsuario($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo "Usuario eliminado con éxito.<br>";
}

// Ejemplo de uso
try {
    agregarUsuario($pdo, "Carlos Rivas", "carlos@example.com", "segura123");
    listarUsuarios($pdo, 1, 10);
    buscarUsuarioPorNombre($pdo, "Carlos");
    actualizarUsuario($pdo, 1, "Carlos R", "carlosr@example.com");
    eliminarUsuario($pdo, 1);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
