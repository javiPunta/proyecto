<?php
$conectar = conectar();

// FUNCIÓN GLOBAL PARA LA CONEXIÓN
function conectar()
{
    $host = "localhost";
    $dbname = "promo";
    $username = "root";
    $password = "";

    try {
        $db = new PDO(
            'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8',
            $username,
            $password,
            array(PDO::ATTR_PERSISTENT => true)
        );
        return $db;
    } catch (Exception $e) {
        echo "Error al conectar la base de datos: " . $e->getMessage();
        die();
    }
}


//BOTONES

//BOTÓN AÑADIR
// Hemos usado la función LAST_INSERT_ID() para obtener el ID del usuario que acabamos de insertar
// en la tabla "usuario". De esta manera, podemos vincular el correo del jugador con su ID de usuario 
// correspondiente en la tabla "correo".

function crear_jugador($nombre_user, $nombre, $correo, $pass)
{
    // Configuración de la conexión a la base de datos
    global $conectar;

    // Consulta a la base de datos para insertar el nuevo jugador
    $sql = "INSERT INTO usuario (nombre_user, nombre, pass) VALUES (:nombre_user, :nombre, :pass)";

    try {
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

        // Obtener el ID del usuario recién insertado
        $id_usuario = $conectar->lastInsertId();

        // Insertar el correo del jugador en la tabla "correo"
        $sql_correo = "INSERT INTO correo (email, nombre_user) VALUES (:email, :nombre_user)";
        $stmt_correo = $conectar->prepare($sql_correo);
        $stmt_correo->bindParam(':email', $correo);
        $stmt_correo->bindParam(':nombre_user', $nombre_user);
        $stmt_correo->execute();

        echo "Jugador creado exitosamente";
        session_start();
        $_SESSION['nombre_user'] = $nombre_user;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
          // Mostrar mensaje de confirmación y redirigir al usuario
          echo "<script>";
          echo "if(confirm('¿Desea ir a la página de juegos?')){";
          echo "window.location.href='../Juegos/juegos.php';";
          echo "} else {";
          echo "window.location.href='../index1.php';";
          echo "}";
          echo "</script>";
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}

// BOTÓN BORRAR
function borrar_jugador($nombre_user)
{
    // Configuración de la conexión a la base de datos
    global $conectar;

    try {
        // Iniciar una transacción para poder hacer rollback en caso de error
        $conectar->beginTransaction();

        // Borrar los datos del usuario en la tabla "correo"
        $sql = "DELETE FROM correo WHERE nombre_user = :nombre_user";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->execute();

        // Borrar el usuario de la tabla "usuario"
        $sql = "DELETE FROM usuario WHERE nombre_user = :nombre_user";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->execute();

        // Confirmar la transacción
        $conectar->commit();

        echo "Jugador borrado exitosamente";
          // Mostrar mensaje de confirmación y redirigir al usuario
          echo "<script>";
          echo "if(confirm('¿Desea iniciar sesion con otra cuenta?')){";
          echo "window.location.href='../forms/login.php';";
          echo "} else {";
          echo "window.location.href='../index1.php';";
          echo "}";
          echo "</script>";
    } catch (PDOException $e) {
        // Deshacer la transacción en caso de error
        $conectar->rollback();
        echo "Error en la consulta: " . $e->getMessage();
    }
}



// BOTÓN BUSCAR REPETIDOS 
function BuscarRepe($nombre_user)
{

    $conn = conectar();
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE nombre_user = :nombre_user");
    $stmt->bindParam(':nombre_user', $nombre_user);
    $stmt->execute();
    $repetido = $stmt->rowCount();
    $conn = null;
    return $repetido;
}
function modificarUser($nombre_user, $nombre, $correo, $pass)
 {
    // Configuración de la conexión a la base de datos
    global $conectar;

    // Consulta a la base de datos para actualizar el usuario
    $sql = "UPDATE usuario SET nombre = :nombre, pass = :pass WHERE nombre_user = :nombre_user";

    try {
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

        // Actualizar el correo del jugador en la tabla "correo"
        $sql_correo = "UPDATE correo SET email = :email WHERE nombre_user = :nombre_user";
        $stmt_correo = $conectar->prepare($sql_correo);
        $stmt_correo->bindParam(':email', $correo);
        $stmt_correo->bindParam(':nombre_user', $nombre_user);
        $stmt_correo->execute();

        echo "Usuario actualizado exitosamente";
        session_start();
        $_SESSION['nombre_user'] = $nombre_user;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
          // Mostrar mensaje de confirmación y redirigir al usuario
          echo "<script>";
          echo "if(confirm('¿Desea ir a la página de juegos?')){";
            echo "window.location.href='../Juegos/juegos.php';";
            echo "} else {";
            echo "window.location.href='../index1.php';";
          echo "}";
          echo "</script>";
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}





//VALIDACIONES

function validarNombre($nombre)
{
    $regla = "/^[A-Za-zÑñ]{1,60}$/";
    if (!preg_match($regla, $nombre)) {
        echo ("<h3>Nombre incorrecto.</h3>");
        return false;
    }
    return true;
}

function validarNombreUser($nombre_user)
{
    $regla = "/^[a-zA-Z0-9_]{3,50}$/";
    if (!preg_match($regla, $nombre_user)) {
        echo ("<h3>Nombre user incorrecto.</h3>");
        return false;
    }
    return true;
}

function validarContrasena($pass)
{
    $regla = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    if (!preg_match($regla, $pass)) {
        echo ("<h3>La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número.</h3>");
        return false;
    }
    return true;
}


// La función FILTER_VALIDATE_EMAIL toma una cadena de texto que se supone que es una dirección de 
// correo electrónico y devuelve true si la dirección es válida, y false en caso contrario.
function validarEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("<h3>Dirección de correo electrónico no válida.</h3>");
        return false;
    }
    return true;
}

function guardar_encuesta($nombre_user, $p1, $p2, $p3, $p4, $p5) {
    // Configuración de la conexión a la base de datos
    global $conectar;

    // Obtener la información del usuario actual
    $sql = "SELECT * FROM usuario WHERE nombre_user = :nombre_user";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':nombre_user', $nombre_user);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario ya realizó una encuesta hoy
    $fecha_hoy = date('Y-m-d');
    $sql = "SELECT * FROM usuario_tienda WHERE nombre_user = :nombre_user AND fecha = :fecha";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':nombre_user', $nombre_user);
    $stmt->bindParam(':fecha', $fecha_hoy);
    $stmt->execute();
    $encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($encuesta) {
        // El usuario ya realizó una encuesta hoy, no se puede realizar otra
        echo "Ya has realizado una encuesta hoy. Por favor, inténtalo de nuevo mañana.";
    } else {
        // El usuario no ha realizado una encuesta hoy, actualizar su puntaje y guardar la información de la encuesta
        $puntos = $usuario['puntos'] + 10;
        $sql = "UPDATE usuario_tienda SET puntos = :puntos WHERE nombre_user = :nombre_user";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':puntos', $puntos);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->execute();

        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO encuesta (nombre_user, p1, p2, p3, p4, p5, fecha, puntos) VALUES (:nombre_user, :p1, :p2, :p3, :p4, :p5, :fecha, :puntos)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->bindParam(':p1', $p1);
        $stmt->bindParam(':p2', $p2);
        $stmt->bindParam(':p3', $p3);
        $stmt->bindParam(':p4', $p4);
        $stmt->bindParam(':p5', $p5);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':puntos', $puntos);
        $stmt->execute();

        echo "Encuesta guardada exitosamente. Se han sumado 10 puntos a tu cuenta.";
    }
}
