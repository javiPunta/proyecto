<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="memorama.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


    <title>Memorama</title>
</head>

<body>
    <div class="user">

        <?php

session_start();
if (isset($_SESSION['nombre_user'])) {
    echo "Bienvenido " . $_SESSION['nombre_user'] . "<br>";
    echo "<a href='../../forms/form.php'>Ir al formulario</a>";
} else {
    header('Location:../../forms/login.php');
    exit;
}



        ?>
    </div>
    <div id="nivel">Nivel: 1</div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />

    <!--Aqui se almacena todas las tarjetas. -->
    <div id="tablero"></div>

    <br />
    <br />
    <div class="contenedor">
        <div onclick="nuevaPartida()" class="nuevo-juego">Nuevo Juego</div>

        <div class="finalizar-partida" onclick="finalizarPartida()">
            Finalizar Partida
        </div>
       
        <form action="memorama.php" method="post">
    <button id="gafico-button" name="grafico">Ir a los gráficos</button>
    <button id="atras-button" name="atras">Volver atras</button>
    <button id="session-button" name="cerrarsesion">Cerrar sesión</button>
    </form>
    </div>


    <br />
    <br />
    <br />
    <br />

    <div id="partidas-ganadas">Partidas Ganadas: 0</div>
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
        let iconos = [];
        let selecciones = [];
        let nivel = 1;
        let partidasGanadas = 0;
        let cartasVolteadas = 0;
        let numTarjetas = 0;
        let contadorAcertadas = 0;

        // Cuando se ejecute el codigo tenga el tablero ya cargado.
        generarTablero();

        function cargarIconos() {
            iconos = [
                '<i class="fas fa-band-aid"></i>',
                '<i class="fas fa-cat"></i>',
                '<i class="fas fa-dragon"></i>',
                '<i class="far fa-clock"></i>',
                '<i class="fas fa-chess-knight"></i>',
                '<i class="fa fa-cloud"></i>',
                '<i class="fa fa-heart"></i>',
                '<i class="fa fa-car"></i>',
                '<i class="fa fa-file"></i>',
                '<i class="fa fa-bars"></i>',
                '<i class="fas fa-biohazard"></i>',
                '<i class="fas fa-basketball-ball"></i>',
            ];
        }

        function generarTablero() {
            cargarIconos();
            selecciones = [];
            let tablero = document.getElementById("tablero");
            let tarjetas = [];
            numTarjetas = 4;

            switch (nivel) {
                case 1:
                    numTarjetas = 4;
                    break;
                case 2:
                    numTarjetas = 8;
                    break;
                case 3:
                    numTarjetas = 12;
                    break;
                    // case 4:
                    // <a href="ranking.html" />
                    // break;
            }
            for (let i = 0; i < numTarjetas * 2; i++) {
                // class="area-tarjeta": Area de la tarjeta cuando esta totalmente quieta.
                // class="tarjeta": Otro para la representación de la tarjeta.
                // class="cara superior": Otro para la cara superior(?).
                // class="cara trasera": Otro para la cara trasera(imagen).
                // push: Texto representaivo para cada una de las tarjetas.
                // Cuando se haga click a nuevo juego ejecuta nuevo tablero.
                // Empieza con el icono posicion 0.
                tarjetas.push(`
                
                <div class="area-tarjeta" onclick="seleccionarTarjeta(${i})">
                    <div class="tarjeta" id="tarjeta${i}">
                        <div class="cara trasera" id="trasera${i}">
                            ${iconos[0]}
                        </div>
                        <div class="cara superior">
                            <i class="fas fa-question"></i>
                        </div>
                    </div>
                </div>        
                `);
                // Si el contador no es multiplo de 2, eliminamos el primer elemento de iconos.
                // iconos.splice(0, 1): 0 posicion, 1 elemento que se va a eleminar en esa posicion.
                // Esto se hace para que haya dos iconos repetidos.
                if (i % 2 == 1) {
                    iconos.splice(0, 1);
                }
            }
            // Para que se desorden las tarjetas de forma aleatorio.

            tarjetas.sort(() => Math.random() - 0.5);

            tablero.innerHTML = tarjetas.join(" ");
        }
        function seleccionarTarjeta(i) {
            // Seleciona la tarjeta con el indice.

            let tarjeta = document.getElementById("tarjeta" + i);
            let acertada = true;
            let contadorAcertadas;
            // Si su rotacion es diferente, lo vamos a rotar 180 grados

            if (tarjeta.style.transform != "rotateY(180deg)") {
                tarjeta.style.transform = "rotateY(180deg)";
                // Variable que sirve de memoria para saber las cartas que hemos guardado.

                selecciones.push(i);
                cartasVolteadas++;
            }
            if (cartasVolteadas === numTarjetas * 2) {
                document.getElementsByClassName("finalizar-partida")[0].disabled = false;
            }
            // Si la cantidad es igual a 2, deseleccionamos las selecciones y sleccione le añadimos a un elemento vacio.

            if (selecciones.length == 2) {
                deseleccionar(selecciones);
                selecciones = [];
            }
            if (acertada) {
                contadorAcertadas++; // Incrementar el contador de cartas acertadas

                if (contadorAcertadas == 4 || contadorAcertadas == 8) {
                    // Si se acertaron las 4 cartas o las 8 cartas
                    nivel++; // Aumentar el nivel

                    // ... Código para actualizar la interfaz con el nuevo nivel ...

                    contadorAcertadas = 0; // Reiniciar el contador de cartas acertadas
                }
            }

        }

        function deseleccionar(selecciones) {
            // Va a tener efecto sino esta un 1 s despues de las cartas

            setTimeout(() => {
                let trasera1 = document.getElementById("trasera" + selecciones[0]);
                let trasera2 = document.getElementById("trasera" + selecciones[1]);

                if (trasera1.innerHTML != trasera2.innerHTML) {
                    // Le pasamos la tarjeta y el numero de la seleccion.

                    let tarjeta1 = document.getElementById("tarjeta" + selecciones[0]);
                    let tarjeta2 = document.getElementById("tarjeta" + selecciones[1]);
                    // Si son diferente, no coinciden entonce se rota a 0 grados.

                    tarjeta1.style.transform = "rotateY(0deg)";
                    tarjeta2.style.transform = "rotateY(0deg)";

                } else {
                    // Le cambiamos de color para cuando la respuesta sea correcta

                    trasera1.style.background = "#33FCFF";
                    trasera2.style.background = "#33FCFF";

                }
            }, 1000);
        }

        function finalizarPartida() {
            // Comprobar si todas las cartas están volteadas y cambian de color
            let todasVolteadas = true;
            let tarjetas = document.getElementsByClassName("tarjeta");
            for (let i = 0; i < tarjetas.length; i++) {
                if (tarjetas[i].style.transform != "rotateY(180deg)") {
                    todasVolteadas = false;
                    break;
                }
            }

            if (todasVolteadas) {
                partidasGanadas++; // Incrementar el contador de partidas ganadas
                document.getElementById("partidas-ganadas").textContent = "Partidas Ganadas: " + partidasGanadas; // Actualizar el contador en el HTML
                nivel++;
                localStorage.setItem("ganadas", partidasGanadas);
                localStorage.setItem("nivel", nivel);
                document.getElementById("nivel").textContent = "Nivel: " + nivel; // Actualizar el nivel en el HTML

                // Preguntar si el usuario quiere volver a jugar o cerrar la sesión
                if (nivel === 4) {
                    const confirmacion = confirm("¡Felicidades, has ganado el nivel 3! ¿Quieres volver a jugar? Si le das a No se cerrará la sesión");
                    if (confirmacion) {
                        nivel = 1; // reiniciar el nivel a 1
                        localStorage.setItem("nivel", nivel);
                        document.getElementById("nivel").textContent = "Nivel: " + nivel; // Actualizar el nivel en el HTML
                        generarTablero();
                    } else {
                        window.location.href = '../../cerrarSesionRanking.php';
                    }
                } else {
                    generarTablero();
                }
            }
        }


        const restartButton = document.getElementById("nuevo-juego");
        restartButton.addEventListener("click", function() {
            resetGame();
        });

        function resetGame() {
            location.reload();
        }

        function nuevaPartida() {
            nivel = 1; // Reiniciar el nivel a 1
            document.getElementById("nivel").innerHTML = "Nivel: 1";
            generarTablero(); // Generar un nuevo tablero de juego
        }
    </script>
</body>

</html>