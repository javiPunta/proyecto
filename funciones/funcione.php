<?php
$conectar = conectar();

// -- <<FUNCIÓN GLOBAL PARA LA CONEXIÓN>> --
// Devuelve un objeto PDO que representa una conexión a una base de datos MySQL.

// La función utiliza el constructor PDO para crear una nueva instancia de la clase PDO con
// los parámetros especificados, y devuelve la instancia resultante. La opción PDO::ATTR_PERSISTENT
// se establece en true, lo que indica que se utilizará una conexión persistente para la base de datos.

// Si se produce un error durante la conexión, se captura una excepción y se muestra un mensaje de error
// en pantalla terminando la ejecución mediante la función die().
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


//FUNCIONES PARA BOTONES

//FUNCIÓN: BOTÓN AÑADIR
// Primero configura la conexión a la base de datos global, y luego ejecuta una consulta SQL para insertar
// los detalles del nuevo jugador en la tabla "usuario" de la base de datos. Luego, obtiene el ID 
// del usuario recién insertado y lo utiliza para insertar su correo electrónico en la tabla "correo".

// Después de eso, la función crea una sesión para el nuevo jugador y almacena sus detalles de nombre 
// de usuario, nombre y correo electrónico en las variables de sesión correspondientes. Por último,
// muestra un mensaje de confirmación y redirige al jugador a la página de juegos, o al índice principal
// del sitio web si el jugador no desea ir a la página de juegos.

// Si ocurre algún error durante la ejecución de la consulta SQL, se captura la excepción de la clase 
// PDOException y se muestra un mensaje de error correspondiente.

