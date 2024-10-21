<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

// Clase Desarrollador que hereda de Empleado e implementa la interfaz Evaluable
class Desarrollador extends Empleado implements Evaluable {
    private $lenguajePrincipal;
    private $nivelExperiencia;

    // Constructor que inicializa las propiedades del desarrollador
    public function __construct($nombre, $idEmpleado, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Métodos específicos del desarrollador
    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    public function setLenguajePrincipal($lenguajePrincipal) {
        $this->lenguajePrincipal = $lenguajePrincipal;
    }

    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function setNivelExperiencia($nivelExperiencia) {
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Implementación del método evaluarDesempenio de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica para evaluación basada en experiencia
        return "Evaluación del desempeño del desarrollador: Satisfactorio. Nivel: $this->nivelExperiencia";
    }

    // Sobrescribe el método de la clase base para incluir más detalles
    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Lenguaje Principal: $this->lenguajePrincipal, Nivel de Experiencia: $this->nivelExperiencia";
    }
}
?>
