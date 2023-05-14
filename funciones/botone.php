<?php
require "funcione.php";

session_start();

if (isset($_POST["boton"])) {
  $nombre_user = $_POST["nombre_user"];
  $pass = $_POST["pass"];
 

  $repe = BuscarRepe($nombre_user);

  if ($_POST["boton"] == 'aniadir') {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    if(validarNombreUser($nombre_user) && validarNombre($nombre) && validarEmail($correo) && validarContrasena($pass)) {
      if ($repe == 0) {
        crear_jugador($nombre_user, $nombre, $correo, $pass);
        exit;
      } else {
        echo ("<h3>Ya existe ese usuario.</h3>");
      }
    }
  } else if ($_POST["boton"] == 'borrar') {
    if (isset($nombre_user)) {
      if ($repe != 0) {
        borrar_jugador($nombre_user);
        exit;
      } else {
        echo ("<h3>No existe ese user_name.</h3>");
      }
    }
   }  else if ($_POST["boton"] == 'sesion') {
    if (isset($nombre_user) && isset($pass)) {
        $compro1=validarNombreUser(($nombre_user));
        $compro2=validarContrasena(($pass));
        if($compro1==true && $compro2==true){
          $_SESSION['nombre_user'] = $nombre_user;
          header('Location: ../Juegos/juegos.php');
          exit();
        }

  }

} else if (isset($_POST["boton"]) && $_POST["boton"] == 'modificar') {
  // Obtener los datos del formulario
  $nombre_user = $_POST["nombre_user"];
  $nombre = $_POST["nombre"];
  $correo = $_POST["correo"];
  $pass = $_POST["pass"];

  // Llamar a la función actualizar_usuario() con los datos del formulario
  modificarUser($nombre_user, $nombre, $correo, $pass);
}else{
  echo "No existe ese usuario";
}


}
