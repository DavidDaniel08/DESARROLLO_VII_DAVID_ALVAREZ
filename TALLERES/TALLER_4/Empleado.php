<?php
// Clase base que representa un empleado genérico
class Empleado {
    // Propiedades protegidas, accesibles desde clases hijas
    protected $nombre;
    protected $idEmpleado;
    protected $salarioBase;

    // Constructor para inicializar las propiedades
    public function __construct($nombre, $idEmpleado, $salarioBase) {
        $this->nombre = $nombre;
        $this->idEmpleado = $idEmpleado;
        $this->salarioBase = $salarioBase;
    }

    // Getters y setters para las propiedades, respetando el principio de encapsulación
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    public function getSalarioBase() {
        return $this->salarioBase;
    }

    public function setSalarioBase($salarioBase) {
        $this->salarioBase = $salarioBase;
    }

    // Método que puede ser sobrescrito en las clases hijas
    public function obtenerInformacion() {
        return "Nombre: $this->nombre, ID: $this->idEmpleado, Salario Base: $this->salarioBase";
    }
}
?>
