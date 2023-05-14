<!-- QUIERO QUE EL USUARIO ESTYE ARRIBA A LA IZQUIERDA Y EL RECORDS SCORE ARRIBA A LA DERECHA  Y QUE ANOTE EL MEJOR RECORD -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dino.css">
    <title>Dinosaurio Chrome</title>
</head>

<body>
<div class="user">

<?php

session_start();
if(isset($_SESSION['nombre_user'])){
  echo "Bienvenido " . $_SESSION['nombre_user'];
} else{
  header('Location: ../../forms/login.php');
  exit;
}

?>
</div>
<br>
<div id="score">records Score: 0</div>
    <div class="contenedor">

        <div class="suelo"></div>

        <div class="dino dino-corriendo"></div>

        <div class="score">0</div>

    </div>
    <button id="restart-button">Reiniciar</button>
    <form action="dino.php" method="post">
    <div id="botones-container">
    <button id="gafico-button" name="grafico">Ir a los gráficos</button>
    <button id="atras-button" name="atras">Volver atras</button>
</div>


    </form>
    <div class="game-over">GAME OVER</div>


  
<?php
if (isset($_POST["atras"])) {
    header('Location: ../juegos.php');
 }
 if (isset($_POST["grafico"])) {
    header('Location: ../../ranking/grafico.html');
 }
 if (isset($_POST["cerrarsesion"])) {
    header('Location: ../../forms/logout.php');
 }
