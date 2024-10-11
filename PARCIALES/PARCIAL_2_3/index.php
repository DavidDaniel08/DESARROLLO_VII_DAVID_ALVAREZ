<?php
require_once 'clases.php'; 


$gestor = new GestorBlog();
$archivo_json = 'blog.json';


if (file_exists($archivo_json)) {
    $entradasGuardadas = json_decode(file_get_contents($archivo_json), true);
    if ($entradasGuardadas) {
        foreach ($entradasGuardadas as $entradaData) {
            
            switch ($entradaData['tipo']) {
                case 1:
                    $entrada = new EntradaUnaColumna(
                        $entradaData['id'],
                        $entradaData['fecha_creacion'],
                        $entradaData['titulo'],
                        $entradaData['descripcion']
                    );
                    break;
                case 2:
                    $entrada = new EntradaDosColumnas(
                        $entradaData['id'],
                        $entradaData['fecha_creacion'],
                        $entradaData['titulo1'],
                        $entradaData['descripcion1'],
                        $entradaData['titulo2'],
                        $entradaData['descripcion2']
                    );
                    break;
                case 3:
                    $entrada = new EntradaTresColumnas(
                        $entradaData['id'],
                        $entradaData['fecha_creacion'],
                        $entradaData['titulo1'],
                        $entradaData['descripcion1'],
                        $entradaData['titulo2'],
                        $entradaData['descripcion2'],
                        $entradaData['titulo3'],
                        $entradaData['descripcion3']
                    );
                    break;
            }
            $gestor->agregarEntrada($entrada);
        }
    }
}


$action = $_GET['action'] ?? null;
$id = $_POST['id'] ?? null;

switch ($action) {
    case 'add':
        $tipo = $_POST['tipo'];
        $fecha_creacion = date('Y-m-d');
        
        if ($tipo == 1) {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $entrada = new EntradaUnaColumna($id, $fecha_creacion, $titulo, $descripcion);
        } elseif ($tipo == 2) {
            $titulo1 = $_POST['titulo1'];
            $descripcion1 = $_POST['descripcion1'];
            $titulo2 = $_POST['titulo2'];
            $descripcion2 = $_POST['descripcion2'];
            $entrada = new EntradaDosColumnas($id, $fecha_creacion, $titulo1, $descripcion1, $titulo2, $descripcion2);
        } elseif ($tipo == 3) {
            $titulo1 = $_POST['titulo1'];
            $descripcion1 = $_POST['descripcion1'];
            $titulo2 = $_POST['titulo2'];
            $descripcion2 = $_POST['descripcion2'];
            $titulo3 = $_POST['titulo3'];
            $descripcion3 = $_POST['descripcion3'];
            $entrada = new EntradaTresColumnas($id, $fecha_creacion, $titulo1, $descripcion1, $titulo2, $descripcion2, $titulo3, $descripcion3);
        }

        $gestor->agregarEntrada($entrada);
        break;

    case 'edit':
        $entradaExistente = $gestor->obtenerEntrada($id);
        if ($entradaExistente) {
            $tipo = $_POST['tipo'];
            if ($tipo == 1) {
                $titulo = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $entradaActualizada = new EntradaUnaColumna($id, $entradaExistente->fecha_creacion, $titulo, $descripcion);
            } elseif ($tipo == 2) {
                $titulo1 = $_POST['titulo1'];
                $descripcion1 = $_POST['descripcion1'];
                $titulo2 = $_POST['titulo2'];
                $descripcion2 = $_POST['descripcion2'];
                $entradaActualizada = new EntradaDosColumnas($id, $entradaExistente->fecha_creacion, $titulo1, $descripcion1, $titulo2, $descripcion2);
            } elseif ($tipo == 3) {
                $titulo1 = $_POST['titulo1'];
                $descripcion1 = $_POST['descripcion1'];
                $titulo2 = $_POST['titulo2'];
                $descripcion2 = $_POST['descripcion2'];
                $titulo3 = $_POST['titulo3'];
                $descripcion3 = $_POST['descripcion3'];
                $entradaActualizada = new EntradaTresColumnas($id, $entradaExistente->fecha_creacion, $titulo1, $descripcion1, $titulo2, $descripcion2, $titulo3, $descripcion3);
            }

            $gestor->editarEntrada($id, $entradaActualizada);
        }
        break;

    case 'delete':
        $gestor->eliminarEntrada($id);
        break;

    case 'move_up':
        $gestor->moverEntrada($id, 'up');
        break;

    case 'move_down':
        $gestor->moverEntrada($id, 'down');
        break;
}


