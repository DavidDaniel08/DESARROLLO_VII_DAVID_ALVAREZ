<?php
session_start();

$usuarios = [
    'David Alvarez' => 'estudiante7',
    'Eduardo Griffit' => 'profesor7'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $contraseña) {
        $_SESSION['usuario'] = $usuario;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrecta";
    }
}
?>

<html>
<head>
    <title>Parcial 3</title>
</head>
<body>
    <h2>Inicio de sesión</h2>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="POST">
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="contraseña" required><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
