<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="form1.css">
  <title>Registro</title>
</head>

<body>
  <div class="contact-wrapper">
  <div class="gradient-container">
    <div class="contact-form">
      <form action="../funciones/botone.php" method="post">

        <br>
        Nombre Usuario: <input name="nombre_user" type="text" placeholder="50 caracteres máximo. *" required />
        <br>
        <br>
        Nombre completo: <input name="nombre" type="text" placeholder="60 caracteres máximo." />
        <br>
        <br>
        Correo electrónico: <input name="correo" type="text" placeholder="60 caracteres máximo. *" required />
        <br>
        <br>
        Contraseña: <input name="pass" type="password" placeholder="********" required />

        <br>
     
        <br><br>

        <button type="submit" name="boton" value="aniadir">Registrar</button>
        <!-- esto tiene que ir una vez este iniciada sesion -->
        <!-- ?php if (isset($_SESSION['usuario'])) { ?> -->
        <button type="submit" name="boton" value="borrar">Borrar</button>
        <button type="submit" name="boton" value="modificar">Modificar</button> 
        <!-- ?php } ?> -->

        
        <button type="submit" name="boton" value="volver" id="espacio">Volver Atras</button>




      </form>
      </div>
    </div>
  </div>

</body>

</html>