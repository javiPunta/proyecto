<?php
session_start();
if(isset($_SESSION['nombre_user'])){
  echo "Bienvenido " . $_SESSION['nombre_user'];
} else{
  header('Location: login.php');
  exit;
}

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "encuestas";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores de la encuesta
$p1 = $_POST["p1"];
$p2 = $_POST["p2"];
$p3 = $_POST["p3"];
$p4 = $_POST["p4"];
$p5 = $_POST["p5"];

// Insertar los valores en la tabla
$sql = "INSERT INTO resultados_encuesta (p1, p2, p3, p4, p5) VALUES ('$p1', '$p2', '$p3', '$p4', '$p5')";

if ($conn->query($sql) === TRUE) {
    echo "Encuesta guardada correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>
	<link rel="stylesheet" href="encuesta.css">
    
</head>
 
<body>

<h2>Encuesta</h2>
<!-- la tabla se llama "resultados_encuesta" -->
<form  action="guardar_encuesta.php" method="POST">
    <div class="pregunta">
        Pregunta 1: <br>  ¿Ha estado el producto que estabas buscando? <input type="radio" name="p1" value="0"> Si <input type="radio" name="p1" value="1"> No
    </div>
    <br> 
    <div class="pregunta">
        Pregunta 2:<br>  ¿La atención de los empleados ha sido la correcta? <input type="radio" name="p2" value="0"> Si <input type="radio" name="p2" value="1"> No
    </div>
    <br> 
    <div class="pregunta">
        Pregunta 3:<br>  ¿Crees que ha mantenido los precios? <input type="radio" name="p3" value="0"> Si <input type="radio" name="p3" value="1"> No
    </div>
    <br> 
    <div class="pregunta">
        Pregunta 4:<br>  ¿Has comprado producto con marca de la tienda? <input type="radio" name="p4" value="0"> Si <input type="radio" name="p4" value="1"> No
    </div>
    <br> 
    <div class="pregunta">
        Pregunta 5:<br>  ¿Crees que has ahorrado mucho dinero? <input type="radio" name="p5" value="0"> Si <input type="radio" name="p5" value="1"> No
    </div>
    <br> 
    <div>
        <div id="error"></div>
    </div>
    <div>
        <p><input type="submit" value="Enviar"></p>
    </div>
</form>
<div id="resultado"></div>

<script>
    // Creamos el evento click del boton
document.querySelector("input[type=submit]").addEventListener("click",enviar);
 
 // definimos el array que contendra las respuestas de la encuesta
 var resultadoEncuesta=[];
  
 // definimos la variable que contiene el numero de preguntas
 var totalPreguntas=5;
  
 // inicializamos el array de los resultados de la forma:
 // resultadoEncuesta["p1"]=[0,0]
 // resultadoEncuesta["p2"]=[0,0] ...
 inicializarArrayResultados();
  
 //Contiene el numero de encuestas realizadas
 var totalEncuestas=0;
  
 /**
  * Funcion que se ejecuta cada vez que se pulsa sobre el boton "enviar"
  */
 function enviar(e) {
  
     // obtenemos todos los radio seleccionados
     var preguntas=document.querySelectorAll("input[type=radio]:checked");
  
     // si estan todos seleccionados...
     if(preguntas.length==totalPreguntas) {
  
         totalEncuestas++;
         document.getElementById("error").innerHTML="";
  
         // recorremos cada una de las respuestas
         preguntas.forEach(function(pregunta) {
  
             // guardamos en un array bidimensional la respuesta
             resultadoEncuesta[pregunta.name][pregunta.value]++;
  
             // desmarcamos el check
             pregunta.checked=false;
         });
         mostrarResultado();
     }else{
         document.getElementById("error").innerHTML="Selecciona todos los valores...";
     }
  
     // cancelamos el evento para que no continue
     e.preventDefault();
 }
  
 /**
  * Funcion para inidializar el array bidimensional
  */
 function inicializarArrayResultados() {
     for(var i=1;i<=totalPreguntas;i++) {
         resultadoEncuesta["p"+i]=[0,0];
     }
 }
  
 /**
  * Funcion que muestra los resultados en cada votacion
  */
 function mostrarResultado() {
     resultado="";
     resultado+="<h3>De un total de "+totalEncuestas+" encuestados...</h3>";
     for(var i=1;i<=totalPreguntas;i++) {
         resultado+="<div>pregunta "+i+" - Si: "+resultadoEncuesta["p"+i][0]+" No: "+resultadoEncuesta["p"+i][1]+"</div>";
     }
     document.getElementById("resultado").innerHTML=resultado;
 }
 </script>

