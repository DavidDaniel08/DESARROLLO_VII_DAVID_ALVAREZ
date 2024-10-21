<?php
require_once 'Empresa.php';

// Crear una instancia de la clase Empresa
$empresa = new Empresa();

// Crear empleados
$gerente1 = new Gerente("Carlos Pérez", 1, 5000, "Ventas");
$gerente1->asignarBono(1000);

$desarrollador1 = new Desarrollador("Carlos Rivas", 2, 4000, "PHP", "Senior");

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente1);
$empresa->agregarEmpleado($desarrollador1);

// Listar empleados
echo "<h2>Listado de Empleados:</h2>";
$empresa->listarEmpleados();

// Calcular la nómina total
echo "<h2>Nómina Total:</h2>";
echo "La nómina total es: " . $empresa->calcularNominaTotal() . "<br>";

// Realizar evaluaciones de desempeño
echo "<h2>Evaluaciones de Desempeño:</h2>";
$empresa->realizarEvaluaciones();

// Ejemplo de manejo de error
class EmpleadoNoEvaluable extends Empleado {}

$empleadoNoEvaluable = new EmpleadoNoEvaluable("Pedro López", 3, 3500);
$empresa->agregarEmpleado($empleadoNoEvaluable);

echo "<h2>Evaluaciones con empleado no evaluable:</h2>";
$empresa->realizarEvaluaciones();
?>
