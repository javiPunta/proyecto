<?php
// -- <<PHP>> --
require "funcione.php";

session_start();

// -- <<BOTONES>> --
// Cada vez que presionas un botón, siempre tienes que tener en cuenta que en los campos que son require
// o que veas en el form esto * tienes que rellenarlos si o si.

// Primero busca que exista el name="boton" y luego se está asignando el valor del campo de entrada 
// del formulario HTML con el atributo "name" establecido en "nombre_user" o "pass" o lo que quiera
// reibir la variable tiene el nombre $nombre_user o $pass el script PHP.

//  A lo largo del codigo veremos más valores ingresados por el usuario en el formulario
//  para realizar alguna acción.
if (isset($_POST["boton"])) {
  $nombre_user = $_POST["nombre_user"];
  $pass = $_POST["pass"];

  //Llama a la funcion BuscarRepe para ver si existen o no nombres de usuarios repetidos.
  $repe = BuscarRepe($nombre_user);

  //BOTÓN AÑADIR
  // Este código se utiliza para procesar un formulario de registro de un nuevo jugador, pero antes mira
  // que el boton presionado tenga el value="aniadir" para que haga todo lo que hay dentro de la condición,
  // valida todos los campos que esten correctos y busca que ese jugador(user_name) no este repetido
  // si ya existe te enviará un mensaje.
  if ($_POST["boton"] == 'aniadir') {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    if (validarNombreUser($nombre_user) && validarNombre($nombre) && validarEmail($correo) && validarContrasena($pass)) {
      if ($repe == 0) {
        crear_jugador($nombre_user, $nombre, $correo, $pass);
        exit;
      } else {
        echo ("<h3>Ya existe ese usuario.</h3>");
      }
    }

    //BOTÓN ELIMINAR
    // Este código se utiliza para procesar un formulario de registro de un nuevo jugador, procesar la 
    // eliminación de un jugador pero antes mira que el boton presionado tenga el value="borrar" para 
    // que haga todo lo que hay dentro de la condición y busca que ese jugador(user_name) que este 
    // repetido para poder borrarlo si ya existe te enviará un mensaje.
  } else if ($_POST["boton"] == 'borrar') {
    if (isset($nombre_user)) {
      if ($repe != 0) {
        borrar_jugador($nombre_user);
        exit;
      } else {
        echo ("<h3>No existe ese user_name.</h3>");
      }
    }
    //BOTÓN SESIÓN
    // Este código se utiliza para manejar una solicitud POST para iniciar sesión en un sitio web, pero 
    // antes mira que el boton presionado tenga el value="sesion" para que haga todo lo que hay
    // dentro de la condición, que principalmente miran que nombre_user y pass existan, validan
    // que ambos esten bien escritos.

    // Si ambas validaciones son exitosas, se establece una sesión utilizando la variable
    // global $_SESSION['nombre_user'] y se redirige al usuario a la página juegos.php utilizando el 
    // encabezado HTTP "Location".

    // El comando "exit()" se utiliza para finalizar el script después de redirigir al usuario.

  } else if ($_POST["boton"] == 'sesion') {
    if (isset($nombre_user) && isset($pass)) {
      $compro1 = validarNombreUser(($nombre_user));
      $compro2 = validarContrasena(($pass));
      if ($compro1 == true && $compro2 == true) {
        $_SESSION['nombre_user'] = $nombre_user;
        header('Location: ../Juegos/juegos.php');
        exit();
      }
    }

    //BOTÓN SESIÓN
    // Este código se utiliza para actualizar los datos en la base de datos pero, 
    // antes mira que el botón presionado tenga el value="modificar" para  que haga todo lo que hay
    // dentro de la condición, obtiene los datos del formulario. Llamar a la función actualizar_usuario()
    // con los datos del formulario.

    // TENGO QUE PASARLE LAS VALIDACIONES YA QUE ES EL ULTIMO BOTON QUE HICE
  } else if (isset($_POST["boton"]) && $_POST["boton"] == 'modificar') {

    $nombre_user = $_POST["nombre_user"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $pass = $_POST["pass"];

    modificarUser($nombre_user, $nombre, $correo, $pass);
  } else {
    echo "No existe ese usuario";
  }
}
