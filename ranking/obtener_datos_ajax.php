<?php
// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor
$etiquetas = ["Enero", "Febrero", "Marzo", "Abril"];
$datosPuntos = [5000, 1500, 8000, 5102];
// Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
$respuesta = [
    "etiquetas" => $etiquetas,
    "datos" => $datosPuntos,
];
echo json_encode($respuesta);
