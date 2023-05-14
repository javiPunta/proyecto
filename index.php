<?php
// -- <<PHP>> --
//Se crea las cookies nada mas entrar en la web.
setcookie("Aceptar", time() + 3600);

$ultiMod = array(
    "fechaHora" => date("d/m/Y H:i:s"),
);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cookie1.css">
    <title>Aceptar o Rechazar cookies</title>
</head>

<body>
<!-- << COOKIES >> -->

    <div class="uno"></div>
    <div class="dos">

        <form action="" method="POST">

            <h1>AVISO LEGAL</h1>

            <span>Datos identificativos:</span>

            <p>
                En cumplimiento con el deber de información recogido en el artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico,
                a continuación se indican los datos de información general del sitio Web (dirección de la página web o blog) y se exponen los datos fiscales de la empresa, siendo responsable de la explotación
                la mercantil PUNTA DEL VERDE (datos de la empresa, del autónomo, etc.).
            </p>

            <span>Objeto del Aviso Legal:</span>

            <p>
                El Aviso Legal regula las condiciones, el acceso y la utilización del sitio Web, sus contenidos y servicios, de pago o gratuitos, puestos a disposición de los Usuarios; y la política de reservas
                de PUNTA DEL VERDE con sus Clientes.
            </p>

            <span>Protección de datos:</span>
            
            <p>
                De conformidad con lo dispuesto en el Art. 5 y 6 de la Ley Orgánica 15/1999 de Protección de Datos de Carácter Personal, así como en los artículos 12, 14 y 18 del R.D. 1720/2007 de 21 de diciembre,
                le informamos que los datos suministrados pasarán a formar parte del fichero «PARTE ENTRADA VIAJEROS» de PUNTA DEL VERDE, inscrito en la Agencia Española de Protección de Datos (AEPD) con el código
                (número de identificación Protección de Datos), autorizando expresamente que los mismos sean objeto de tratamiento para atender su solicitud, consulta y/o reserva. Así mismo, queda informado de la posibilidad
                de ejercer sus derechos de acceso, rectificación, cancelación y oposición (previstos en los artículos 15, 16 y 17 de la LOPD, así como en los artículos 23 a 36 ambos inclusive del R.D. 1720/2007 de 21 de diciembre)
                por medio de comunicación a la siguiente dirección de correo electrónico (e-mail). También mediante carta dirigida a la dirección arriba indicada.
            </p>

            <span>Propiedad intelectual:</span>

            <p>
                La información y los contenidos que se recogen en el presente sitio Web, así como el código fuente, los diseños gráficos, las imágenes, las fotografías, el software y los textos, están protegidos por la
                legislación española sobre los derechos de propiedad intelectual e industrial a favor de PUNTA DEL VERDE y no se permite la reproducción y/o publicación, total o parcial, del sitio Web, ni su tratamiento informático,
                su distribución, su difusión, su modificación, su transformación ni demás derechos reconocidos legalmente a su titular, sin el permiso previo y por escrito del mismo. Todos los derechos derivados de la propiedad
                intelectual están expresamente reservados por PUNTA DEL VERDE. El Usuario, única y exclusivamente, puede utilizar el material que aparezca en este sitio web para su uso personal y privado, quedando prohibido su uso con
                fines comerciales o para incurrir en actividades ilícitas.
            </p>

            <p>En Sevilla a 1 de febrero de 2023.</p>

            <p>Última modificación: <?php echo $ultiMod['fechaHora'] ?></p>

            <label for="Acepto"></label>
            <input type="submit" value="Acepto" name="Acepto" id="a">
            <label for="Rechazo"></label>
            <input type="submit" value="Rechazo" name="Rechazo" id="r">

        </form>
        <?php

        // -- <<PHP>> --
        // Se borra las cookies si las rechazas.
        if (isset($_POST["Acepto"])) {
            header("Location:index1.php");
        } else if (isset($_POST["Rechazo"])) {
            setcookie("Aceptar", time() - 3600);
            header("Location:cookie.php");
        }
        ?>
    </div>


</body>

</html>