// BORRAR COSAS DEL CODIGO QUE NO NECESITO
function crear_jugador($nombre_user, $nombre, $correo, $pass)
{
    global $conectar;

    $sql = "INSERT INTO usuario (nombre_user, nombre, pass) VALUES (:nombre_user, :nombre, :pass)";

    try {
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

        // Obtener el ID del usuario recién insertado con LAST_INSERT_ID()
        $id_usuario = $conectar->lastInsertId();

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

// FUNCION: BOTÓN BORRAR
//Primero configura la conexión a la base de datos global. Luego, se inicia una transacción para 
// poder hacer (rollback) en caso de que ocurra un error durante la eliminación.
// -rollback: Se refiere al proceso de deshacer una o varias transacciones en una base de datos. 
// Se utiliza cuando surgen errores o problemas que afectan la integridad de los datos.
// Permite deshacer la transacción y restaurar los datos a un estado anterior  a la transacción,
// garantizando así la integridad de los datos en la base de datos y evitando errores
// o corrupciones de los mismos.

// Ahora borra los datos del jugador de la tabla "correo" y luego borra al jugador de la tabla "usuario" 
// utilizando consultas SQL preparadas y parámetros con nombre.
// Si borran los datos del jugaor, la transacción se confirma y muestra un mensaje de confirmación.
// Además, se redirige al usuario a la página de inicio de sesión para iniciar sesión con otra cuenta.

// En caso de que ocurra un error durante el proceso de eliminación, se deshace la transacción y
// se muestra un mensaje de error en la pantalla.
function borrar_jugador($nombre_user)
{
    global $conectar;

    try {
        $conectar->beginTransaction();

        $sql = "DELETE FROM correo WHERE nombre_user = :nombre_user";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->execute();

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


//FUNCIÓN: BOTÓN MODIFICAR
// Primero configura la conexión a la base de datos global, luego, ejecuta una consulta SQL para actualizar
// el nombre y la contraseña del usuario en la tabla "usuario", utilizando el método bindParam()
// para enlazar los valores de los parámetros a la consulta, se hace lo mismo con la tabla "correo"

// Si ambas consultas se ejecutan sin errores, se muestra un mensaje de éxito y se establece una sesión
// para el usuario con los nuevos valores. Finalmente, se muestra un mensaje de confirmación al usuario
// y se redirige a la página de juegos o a la página principal dependiendo de su elección.

// Si se produce algún error en las consultas, se muestra un mensaje de error.
function modificarUser($nombre_user, $nombre, $correo, $pass)
{
    global $conectar;

    $sql = "UPDATE usuario SET nombre = :nombre, pass = :pass WHERE nombre_user = :nombre_user";

    try {
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nombre_user', $nombre_user);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

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

// FUNCION: BUSCAR REPETIDOS
// Primero configura la conexión a la base de datos global, luego, prepara una consulta SQL para
// seleccionar todas las filas de la tabla "usuario" que tengan el valor de nombre_user igual al 
// valor del parámetro $nombre_user.

// Enlaza el valor del parámetro a la consulta utilizando el método bindParam().
// Después, ejecuta la consulta utilizando el método execute().

// Finalmente, se cierra la conexión a la base de datos y se retorna el número de filas que se 
// encontraron en la consulta. Este número indica si el nombre de usuario $nombre_user existe en
// la tabla "usuario"  o no.
function BuscarRepe($nombre_user)
{

    $conn = conectar();
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE nombre_user = :nombre_user");
    $stmt->bindParam(':nombre_user', $nombre_user);
    $stmt->execute();
    // Obtiene el número de filas que devuelve la consulta ejecutada.
    $repetido = $stmt->rowCount();
    $conn = null;
    return $repetido;
}

//VALIDACIONES
// Aquí lo que se hace es poner una serie de parametros al codigo para que cuando lo cumpla en el formulario
// pueda registrarse o modificar o lo que sea y si no lo cumple no te deja avanzar en el codigo

//VALIDAR: NOMBRE
// Se compone de los siguientes elementos:

// ^ indica el inicio de la cadena.

// [A-Za-zÑñ] conjunto de caracteres que se pueden incluir en la cadena. 
// En este caso, se especifica que solo se permiten letras mayúsculas y minúsculas del alfabeto inglés,
//  así como las letras Ñ y ñ.
// {1,60} indica que la cadena debe tener una longitud de entre 1 y 60 caracteres.

// $ indica el final de la cadena.
function validarNombre($nombre)
{
    $regla = "/^[A-Za-zÑñ]{1,60}$/";
    if (!preg_match($regla, $nombre)) {
        echo ("<h3>Nombre incorrecto.</h3>");
        return false;
    }
    return true;
}

//VALIDAR: NOMBRE USUARIO
// Se compone de los siguientes elementos:

// ^ indica el inicio de la cadena.

// [a-zA-Z0-9_] Especifica que la cadena solo debe contener caracteres alfanuméricos y guiones bajos.
// {3,50} - esto especifica que la cadena debe tener una longitud de al menos 3 caracteres y no más de 50 caracteres.

// $ indica el final de la cadena.
function validarNombreUser($nombre_user)
{
    $regla = "/^[a-zA-Z0-9_]{3,50}$/";
    if (!preg_match($regla, $nombre_user)) {
        echo ("<h3>Nombre user incorrecto.</h3>");
        return false;
    }
    return true;
}


//VALIDAR: CONTRASEÑA
// Se compone de los siguientes elementos:

// ^ indica el inicio de la cadena.

// [A-Za-zÑñ] conjunto de caracteres que se pueden incluir en la cadena.
// En este caso, se especifica que solo se permiten letras mayúsculas y minúsculas del alfabeto inglés,
// así como las letras Ñ y ñ.
// {8,} indica que la cadena debe tener una longitud de al menos 8 caracteres.
// (?=.*[a-z]) indica que la cadena debe contener al menos una letra minúscula.
// (?=.*[A-Z]) indica que la cadena debe contener al menos una letra mayúscula.
// (?=.*\d) indica que la cadena debe contener al menos un dígito.

// $ indica el final de la cadena.
function validarContrasena($pass)
{
    $regla = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    if (!preg_match($regla, $pass)) {
        echo ("<h3>La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número.</h3>");
        return false;
    }
    return true;
}

//VALIDAR: CORREO ELECTRÓNICO
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

// ESTA FUNCION NO ESTA IMPLEMENTADA POR ESO ESTA A PARTE
function guardar_encuesta($nombre_user, $p1, $p2, $p3, $p4, $p5)
{
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