?>
    <script>

        //****** GAME LOOP (BUCLE DEL JUEGO) ********//

        // ******  Inicializa 2 variables: el tiempo y el delta de tiempo (La sincronización delta 
        // puede sobresalir en cualquier momento en que la velocidad de fotogramas de un 
        // juego deba ser independiente de su hardware.), y luego espera a que el documento
        // esté listo antes de llamar a la función "Init" para iniciar el juego.

        // La función "Init" establece algunas variables adicionales y llama a la función 
        // "Start" para iniciar el juego. 

        // La función "Loop" se llama repetidamente mediante requestAnimationFrame para
        // actualizar el juego y renderizar los gráficos. ********//

        var time = new Date();
        var deltaTime = 0;

        if (document.readyState === "complete" || document.readyState === "interactive") {
            setTimeout(Init, 1);
        } else {
            document.addEventListener("DOMContentLoaded", Init);
        }

        // Esta función inicializa el juego. En ella se asigna el valor inicial de la variable time
        // como la hora actual, se llama a la función Start(), que carga los elementos HTML necesarios
        // y se llama a la función Loop() para iniciar el ciclo de juego.

        function Init() {
            time = new Date();
            Start();
            Loop();
        }

        // Esta función actualiza el estado del juego y de renderizarlo en cada fotograma.
        // En cada iteración, calcula el tiempo que ha pasado desde el último fotograma, actualiza la
        // posición de los elementos del juego, llama a la función Update() y, finalmente, solicita
        // el siguiente fotograma de la animación mediante la función requestAnimationFrame().

        function Loop() {
            deltaTime = (new Date() - time) / 1000;
            time = new Date();
            Update();
            requestAnimationFrame(Loop);
        }

        //****** GAME LOGIC (LÓGICA DEL JUEGO) ********//

        // ****** Aquí se definen varias variables para el dinosaurio.

        // La función "Start" establece algunas variables adicionales y agrega un listener para
        // detectar cuándo se presiona la tecla espacio.

        // La función "Update" se llama en cada fotograma y actualiza la posición del dinosaurio, 
        // el suelo, los obstáculos y las nubes.

        // La función "HandleKeyDown" se llama cuando se presiona la tecla espacio y hace que el
        // dinosaurio salte.

        // Otras funciones, como "MoverDinosaurio", "MoverSuelo","DecidirCrearObstaculos", etc.,
        // realizan tareas específicas para mover los objetos y determinar cuándo se deben crear 
        // nuevos obstáculos o nubes. ********//

        var sueloY = 22;
        var velY = 0;
        var impulso = 900;
        var gravedad = 2500;

        var dinoPosX = 42;
        var dinoPosY = sueloY;

        var sueloX = 0;
        var velEscenario = 1280 / 3;
        var gameVel = 1;
        var score = 0;

        var parado = false;
        var saltando = false;

        // Estas variables sirven para crear obstaculos cada cierto tiempo.
        var tiempoHastaObstaculo = 2;
        var tiempoObstaculoMin = 0.7;
        var tiempoObstaculoMax = 1.8;
        var obstaculoPosY = 16;
        var obstaculos = [];

        var tiempoHastaNube = 0.5;
        var tiempoNubeMin = 0.7;
        var tiempoNubeMax = 2.7;
        var maxNubeY = 270;
        var minNubeY = 100;
        var nubes = [];
        var velNube = 0.5;

        var contenedor;
        var dino;
        var textoScore;
        var suelo;
        var gameOver;

        // Esta función busca los elementos HTML que se utilizarán en el juego, como el suelo,
        // el dinosaurio, el contenedor y el texto del score. Además, agrega un listener para detectar
        // cuando se presiona el espacio y llama a la función HandleKeyDown() para comenzar el ciclo de juego.

        function Start() {
            gameOver = document.querySelector(".game-over");
            suelo = document.querySelector(".suelo");
            contenedor = document.querySelector(".contenedor");
            textoScore = document.querySelector(".score");
            dino = document.querySelector(".dino");
            document.addEventListener("keydown", HandleKeyDown);
        }

        // Esta función actualiza el estado del juego y de renderizarlo en cada fotograma.
        // En cada iteración, se calcula el tiempo que ha pasado desde el último fotograma,
        // se actualiza la posición de los elementos del juego, se llama a la función Update() y,
        // finalmente, se solicita el siguiente fotograma de la animación mediante la función
        // equestAnimationFrame().

        function Update() {
            if (parado) return;

            MoverDinosaurio();
            MoverSuelo();
            DecidirCrearObstaculos();
            DecidirCrearNubes();
            MoverObstaculos();
            MoverNubes();
            DetectarColision();

            velY -= gravedad * deltaTime;
        }

        // Esta función maneja el evento de tecla presionada.
        // Si la tecla presionada es la tecla espacio(comprobamos si se ha precionado 
        // la tecla 32 que es el espacio), llama a la función Saltar().

        function HandleKeyDown(ev) {
            if (ev.keyCode == 32) {
                Saltar();
            }
        }

        // Esta función hace que el dinosaurio salte. Si el dinosaurio está en el suelo,
        // se establece la variable saltando en true, se asigna un impulso inicial en el eje Y a la
        // variable velY y se elimina la clase CSS dino-corriendo del elemento HTML del dinosaurio
        // para que se muestre la animación de salto.

        // Resumen: Si la anterior funcion funciona, comprobamos si esta en el suelo, si lo esta,
        // aumentamos su velocidad en el eje Y y añadimos una clase para que la animacion
        // del dinosaurio cambie

        function Saltar() {
            if (dinoPosY === sueloY) {
                saltando = true;
                velY = impulso;
                dino.classList.remove("dino-corriendo");
            }
        }

        // Esta función actualizar la posición del dinosaurio en cada fotograma. 
        // (movemos el dinosaurio en cuestión de la velocidad para que el dinosario no suba eternamente ni salga de la panatlla)
        // Primero, actualiza la posición en función de la velocidad en el eje Y y el tiempo transcurrido.
        // Cada fotograma tendremos que reducir la velocidad un poco para que caiga de nuevo al suelo.
        // Si el dinosaurio ha caído por debajo del suelo, llama a la función TocarSuelo(). 
        // Finalmente, actualiza la posición del elemento HTML del dinosaurio.

        function MoverDinosaurio() {
            dinoPosY += velY * deltaTime;
            if (dinoPosY < sueloY) {

                TocarSuelo();
            }
            dino.style.bottom = dinoPosY + "px";
        }

        // Esta función resetea el estado del dinosaurio cuando toca el suelo.
        // (si ha tocado suelo, ponemos la animacion de correr y reseteamos la velocidad)
        // Establece la posición Y del dinosaurio en la posición del suelo, establece la velocidad
        // Y en 0 y, si el dinosaurio estaba saltando, añade la clase CSS dino-corriendo al elemento
        // HTML del dinosaurio para que se muestre la animación de correr.

        function TocarSuelo() {
            dinoPosY = sueloY;
            velY = 0;
            if (saltando) {
                dino.classList.add("dino-corriendo");
            }
            saltando = false;
        }

        // Esta función mueve el suelo en cada fotograma.
        // (actualiza la posicion del suelo con la cantidad correspondiente al tiempo que ha pasado
        // del fotogramaa anterior al actual)
        // Primero, calcula la cantidad de desplazamiento en función de la velocidad del suelo y el tiempo
        // transcurrido. 
        // Dado que nuestro suelo mide dos veces el escenario, usando el modulo del ancho del escenario
        // nos aseguramos que cada vez que la mitad del suelo haya salido del escenario, su posición.
        // vuelva al principio para dar la sensacion de que es infinito
        // Luego, actualiza la posición del elemento HTML del suelo en función del desplazamiento y del 
        // ancho del contenedor. Si el suelo ha salido del contenedor, lo reposiciona al principio.

        function MoverSuelo() {
            sueloX += CalcularDesplazamiento();
            suelo.style.left = -(sueloX % contenedor.clientWidth) + "px";
        }

        // Esta función calcula la cantidad de desplazamiento que debe tener el suelo
        // en cada fotograma en función de la velocidad del suelo y el tiempo transcurrido.

        function CalcularDesplazamiento() {
            return velEscenario * deltaTime * gameVel;
        }

        // Esta función hace cambiar la imagen del dinosario y muera al chocar contra un obstáculo.
        // Elimina la clase CSS dino-corriendo del elemento HTML del dinosaurio y añade la clase CSS
        // dino-estrellado. Establece la variable parado en true para detener el juego.

        function Estrellarse() {
            dino.classList.remove("dino-corriendo");
            dino.classList.add("dino-estrellado");
            parado = true;
        }

        // Esta función hace que si ha pasado tiempo suficiente cree un obstaculo
        // En caso del contador del tiempo restante haya llegado a 0 creamos un obstaculo.

        function DecidirCrearObstaculos() {
            tiempoHastaObstaculo -= deltaTime;
            if (tiempoHastaObstaculo <= 0) {
                CrearObstaculo();
            }
        }

        function DecidirCrearNubes() {
            tiempoHastaNube -= deltaTime;
            if (tiempoHastaNube <= 0) {
                CrearNube();
            }
        }

        // para que pinnte un cactus y llo añada a un contenedor
        // y a una lista de cuantos cactus hay activo
        function CrearObstaculo() {
            var obstaculo = document.createElement("div");
            contenedor.appendChild(obstaculo);
            obstaculo.classList.add("cactus");
            if (Math.random() > 0.5) obstaculo.classList.add("cactus2");
            obstaculo.posX = contenedor.clientWidth;
            obstaculo.style.left = contenedor.clientWidth + "px";

            obstaculos.push(obstaculo);
            tiempoHastaObstaculo = tiempoObstaculoMin + Math.random() * (tiempoObstaculoMax - tiempoObstaculoMin) / gameVel;
        }

        function CrearNube() {
            var nube = document.createElement("div");
            contenedor.appendChild(nube);
            nube.classList.add("nube");
            nube.posX = contenedor.clientWidth;
            nube.style.left = contenedor.clientWidth + "px";
            nube.style.bottom = minNubeY + Math.random() * (maxNubeY - minNubeY) + "px";

            nubes.push(nube);
            tiempoHastaNube = tiempoNubeMin + Math.random() * (tiempoNubeMax - tiempoNubeMin) / gameVel;
        }

        // hay que hacer un bucle for para mover los obstaculoy comprobar si el obstaculo se ha salido
        //  de la pantalla por el lado izzquierdo para quitarlo de la pantalla y de la lista a la 
        // vez que el juego increenta en 1 los puntos

        function MoverObstaculos() {
            for (var i = obstaculos.length - 1; i >= 0; i--) {
                if (obstaculos[i].posX < -obstaculos[i].clientWidth) {
                    obstaculos[i].parentNode.removeChild(obstaculos[i]);
                    obstaculos.splice(i, 1);
                    GanarPuntos();
                } else {
                    obstaculos[i].posX -= CalcularDesplazamiento();
                    obstaculos[i].style.left = obstaculos[i].posX + "px";
                }
            }
        }

        function MoverNubes() {
            for (var i = nubes.length - 1; i >= 0; i--) {
                if (nubes[i].posX < -nubes[i].clientWidth) {
                    nubes[i].parentNode.removeChild(nubes[i]);
                    nubes.splice(i, 1);
                } else {
                    nubes[i].posX -= CalcularDesplazamiento() * velNube;
                    nubes[i].style.left = nubes[i].posX + "px";
                }
            }
        }

        function GanarPuntos() {
            score++;
            textoScore.innerText = score;
            if (score == 5) {
                gameVel = 1.5;
                contenedor.classList.add("mediodia");
            } else if (score == 10) {
                gameVel = 2;
                contenedor.classList.add("tarde");
            } else if (score == 20) {
                gameVel = 3;
                contenedor.classList.add("noche");
            }
            suelo.style.animationDuration = (3 / gameVel) + "s";
            if (score === 50) {
                    const confirmacion = confirm("¡Felicidades, has ganado! ¿Quieres volver a jugar? Si le das a No se cerrará la sesión");
                    if (confirmacion) {
                        resetGame();
                    } else {
                        window.location.href = '../../forms/logout.php';
                    }
                }
        }

        // Esta función qmuestra un mensaje de fin de juego y detiene la ejecución del juego.
        // Esta función se llama cuando se detecta una colisión entre el dinosaurio y un obstáculo,
        // y se encarga de ocultar el suelo, el dinosaurio y los obstáculos, mostrar un mensaje 
        // de fin de juego y detener el loop del juego.

        function GameOver() {
            Estrellarse();
            gameOver.style.display = "block";
        }

        // comprueba si hay una colision entre los dos rectangulos aplicandole al primero paddin interno 
        // para compensar un poco los huecos del sprite del dinosaurio
        function DetectarColision() {
            for (var i = 0; i < obstaculos.length; i++) {
                if (obstaculos[i].posX > dinoPosX + dino.clientWidth) {
                    //EVADE
                    break; //al estar en orden, no puede chocar con más
                } else {
                    if (IsCollision(dino, obstaculos[i], 10, 30, 15, 20)) {
                        GameOver();
                    }
                }
            }
        }

        function IsCollision(a, b, paddingTop, paddingRight, paddingBottom, paddingLeft) {
            var aRect = a.getBoundingClientRect();
            var bRect = b.getBoundingClientRect();

            return !(
                ((aRect.top + aRect.height - paddingBottom) < (bRect.top)) ||
                (aRect.top + paddingTop > (bRect.top + bRect.height)) ||
                ((aRect.left + aRect.width - paddingRight) < bRect.left) ||
                (aRect.left + paddingLeft > (bRect.left + bRect.width))
            );
        }






        const restartButton = document.getElementById("restart-button");
        restartButton.addEventListener("click", function () {
            resetGame();
        });
        function resetGame() {
            location.reload();
        }


    </script>
</body>

</html>