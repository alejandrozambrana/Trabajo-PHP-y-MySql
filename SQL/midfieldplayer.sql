-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2016 a las 17:10:26
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `midfieldplayer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `codequi` int(11) NOT NULL,
  `nomequi` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`codequi`, `nomequi`) VALUES
(1, 'Málaga Club de Fútbol'),
(2, 'Fútbol Club Barcelona'),
(3, 'Real Madrid Club de Fútbol'),
(4, 'Club Atlético de Madrid'),
(5, 'Valencia Club de Fútbol'),
(6, 'Athletic Club'),
(7, 'Sevilla Fútbol Club'),
(8, 'Real Club Deportivo de La Coruña'),
(9, 'Real Club Deportivo Espanyol'),
(10, 'Real Sociedad de Fútbol'),
(11, 'Real Club Celta de Vigo'),
(12, 'Real Sporting de Gijón'),
(13, 'Real Betis Balompié'),
(14, 'Club Atlético Osasuna'),
(15, 'Deportivo Alavés'),
(16, 'Granada Club de Fútbol'),
(17, 'Unión Deportiva Las Palmas'),
(18, 'Villarreal Club de Fútbol'),
(19, 'Sociedad Deportiva Eibar'),
(20, 'Club Deportivo Leganés'),
(21, 'Dellafuente F.C.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `codjug` int(11) UNSIGNED NOT NULL,
  `nomjug` varchar(50) COLLATE utf8_bin NOT NULL,
  `equipojug` int(11) DEFAULT NULL,
  `dorsaljug` int(2) NOT NULL,
  `edadjug` int(11) NOT NULL,
  `alturajug` int(11) NOT NULL,
  `pesojug` int(11) NOT NULL,
  `codnac` int(11) DEFAULT NULL,
  `codpos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`codjug`, `nomjug`, `equipojug`, `dorsaljug`, `edadjug`, `alturajug`, `pesojug`, `codnac`, `codpos`) VALUES
(1, 'Kameni', 1, 1, 32, 186, 86, 2, 1),
(2, 'Boyko', 1, 13, 28, 197, 85, 3, 1),
(3, 'Aaron', 1, 27, 21, 188, 72, 1, 1),
(4, 'Koné', 1, 2, 28, 188, 80, 4, 3),
(5, 'D. Llorente', 1, 5, 23, 186, 75, 1, 3),
(6, 'Ricca', 1, 15, 22, 176, 71, 5, 2),
(7, 'M. Torres', 1, 23, 30, 184, 74, 1, 2),
(8, 'Mikel Villanueva', 1, 4, 23, 190, 78, 6, 3),
(9, 'Rosales', 1, 18, 27, 174, 73, 6, 4),
(10, 'Weligton', 1, 3, 37, 186, 71, 7, 3),
(11, 'Chory Castro', 1, 11, 32, 176, 70, 5, 5),
(12, 'Duda', 1, 17, 36, 174, 72, 8, 5),
(13, 'Camacho', 1, 6, 26, 182, 80, 1, 9),
(14, 'Javi Ontiveros', 1, 39, 19, 172, 68, 1, 11),
(15, 'Jony', 1, 21, 25, 180, 80, 1, 5),
(16, 'Juan Carlos', 1, 7, 26, 178, 69, 1, 2),
(17, 'Juanpi', 1, 10, 22, 171, 68, 6, 6),
(18, 'Pablo Fornals', 1, 31, 20, 178, 67, 1, 8),
(19, 'Recio', 1, 14, 25, 183, 74, 1, 8),
(20, 'Kuzmanovic', 1, 22, 29, 186, 83, 9, 9),
(21, 'Charles', 1, 9, 32, 179, 75, 7, 12),
(22, 'Keko Gotan', 1, 20, 24, 172, 68, 1, 7),
(23, 'Michael Santos', 1, 8, 23, 175, 62, 5, 12),
(24, 'Sandro', 1, 19, 21, 175, 68, 1, 12),
(25, 'En Nesyri', 1, 26, 19, 195, 75, 10, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `codnac` int(11) NOT NULL,
  `pais` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`codnac`, `pais`) VALUES
(1, 'España'),
(2, 'Camerún'),
(3, 'Ucrania'),
(4, 'Burkina Faso'),
(5, 'Uruguay'),
(6, 'Venezuela'),
(7, 'Brasil'),
(8, 'Portugal'),
(9, 'Serbia'),
(10, 'Marruecos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicion`
--

CREATE TABLE `posicion` (
  `codpos` int(11) NOT NULL,
  `posicion` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `posicion`
--

INSERT INTO `posicion` (`codpos`, `posicion`) VALUES
(1, 'Portero'),
(2, 'Lateral Izquierdo'),
(3, 'Central'),
(4, 'Lateral Derecho'),
(5, 'Interior izquierdo'),
(6, 'Mediapunta'),
(7, 'Interior derecho'),
(8, 'Mediocentro ofensivo'),
(9, 'Mediocentro defensivo'),
(10, 'Extremo Izquierdo'),
(11, 'Extremo Derecho'),
(12, 'Delantero centro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codusu` int(11) UNSIGNED NOT NULL,
  `nomusu` varchar(50) COLLATE utf8_bin NOT NULL,
  `contrausu` varchar(50) COLLATE utf8_bin NOT NULL,
  `correousu` varchar(50) COLLATE utf8_bin NOT NULL,
  `tipousu` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codusu`, `nomusu`, `contrausu`, `correousu`, `tipousu`) VALUES
(1, 'Administrador', '1234', 'administrador@gmail.com', 'administrador'),
(2, 'clientePrueba', '1234', 'cliente@hotmail.com', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`codequi`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`codjug`),
  ADD KEY `equipojug` (`equipojug`),
  ADD KEY `codnac` (`codnac`),
  ADD KEY `codpos` (`codpos`);

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`codnac`);

--
-- Indices de la tabla `posicion`
--
ALTER TABLE `posicion`
  ADD PRIMARY KEY (`codpos`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codusu`),
  ADD UNIQUE KEY `nomusu` (`nomusu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `codjug` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codusu` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `codnac` FOREIGN KEY (`codnac`) REFERENCES `nacionalidad` (`codnac`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `codpos` FOREIGN KEY (`codpos`) REFERENCES `posicion` (`codpos`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `equipojug` FOREIGN KEY (`equipojug`) REFERENCES `equipo` (`codequi`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
