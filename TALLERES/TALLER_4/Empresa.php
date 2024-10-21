<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';

class Empresa {
    private $empleados = [];

    // Método para agregar empleados a la lista
    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    // Método para listar todos los empleados
    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo $empleado->obtenerInformacion() . "<br>";
        }
    }

    // Método para calcular la nómina total de la empresa
    public function calcularNominaTotal() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente) {
                $total += $empleado->getSalarioTotal();
            } else {
                $total += $empleado->getSalarioBase();
            }
        }
        return $total;
    }

    // Método para realizar evaluaciones de desempeño
    public function realizarEvaluaciones() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                // Solo los empleados que implementan Evaluable pueden ser evaluados
                echo $empleado->evaluarDesempenio() . "<br>";
            } else {
                // Manejo de error: empleado no es evaluable
                echo "Error: " . $empleado->getNombre() . " no puede ser evaluado.<br>";
            }
        }
    }
}
?>
