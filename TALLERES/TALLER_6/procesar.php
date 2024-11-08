<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

// Función para calcular la edad basada en la fecha de nacimiento
function calcularEdad($fecha_nacimiento) {
    $fecha_actual = new DateTime();
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    return $fecha_actual->diff($fecha_nacimiento_dt)->y;
}

// Leer los datos previos en caso de errores
$datosPrevios = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

    // Procesar y validar cada campo
    $campos = ['nombre', 'email', 'fecha_nacimiento', 'sitio_web', 'genero', 'intereses', 'comentarios'];
    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valor = $_POST[$campo];
            $valorSanitizado = call_user_func("sanitizar" . ucfirst($campo), $valor);
            $datos[$campo] = $valorSanitizado;

            if (!call_user_func("validar" . ucfirst($campo), $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }

    // Calcular la edad automáticamente
    if (!empty($datos['fecha_nacimiento'])) {
        $datos['edad'] = calcularEdad($datos['fecha_nacimiento']);
    }

    // Procesar la foto de perfil con un nombre único
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (!validarFotoPerfil($_FILES['foto_perfil'])) {
            $errores[] = "La foto de perfil no es válida.";
        } else {
            $nombre_foto_original = $_FILES['foto_perfil']['name'];
            $nombre_foto_unico = uniqid() . "_" . $nombre_foto_original; // Generar nombre único
            $rutaDestino = 'uploads/' . $nombre_foto_unico;
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $datos['foto_perfil'] = $rutaDestino;
            } else {
                $errores[] = "Hubo un error al subir la foto de perfil.";
            }
        }
    }

    // Modificar la sección de mostrar resultados
    if (empty($errores)) {
        // Guardar los datos en un archivo JSON
        $archivo = 'registros.json';
        $registros = [];
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $registros = json_decode($contenido, true);
        }
        $registros[] = $datos;
        file_put_contents($archivo, json_encode($registros));

        echo "<h2>Datos Recibidos:</h2>";
        echo "<table border='1'>";
        foreach ($datos as $campo => $valor) {
            echo "<tr>";
            echo "<th>" . ucfirst($campo) . "</th>";
            if ($campo === 'intereses') {
                echo "<td>" . implode(", ", $valor) . "</td>";
            } elseif ($campo === 'foto_perfil') {
                echo "<td><img src='$valor' width='100'></td>";
            } else {
                echo "<td>$valor</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>Errores:</h2>";
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";

        // Guardar los datos previos para mostrarlos en el formulario
        $datosPrevios = $datos;
    }

    echo "<br><a href='formulario.html'>Volver al formulario</a>";
}
?>
