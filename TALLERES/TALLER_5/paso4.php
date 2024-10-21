<?php
// Paso 4: Ordenamiento y Filtrado Avanzado de Arreglos

// 1. Definir el arreglo de libros
$biblioteca = [
    [
        "titulo" => "Cien años de soledad",
        "autor" => "Gabriel García Márquez",
        "año" => 1967,
        "genero" => "Realismo mágico",
        "prestado" => true
    ],
    [
        "titulo" => "1984",
        "autor" => "George Orwell",
        "año" => 1949,
        "genero" => "Ciencia ficción",
        "prestado" => false
    ],
    [
        "titulo" => "El principito",
        "autor" => "Antoine de Saint-Exupéry",
        "año" => 1943,
        "genero" => "Literatura infantil",
        "prestado" => true
    ],
    [
        "titulo" => "Don Quijote de la Mancha",
        "autor" => "Miguel de Cervantes",
        "año" => 1605,
        "genero" => "Novela",
        "prestado" => false
    ],
    [
        "titulo" => "Orgullo y prejuicio",
        "autor" => "Jane Austen",
        "año" => 1813,
        "genero" => "Novela romántica",
        "prestado" => true
    ]
];

// 2. Función para imprimir la biblioteca
function imprimirBiblioteca($libros) {
    foreach ($libros as $libro) {
        echo"<br>";
        echo "{$libro['titulo']} - {$libro['autor']} ({$libro['año']}) - {$libro['genero']} - " . 
            ($libro['prestado'] ? "Prestado" : "Disponible") . "\n";
    }
    echo "\n";
}

echo "Biblioteca original:\n";
imprimirBiblioteca($biblioteca);

// 3. Ordenar libros por año de publicación (del más antiguo al más reciente)
usort($biblioteca, function($a, $b) {
    return $a['año'] - $b['año'];
});

echo "Libros ordenados por año de publicación:\n";
imprimirBiblioteca($biblioteca);

// 4. Ordenar libros alfabéticamente por título
usort($biblioteca, function($a, $b) {
    return strcmp($a['titulo'], $b['titulo']);
});

echo "Libros ordenados alfabéticamente por título:\n";
imprimirBiblioteca($biblioteca);

// 5. Filtrar libros disponibles (no prestados)
$librosDisponibles = array_filter($biblioteca, function($libro) {
    return !$libro['prestado'];
});

echo "Libros disponibles:\n";
imprimirBiblioteca($librosDisponibles);

// 6. Filtrar libros por género
function filtrarPorGenero($libros, $genero) {
    return array_filter($libros, function($libro) use ($genero) {
        return strcasecmp($libro['genero'], $genero) === 0;
    });
}

$librosCienciaFiccion = filtrarPorGenero($biblioteca, "Ciencia ficción");
echo "Libros de Ciencia ficción:\n";
imprimirBiblioteca($librosCienciaFiccion);

// 7. Obtener lista de autores únicos
$autores = array_unique(array_column($biblioteca, 'autor'));
sort($autores);

echo "Lista de autores:\n";
foreach ($autores as $autor) {
    echo "- $autor\n";
}
echo "\n";

// 8. Calcular el año promedio de publicación
$añoPromedio = array_sum(array_column($biblioteca, 'año')) / count($biblioteca);
echo "Año promedio de publicación: " . round($añoPromedio, 2) . "\n\n";

// 9. Encontrar el libro más antiguo y el más reciente
$libroMasAntiguo = array_reduce($biblioteca, function($carry, $libro) {
    return (!$carry || $libro['año'] < $carry['año']) ? $libro : $carry;
});

$libroMasReciente = array_reduce($biblioteca, function($carry, $libro) {
    return (!$carry || $libro['año'] > $carry['año']) ? $libro : $carry;
});

echo "Libro más antiguo: {$libroMasAntiguo['titulo']} ({$libroMasAntiguo['año']})\n";
echo "Libro más reciente: {$libroMasReciente['titulo']} ({$libroMasReciente['año']})\n\n";

// 10. TAREA: Implementa una función de búsqueda que permita buscar libros por título o autor
// La función debe ser capaz de manejar búsquedas parciales y no debe ser sensible a mayúsculas/minúsculas
function buscarLibros($biblioteca, $termino) {
    // Tu código aquí
    // Convertimos el término de búsqueda a minúsculas para que no sea sensible a mayúsculas/minúsculas
    $termino = strtolower($termino);
    
    // Array donde guardaremos los resultados de la búsqueda
    $resultados = [];

    // Recorremos la biblioteca
    foreach ($biblioteca as $libro) {
        // Convertimos el título y autor a minúsculas para comparar de forma insensible a mayúsculas
        $titulo = strtolower($libro['titulo']);
        $autor = strtolower($libro['autor']);
        
        // Si el término está en el título o el autor, añadimos el libro a los resultados
        if (strpos($titulo, $termino) !== false || strpos($autor, $termino) !== false) {
            $resultados[] = $libro;
        }
    }
    
    return $resultados;
}

$resultados = buscarLibros($biblioteca, 'sol');
print_r($resultados);

// Ejemplo de uso de la función de búsqueda (descomenta para probar)
// $resultadosBusqueda = buscarLibros($biblioteca, "quijote");
// echo "Resultados de búsqueda para 'quijote':\n";
// imprimirBiblioteca($resultadosBusqueda);

// 11. TAREA: Crea una función que genere un reporte de la biblioteca
// El reporte debe incluir: número total de libros, número de libros prestados,
// número de libros por género, y el autor con más libros en la biblioteca

function generarReporteBiblioteca($biblioteca) {
    $totalLibros = count($biblioteca);
    $librosPrestados = 0;
    $librosPorGenero = [];
    $autores = [];

    foreach ($biblioteca as $libro) {
        // Contar libros prestados
        if (isset($libro['prestado']) && $libro['prestado']) {
            $librosPrestados++;
        }

        // Contar libros por género
        if (isset($libro['genero'])) {
            if (!isset($librosPorGenero[$libro['genero']])) {
                $librosPorGenero[$libro['genero']] = 0;
            }
            $librosPorGenero[$libro['genero']]++;
        }

        // Contar libros por autor
        if (isset($libro['autor'])) {
            if (!isset($autores[$libro['autor']])) {
                $autores[$libro['autor']] = 0;
            }
            $autores[$libro['autor']]++;
        }
    }

    // Autor con más libros
    $autorMasLibros = array_keys($autores, max($autores))[0];

    // Generar el reporte
    $reporte = [
        'totalLibros' => $totalLibros,
        'librosPrestados' => $librosPrestados,
        'librosPorGenero' => $librosPorGenero,
        'autorConMasLibros' => $autorMasLibros
    ];

    return $reporte;
}

$reporte = generarReporteBiblioteca($biblioteca);
print_r($reporte);
// Ejemplo de uso de la función de reporte (descomenta para probar)
// echo "Reporte de la Biblioteca:\n";
// print_r(generarReporteBiblioteca($biblioteca));

?>
   