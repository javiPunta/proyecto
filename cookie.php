<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cookie.css">
    <title>Cookies rechazadas</title>
</head>

<body>
    <?php

    // -- <<PHP>> --
    if (isset($_POST["volver"])) {
        header("Location:index.php");
    }

    ?>

    <!-- << HTML >> -->
    <img src="img/cookie/cookie.jpg" alt="cookies">
    
    <form action="cookie.php" method="post">

        <input type="submit" name="volver" value="Volver atrás">

    </form>
</body>

</html>