<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

// Clase Gerente que hereda de Empleado y añade funcionalidad específica
class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;

    // Constructor que inicializa las propiedades del gerente, incluyendo las heredadas
    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0; // Inicialización del bono
    }

    // Métodos específicos del gerente
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    // Método para asignar un bono al gerente
    public function asignarBono($bono) {
        $this->bono = $bono;
    }

    // Método para obtener el salario total sumando el bono
    public function getSalarioTotal() {
        return $this->salarioBase + $this->bono;
    }

    // Implementación del método evaluarDesempenio de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica de evaluación basada en desempeño
        return "Evaluación del desempeño del gerente: Excelente. Bono asignado: $this->bono";
    }

    // Sobrescribe el método de la clase base para incluir más detalles
    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Departamento: $this->departamento, Salario Total: " . $this->getSalarioTotal();
    }
}
?>