$entradasParaGuardar = [];
foreach ($gestor->entradas as $entrada) {
    if ($entrada instanceof EntradaUnaColumna) {
        $entradasParaGuardar[] = [
            'id' => $entrada->id,
            'fecha_creacion' => $entrada->fecha_creacion,
            'tipo' => 1,
            'titulo' => $entrada->titulo,
            'descripcion' => $entrada->descripcion
        ];
    } elseif ($entrada instanceof EntradaDosColumnas) {
        $entradasParaGuardar[] = [
            'id' => $entrada->id,
            'fecha_creacion' => $entrada->fecha_creacion,
            'tipo' => 2,
            'titulo1' => $entrada->titulo1,
            'descripcion1' => $entrada->descripcion1,
            'titulo2' => $entrada->titulo2,
            'descripcion2' => $entrada->descripcion2
        ];
    } elseif ($entrada instanceof EntradaTresColumnas) {
        $entradasParaGuardar[] = [
            'id' => $entrada->id,
            'fecha_creacion' => $entrada->fecha_creacion,
            'tipo' => 3,
            'titulo1' => $entrada->titulo1,
            'descripcion1' => $entrada->descripcion1,
            'titulo2' => $entrada->titulo2,
            'descripcion2' => $entrada->descripcion2,
            'titulo3' => $entrada->titulo3,
            'descripcion3' => $entrada->descripcion3
        ];
    }
}
file_put_contents($archivo_json, json_encode($entradasParaGuardar));


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Blog</title>
</head>
<body>
    <h1>Gestor de Blog</h1>

   
    <form action="index.php?action=add" method="POST">
        <label for="tipo">Tipo de Entrada:</label>
        <select name="tipo" id="tipo">
            <option value="1">Una Columna</option>
            <option value="2">Dos Columnas</option>
            <option value="3">Tres Columnas</option>
        </select>
        <br>

        
        <div id="form-tipo-1">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo">
            <br>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"></textarea>
        </div>

        <div id="form-tipo-2">
            <label for="titulo1">Título 1:</label>
            <input type="text" name="titulo1" id="titulo1">
            <br>
            <label for="descripcion1">Descripción 1:</label>
            <textarea name="descripcion1" id="descripcion1"></textarea>
            <br>
            <label for="titulo2">Título 2:</label>
            <input type="text" name="titulo2" id="titulo2">
            <br>
            <label for="descripcion2">Descripción 2:</label>
            <textarea name="descripcion2" id="descripcion2"></textarea>
        </div>

        <div id="form-tipo-3">
            <label for="titulo1">Título 1:</label>
            <input type="text" name="titulo1" id="titulo1">
            <br>
            <label for="descripcion1">Descripción 1:</label>
            <textarea name="descripcion1" id="descripcion1"></textarea>
            <br>
            <label for="titulo2">Título 2:</label>
            <input type="text" name="titulo2" id="titulo2">
            <br>
            <label for="descripcion2">Descripción 2:</label>
            <textarea name="descripcion2" id="descripcion2"></textarea>
            <br>
            <label for="titulo3">Título 3:</label>
            <input type="text" name="titulo3" id="titulo3">
            <br>
            <label for="descripcion3">Descripción 3:</label>
            <textarea name="descripcion3" id="descripcion3"></textarea>
        </div>

        <input type="submit" value="Agregar Entrada">
    </form>

   
    <h2>Entradas Existentes</h2>
    <ul>
        <?php foreach ($gestor->entradas as $entrada): ?>
            <li>
                <?php echo $entrada->mostrar(); ?>
                <form action="index.php?action=delete" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $entrada->id; ?>">
                    <input type="submit" value="Eliminar">
                </form>
                <form action="index.php?action=move_up" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $entrada->id; ?>">
                    <input type="submit" value="Subir">
                </form>
                <form action="index.php?action=move_down" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $entrada->id; ?>">
                    <input type="submit" value="Bajar">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
      
        const tipoSelect = document.getElementById('tipo');
        const formTipo1 = document.getElementById('form-tipo-1');
        const formTipo2 = document.getElementById('form-tipo-2');
        const formTipo3 = document.getElementById('form-tipo-3');

        tipoSelect.addEventListener('change', function () {
            formTipo1.style.display = 'none';
            formTipo2.style.display = 'none';
            formTipo3.style.display = 'none';

            if (this.value == '1') {
                formTipo1.style.display = 'block';
            } else if (this.value == '2') {
                formTipo2.style.display = 'block';
            } else if (this.value == '3') {
                formTipo3.style.display = 'block';
            }
        });

        tipoSelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
