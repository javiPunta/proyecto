<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="form1.css">
  <title>Login</title>
</head>

<body>
  <!-- << HTML >> -->

  <div class="contact-wrapper">
    <div class="gradient-container">
      <div class="contact-form">
        <!-- 
        USUARIO:javi27
        PASS: Km5cDp7z 
        -->

        <form action="../funciones/botone.php" method="post">
          <label for="usuario">Usuario</label>
          <input type="text" name="nombre_user" />
          <br>
          <br>
          <label>Contraseña</label>
          <input type="password" name="pass" />
          <br>
          <br>
          <div id="espacioB">
            <button type="submit" name="boton" value="sesion" id="espacio1">Iniciar Sesión</button>
        </form>
        <!-- Aquí en este form y el siguiente utilizo el metodo php post para que llame al archivo, 
        en vez de utilizar botones intento buscar nuevas propiedades para ahorrarme crear mas botones
        en botones.php en un futuro y coger el mejor metodo -->
        <form action="form.php" method="post">
          <button type="submit" name="boton" value="registrar">Registrarse</button>
        </form>

      </div>
    </div>
  </div>
  </div>


  <form action="../index1.php" method="post">
    <button type="submit" name="boton" value="volver" id="espacioVA">Volver Atras</button>
  </form>

</body>

</html>