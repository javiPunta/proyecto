<!-- NO QUIERO QUE ME TARDE TANTO LA IMAGEN EN CARGAR
QUIERO QUE TANTO LOS ENLACES COMO LAS IMAGENES ESTEN EN FILA -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="juegos.css">

    <title>Document</title>
</head>
<body>
<div class="user">
<?php
session_start();
if(isset($_SESSION['nombre_user'])){
  echo "Bienvenido " . $_SESSION['nombre_user'];
} else{
  session_destroy();
  header('Location: ../forms/login.php');
  exit;
}
?>
</div>
<div class="row">
  <div class="container container2">
  <a href="Dinosaurio/dino.php">
      <img src="../img/arka/juegod.png" alt="">
      Dinosaurio</a>
  </div>
  <div class="container container1">
  <a href="Memoramas/memorama.php">
      <img src="../img/memo/juegom.png" alt="">
      Memorama</a>
  </div>
</div>
<form action="../index1.php" method="post">
    <button type="submit" name="boton" value="volver" id="espacioVA">Volver Atras</button>
  </form>
</body>
</html>
