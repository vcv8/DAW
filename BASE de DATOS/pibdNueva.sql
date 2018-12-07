-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2018 a las 14:03:42
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pibd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albumes`
--

CREATE TABLE IF NOT EXISTS `albumes` (
`IdAlbumes` int(11) NOT NULL,
  `Titulo` text NOT NULL,
  `Descripción` text NOT NULL,
  `Usuario` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `albumes`
--

INSERT INTO `albumes` (`IdAlbumes`, `Titulo`, `Descripción`, `Usuario`) VALUES
(1, 'Paisajes', 'Fotos con paisajes de todo el mundo', 1),
(2, 'Mascotas', 'Fotoso de animalicos', 3),
(3, 'Viaje a Malaysia', 'Fotos que hicimos en nuestro viaje a Malaysia', 4),
(4, 'Random', 'Lo que me apetezca subir', 2),
(5, 'Otro mas', 'Este album no me gusta', 1),
(19, 'Chuleria', 'Los mas chulos', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilos`
--

CREATE TABLE IF NOT EXISTS `estilos` (
`IdEstilo` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Descripcion` text NOT NULL,
  `Fichero` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `estilos`
--

INSERT INTO `estilos` (`IdEstilo`, `Nombre`, `Descripcion`, `Fichero`) VALUES
(1, 'Normal', 'Estilo de pagina normal sin añadidos', 'normal'),
(2, 'Modo Noche', 'Versión oscura del estilo principal de la página.', 'noche'),
(3, 'Modo Accesibilidad', 'Modificación del etilo de la página con mejoras de accesibilidad en cuanto a diseño como estructura.', 'accesibilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE IF NOT EXISTS `fotos` (
`IdFoto` int(11) NOT NULL,
  `Titulo` text NOT NULL,
  `Descripcion` text NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Pais` int(11) DEFAULT NULL,
  `Album` int(11) NOT NULL,
  `Fichero` text NOT NULL,
  `FRegistro` datetime NOT NULL,
  `Alternativo` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`IdFoto`, `Titulo`, `Descripcion`, `Fecha`, `Pais`, `Album`, `Fichero`, `FRegistro`, `Alternativo`) VALUES
(1, 'Amanecer', 'Amanecer en Alicante', '2018-09-29', 1, 1, 'recursos/paisaje.png', '2018-11-20 17:35:00', 'Amanecer'),
(2, 'Bisisuá', 'Mi gato bisisuá en la terraza.', '2018-10-10', NULL, 2, 'recursos/gat2.jpg', '2018-11-11 01:02:03', 'Bisisua'),
(3, 'Dibujaco', 'Este dibujo que me hice el otro día, que os parece peña?', NULL, 1, 4, 'recursos/artemania.jpg', '2018-11-01 10:20:30', 'Dibujaco'),
(4, 'Grupal', 'Aquí salimos todos los que estuvimos en el viaje.', '2018-06-24', 3, 3, 'recursos/grupal.png', '2018-11-04 00:00:00', 'Grupal'),
(5, 'De expedición', 'A las puertas de comenzar una magnífica expedición.', '2018-07-18', 3, 3, 'recursos/gujero.jpg', '2018-11-18 00:00:00', 'De expedición'),
(6, 'Cuadro', 'Un cuadro azul.', NULL, NULL, 4, 'recursos/fondo.jpg', '2018-11-23 12:19:08', 'Cuadrofoto'),
(7, 'En la ciudad', 'Aqui en la ciudad.', NULL, 2, 3, 'recursos/cyberpunk.jpg', '2018-11-04 06:21:18', 'ciberfoto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
`IdPais` int(11) NOT NULL,
  `NomPais` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`IdPais`, `NomPais`) VALUES
