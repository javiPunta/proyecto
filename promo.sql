-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2023 a las 17:39:49
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `promo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correo`
--

CREATE TABLE `correo` (
  `email` varchar(60) NOT NULL,
  `nombre_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `correo`
--

INSERT INTO `correo` (`email`, `nombre_user`) VALUES
('borradoe@gmail.com', 'borrado23'),
('borrar57@gmail.com', 'borrar57'),
('borrar@gmail.com', 'borrar577'),
('javi27@gmail.com', 'javi27'),
('ruben267@gmail.com', 'ruben27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `nombre_user` varchar(50) NOT NULL,
  `p1` int(11) NOT NULL,
  `p2` int(11) NOT NULL,
  `p3` int(11) NOT NULL,
  `p4` int(11) NOT NULL,
  `p5` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `id` int(3) NOT NULL,
  `nombre_juego` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `id` int(4) NOT NULL,
  `nombre_tienda` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre_user` varchar(50) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `pass` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre_user`, `nombre`, `pass`) VALUES
('borrado23', 'laaaaoe', 'Km5cDp7z'),
('borrar57', 'borrar', 'Km5cDp7z'),
('borrar577', 'laaaa', 'Km5cDp7t'),
('javi27', 'javi', 'Km5cDp7z'),
('ruben27', 'ruben', 'Km5cDp7z');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_juego`
--

CREATE TABLE `usuario_juego` (
  `nombre_user` varchar(50) NOT NULL,
  `id` int(3) NOT NULL,
  `puntos` int(7) NOT NULL,
  `fecha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tienda`
--

CREATE TABLE `usuario_tienda` (
  `nombre_user` varchar(50) NOT NULL,
  `id` int(3) NOT NULL,
  `encuestas` varchar(80) NOT NULL,
  `puntos` int(7) NOT NULL,
  `fecha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `correo`
--
ALTER TABLE `correo`
  ADD PRIMARY KEY (`email`),
  ADD KEY `nombre_user` (`nombre_user`);

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nombre_user`);

--
-- Indices de la tabla `usuario_juego`
--
ALTER TABLE `usuario_juego`
  ADD PRIMARY KEY (`nombre_user`,`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `usuario_tienda`
--
ALTER TABLE `usuario_tienda`
  ADD PRIMARY KEY (`nombre_user`,`id`),
  ADD KEY `id` (`id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `correo`
--
ALTER TABLE `correo`
  ADD CONSTRAINT `correo_ibfk_1` FOREIGN KEY (`nombre_user`) REFERENCES `usuario` (`nombre_user`);

--
-- Filtros para la tabla `usuario_juego`
--
ALTER TABLE `usuario_juego`
  ADD CONSTRAINT `usuario_juego_ibfk_1` FOREIGN KEY (`nombre_user`) REFERENCES `usuario` (`nombre_user`),
  ADD CONSTRAINT `usuario_juego_ibfk_2` FOREIGN KEY (`id`) REFERENCES `juego` (`id`);

--
-- Filtros para la tabla `usuario_tienda`
--
ALTER TABLE `usuario_tienda`
  ADD CONSTRAINT `usuario_tienda_ibfk_1` FOREIGN KEY (`nombre_user`) REFERENCES `usuario` (`nombre_user`),
  ADD CONSTRAINT `usuario_tienda_ibfk_2` FOREIGN KEY (`id`) REFERENCES `juego` (`id`),
  ADD CONSTRAINT `usuario_tienda_ibfk_3` FOREIGN KEY (`nombre_user`) REFERENCES `usuario` (`nombre_user`),
  ADD CONSTRAINT `usuario_tienda_ibfk_4` FOREIGN KEY (`id`) REFERENCES `tienda` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
