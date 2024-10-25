<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['tareas'])) {
    $_SESSION['tareas'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $fecha_limite = $_POST['fecha_limite'];

    if (!empty($titulo) && !empty($fecha_limite) && strtotime($fecha_limite) > time()) {
        $_SESSION['tareas'][] = [
            'titulo' => $titulo,
            'fecha_limite' => $fecha_limite
        ];
    } else {
        $error = "Debe llenar todos los campos con una fecha futura";
    }
}

?>

<html>
<head>
    <title>Parcial 3</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <h3>Lista de Tareas</h3>
    <ul>
        <?php foreach ($_SESSION['tareas'] as $tarea) { ?>
            <li><?php echo $tarea['titulo'] . " - Fecha limite: " . $tarea['fecha_limite']; ?></li>
        <?php } ?>
    </ul>

    <h3>Agregar tarea</h3>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="POST">
        Título: <input type="text" name="titulo" required><br>
        Fecha Límite: <input type="date" name="fecha_limite" required><br>
        <input type="submit" value="Agregar tarea">
    </form>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
