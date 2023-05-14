<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="finalizarPartida()">

</body>
<script>
    function finalizarPartida() {


        const confirmacion = confirm("¿Quieres terminar cerrando sesión o ver el ranking?");
        if (confirmacion) {
            window.location.href = '../../forms/logout.php';
        } else {
            window.location.href = 'ranking/grafico.html';
        }

    }
</script>

</html>