(1, 'España'),
(2, 'Francia'),
(3, 'Italia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE IF NOT EXISTS `solicitudes` (
`IdSolicitud` int(11) NOT NULL,
  `Album` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Titulo` varchar(200) NOT NULL,
  `Descripcion` varchar(4000) DEFAULT NULL,
  `Email` varchar(200) NOT NULL,
  `Calle` varchar(200) NOT NULL,
  `Numero` int(2) NOT NULL,
  `CodPostal` int(5) NOT NULL,
  `Localidad` text NOT NULL,
  `Pais` text NOT NULL,
  `Provincia` text NOT NULL,
  `Color` text NOT NULL,
  `Copias` int(11) NOT NULL,
  `Resolucion` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `IColor` tinyint(1) NOT NULL,
  `FRegistro` datetime NOT NULL,
  `Coste` decimal(10,0) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`IdSolicitud`, `Album`, `Nombre`, `Titulo`, `Descripcion`, `Email`, `Calle`, `Numero`, `CodPostal`, `Localidad`, `Pais`, `Provincia`, `Color`, `Copias`, `Resolucion`, `Fecha`, `IColor`, `FRegistro`, `Coste`) VALUES
(3, 1, 'Knekro Puto Amo', 'Con los colegas', 'Ay va la ostia patxi que no lo he enxufao', 'roxo85@hotmail.com', 'calle torrejos', 24, 3124, 'SanVicentdelRaspeig', 'España', 'Alicante', '#ff8040', 6, 900, '2018-12-29', 1, '2018-12-06 21:47:04', '6'),
(8, 19, 'knekro puto amo', 'Grupal', 'Ay va la ostia patxi que no lo he enxufao', 'roxo85@hotmail.com', 'lacalledeknekro', 0, 3124, 'SanVicentdelRaspeig', 'España', 'Alicante', '#000000', 4, 450, '2018-12-27', 1, '2018-12-07 13:59:23', '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`IdUsuario` int(11) NOT NULL,
  `NomUsuario` varchar(15) NOT NULL,
  `Clave` varchar(15) NOT NULL,
  `Email` text NOT NULL,
  `Sexo` tinyint(4) NOT NULL,
  `FNacimiento` date NOT NULL,
  `Ciudad` text,
  `Pais` int(11) DEFAULT NULL,
  `Foto` text NOT NULL,
  `FRegistro` datetime NOT NULL,
  `Estilo` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `NomUsuario`, `Clave`, `Email`, `Sexo`, `FNacimiento`, `Ciudad`, `Pais`, `Foto`, `FRegistro`, `Estilo`) VALUES
(1, 'knekro100', 'holasoyknekro', 'knekro100@hotmail.com', 0, '1985-08-22', 'Madrid', 1, 'knekro100', '2018-11-20 17:23:00', 1),
(2, 'manolo100', 'holasoymanolo', 'manolo100@hotmail.com', 0, '1990-04-14', 'Albacete', 1, 'recursos/EjemploPerfil.png', '2018-11-01 00:00:00', 1),
(3, 'cristian100', 'holasoycristian', 'cristian100@hotmail.com', 1, '1997-11-24', 'Cádiz', 1, 'recursos/EjemploPerfil.png', '2018-11-11 02:30:15', 2),
(4, 'pedro100', 'holasoypedro', 'pedro100@hotmail.com', 0, '1986-01-02', 'París', 2, 'recursos/EjemploPerfil.png', '2018-11-16 13:12:11', 3),
(5, 'tonto100', 'holasoytonto', 'tonto100@gmail.com', 1, '1996-04-04', 'Alicante', 1, 'recursos/EjemploUsuario.png', '2018-11-22 15:23:24', 1),
(13, 'roca95', 'qwerty234_L', 'roca95@hotmail.com', 0, '2018-12-31', '', 3, 'fotoPerfil.png', '2018-12-07 13:51:41', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albumes`
--
ALTER TABLE `albumes`
 ADD PRIMARY KEY (`IdAlbumes`), ADD KEY `Usuario` (`Usuario`);

--
-- Indices de la tabla `estilos`
--
ALTER TABLE `estilos`
 ADD PRIMARY KEY (`IdEstilo`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
 ADD PRIMARY KEY (`IdFoto`), ADD KEY `Pais` (`Pais`), ADD KEY `Album` (`Album`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
 ADD PRIMARY KEY (`IdPais`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
 ADD PRIMARY KEY (`IdSolicitud`), ADD KEY `Album` (`Album`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`IdUsuario`), ADD UNIQUE KEY `NomUsuario` (`NomUsuario`), ADD KEY `Estilo` (`Estilo`), ADD KEY `Pais` (`Pais`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albumes`
--
ALTER TABLE `albumes`
MODIFY `IdAlbumes` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `estilos`
--
ALTER TABLE `estilos`
MODIFY `IdEstilo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
MODIFY `IdFoto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
MODIFY `IdPais` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
MODIFY `IdSolicitud` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albumes`
--
ALTER TABLE `albumes`
ADD CONSTRAINT `albumes_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`Pais`) REFERENCES `paises` (`IdPais`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fotos_ibfk_2` FOREIGN KEY (`Album`) REFERENCES `albumes` (`IdAlbumes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`Album`) REFERENCES `albumes` (`IdAlbumes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Pais`) REFERENCES `paises` (`IdPais`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`Estilo`) REFERENCES `estilos` (`IdEstilo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
