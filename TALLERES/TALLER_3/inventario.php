<?php

// Función para leer el inventario desde el archivo JSON
function leerInventario($archivo) {
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

// Función para ordenar el inventario alfabéticamente por nombre
function ordenarInventarioAlfabeticamente($inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
    return $inventario;
}

// Función para mostrar un resumen del inventario
function mostrarResumenInventario($inventario) {
    echo "Resumen del inventario:\n";
    foreach ($inventario as $producto) {
        echo "Producto: " . $producto['nombre'] . "\n";
        echo "Precio: $" . number_format($producto['precio'], 2) . "\n";
        echo "Cantidad: " . $producto['cantidad'] . "\n\n";
    }
}

// Función para calcular el valor total del inventario
function calcularValorTotalInventario($inventario) {
    $total = array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
    return $total;
}

// Función para generar un informe de productos con stock bajo
function generarInformeStockBajo($inventario) {
    $productosBajoStock = array_filter($inventario, function($producto) {
        return $producto['cantidad'] < 5;
    });
    
    if (count($productosBajoStock) > 0) {
        echo "Productos con stock bajo (menos de 5 unidades):\n";
        foreach ($productosBajoStock as $producto) {
            echo "Producto: " . $producto['nombre'] . " - Cantidad: " . $producto['cantidad'] . "\n";
        }
    } else {
        echo "No hay productos con stock bajo.\n";
    }
}

// Archivo JSON con el inventario
$archivo = 'inventario.json';

// Leer el inventario
$inventario = leerInventario($archivo);

// Ordenar el inventario alfabéticamente
$inventarioOrdenado = ordenarInventarioAlfabeticamente($inventario);

// Mostrar el resumen del inventario
mostrarResumenInventario($inventarioOrdenado);

// Calcular el valor total del inventario
$totalValor = calcularValorTotalInventario($inventarioOrdenado);
echo "El valor total del inventario es: $" . number_format($totalValor, 2) . "\n\n";

// Generar informe de productos con stock bajo
generarInformeStockBajo($inventarioOrdenado);

?>
