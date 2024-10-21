<?php

class Estudiante {
    private $id;
    private $nombre;
    private $edad;
    private $carrera;
    private $materias = [];

    public function __construct($id, $nombre, $edad, $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
    }

    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio() {
        if (empty($this->materias)) return 0;
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio()
        ];
    }

    public function __toString() {
        return "{$this->nombre} (ID: {$this->id}) - Promedio: " . number_format($this->obtenerPromedio(), 2);
    }
}


class SistemaGestionEstudiantes {
    private $estudiantes = [];
    private $graduados = [];

    public function agregarEstudiante(Estudiante $estudiante) {
        $this->estudiantes[$estudiante->obtenerDetalles()['id']] = $estudiante;
    }

    public function obtenerEstudiante($id) {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes() {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral() {
        $totalPromedio = array_reduce($this->estudiantes, function($carry, $estudiante) {
            return $carry + $estudiante->obtenerPromedio();
        }, 0);
        return $totalPromedio / count($this->estudiantes);
    }

    public function obtenerEstudiantesPorCarrera($carrera) {
        return array_filter($this->estudiantes, function($estudiante) use ($carrera) {
            return $estudiante->obtenerDetalles()['carrera'] === $carrera;
        });
    }

    public function obtenerMejorEstudiante() {
        return array_reduce($this->estudiantes, function($mejor, $estudiante) {
            return ($mejor === null || $estudiante->obtenerPromedio() > $mejor->obtenerPromedio()) ? $estudiante : $mejor;
        });
    }

    public function generarReporteRendimiento() {
        $reporte = [];
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->obtenerDetalles()['materias'] as $materia => $calificacion) {
                if (!isset($reporte[$materia])) {
                    $reporte[$materia] = ['total' => 0, 'cantidad' => 0, 'max' => 0, 'min' => 100];
                }
                $reporte[$materia]['total'] += $calificacion;
                $reporte[$materia]['cantidad']++;
                $reporte[$materia]['max'] = max($reporte[$materia]['max'], $calificacion);
                $reporte[$materia]['min'] = min($reporte[$materia]['min'], $calificacion);
            }
        }

        foreach ($reporte as $materia => $datos) {
            echo "Materia: $materia | Promedio: " . number_format($datos['total'] / $datos['cantidad'], 2) .
                " | Máximo: {$datos['max']} | Mínimo: {$datos['min']}\n";
        }
    }

    public function graduarEstudiante($id) {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
        }
    }

    public function generarRanking() {
        usort($this->estudiantes, function($a, $b) {
            return $b->obtenerPromedio() <=> $a->obtenerPromedio();
        });
        return $this->estudiantes;
    }
}


// Crear el sistema
$sistema = new SistemaGestionEstudiantes();

// Añadir estudiantes
$sistema->agregarEstudiante(new Estudiante(1, 'Carlos Rivas', 20, 'Ingeniería de Sistemas'));
$sistema->agregarEstudiante(new Estudiante(2, 'Ana Pérez', 22, 'Medicina'));
$sistema->agregarEstudiante(new Estudiante(3, 'José Fernández', 21, 'Derecho'));

// Añadir materias a los estudiantes
$sistema->obtenerEstudiante(1)->agregarMateria('Matemáticas', 85);
$sistema->obtenerEstudiante(1)->agregarMateria('Programación', 90);
$sistema->obtenerEstudiante(2)->agregarMateria('Anatomía', 75);
$sistema->obtenerEstudiante(2)->agregarMateria('Fisiología', 80);
$sistema->obtenerEstudiante(3)->agregarMateria('Derecho Civil', 88);

// Mostrar estudiantes
echo"<br>";
echo "Lista de estudiantes:\n";
foreach ($sistema->listarEstudiantes() as $estudiante) {
    echo $estudiante . "\n";
}

// Promedio general del sistema
echo"<br>";
echo "\nPromedio general: " . number_format($sistema->calcularPromedioGeneral(), 2) . "\n";

// Mejor estudiante
echo"<br>";
echo "\nMejor estudiante: " . $sistema->obtenerMejorEstudiante() . "\n";

// Generar reporte de rendimiento
echo"<br>";
echo "\nReporte de rendimiento:\n";
$sistema->generarReporteRendimiento();

?>