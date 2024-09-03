<?php
// Función para obtener la lista de libros
function obtenerLibros() {
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio_publicacion' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo' => 'Cien Años de Soledad',
            'autor' => 'Gabriel García Márquez',
            'anio_publicacion' => 1967,
            'genero' => 'Realismo mágico',
            'descripcion' => 'La historia de la familia Buendía en el pueblo ficticio de Macondo.'
        ],
        [
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'anio_publicacion' => 1949,
            'genero' => 'Distopía',
            'descripcion' => 'Una novela sobre un futuro totalitario y el control estatal.'
        ],
        [
            'titulo' => 'Moby Dick',
            'autor' => 'Herman Melville',
            'anio_publicacion' => 1851,
            'genero' => 'Aventura',
            'descripcion' => 'La historia del capitán Ahab y su obsesión con la ballena blanca.'
        ],
        [
            'titulo' => 'Donde los Árboles Cantan',
            'autor' => 'Laura Gallego García',
            'anio_publicacion' => 2011,
            'genero' => 'Fantasía',
            'descripcion' => 'Una novela que mezcla romance y fantasía en un mundo medieval.'
        ]
    ];
}

// Función para mostrar los detalles de un libro
function mostrarDetallesLibro($libro) {
    return "<div class='libro'>
                <h2>" . $libro['titulo'] . "</h2>
                <p><strong>Autor:</strong> " . $libro['autor'] . "</p>
                <p><strong>Año de Publicación:</strong> " . $libro['anio_publicacion'] . "</p>
                <p><strong>Género:</strong> " . $libro['genero'] . "</p>
                <p><strong>Descripción:</strong> " . $libro['descripcion'] . "</p>
            </div><br>";
}
?>
