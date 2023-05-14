<?php
 // Recuperamos los valores enviados por el formulario
 $p1 = $_POST['p1'];
 $p2 = $_POST['p2'];
 $p3 = $_POST['p3'];
 $p4 = $_POST['p4'];
 $p5 = $_POST['p5'];
 
 // Procesamos los valores como se desee, por ejemplo, guardarlos en un archivo de texto
 $file = 'encuesta.txt';
 $current = file_get_contents($file);
 $current .= "Pregunta 1: " . ($p1 == 0 ? 'Sí' : 'No') . "\n";
 $current .= "Pregunta 2: " . ($p2 == 0 ? 'Sí' : 'No') . "\n";
 $current .= "Pregunta 3: " . ($p3 == 0 ? 'Sí' : 'No') . "\n";
 $current .= "Pregunta 4: " . ($p4 == 0 ? 'Sí' : 'No') . "\n";
 $current .= "Pregunta 5: " . ($p5 == 0 ? 'Sí' : 'No') . "\n\n";
 file_put_contents($file, $current);
 
 // Redirigimos al usuario a una página de confirmación
 header('Location: confirmacion.html');
 ?> 