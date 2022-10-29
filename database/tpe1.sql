-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2022 a las 02:27:20
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpe1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `singers`
--

CREATE TABLE `singers` (
  `singer` varchar(45) NOT NULL,
  `nationality` varchar(45) NOT NULL,
  `img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `singers`
--

INSERT INTO `singers` (`singer`, `nationality`, `img`) VALUES
('Bad Bunny', 'Puerto Rico', 'img/singers/6348a255231a5.jpg'),
('Duki', 'Argentina', 'img/singers/6348a275f3ca7.jpg'),
('Karol G', 'Colombia', NULL),
('Paulo Londra', 'Argentina', 'img/singers/6348acca08bb7.jpg'),
('Trueno', 'Argentina', 'img/singers/6348abbda2da2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `genere` varchar(45) NOT NULL,
  `album` varchar(45) NOT NULL,
  `singer` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `songs`
--

INSERT INTO `songs` (`id`, `title`, `genere`, `album`, `singer`) VALUES
(38, 'Moscow mule', 'Urbano Latino', 'Un verano sin ti', 'Bad Bunny'),
(39, 'Malbec', 'Urbano Latino', 'Desde el fin del mundo', 'Duki'),
(40, 'Tal vez', 'Urbano Latino', 'Homerun', 'Paulo Londra'),
(41, 'Dance crip', 'Urbano Latino', 'Bien o mal', 'Trueno'),
(42, 'Creeme', 'Urbano Latino', 'Ocean', 'Karol G');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$ppI/UZngwjtblj6UZFxDzO/cMxf2ts75NOiJ6yRxnCbFd1kuJLrCO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `singers`
--
ALTER TABLE `singers`
  ADD PRIMARY KEY (`singer`);

--
-- Indices de la tabla `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `singer` (`singer`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`singer`) REFERENCES `singers` (`singer`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
