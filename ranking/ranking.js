// La función cargarRanking() ordena el ranking por puntuación de mayor a menor y
// agrega filas a la tabla con los datos de cada jugador. Al cargar la página, se llama
// a esta función para cargar el ranking inicial. Puedes modificar los datos del ranking
//  en el arreglo ranking y personalizar los estilos CSS según tus necesidades.

// Datos del ranking
var ranking = [
    { posicion: 1, nombre: "Juan", puntuacion: 100 },
    { posicion: 2, nombre: "María", puntuacion: 90 },
    { posicion: 3, nombre: "Pedro", puntuacion: 80 },
    { posicion: 4, nombre: "Ana", puntuacion: 60 },
    { posicion: 5, nombre: "Luis", puntuacion: 70 },
];

// Función para cargar el ranking en la tabla
function cargarRanking() {
    var tablaCuerpo = document.getElementById("tabla-cuerpo");
    tablaCuerpo.innerHTML = ""; // Limpiar la tabla antes de cargar los datos

    // Ordenar el ranking por puntuación (de mayor a menor)
    ranking.sort(function (a, b) {
        return b.puntuacion - a.puntuacion;
    });

    // Recorrer los datos del ranking y agregarlos a la tabla
    ranking.forEach(function (jugador) {
        var fila = document.createElement("tr");
        fila.innerHTML =
            "<td>" +
            jugador.posicion +
            "</td>" +
            "<td>" +
            jugador.nombre +
            "</td>" +
            "<td>" +
            jugador.puntuacion +
            "</td>";
        tablaCuerpo.appendChild(fila);
    });
}

// Llamamos a la función para cargar el ranking al cargar la página
window.onload = cargarRanking;
