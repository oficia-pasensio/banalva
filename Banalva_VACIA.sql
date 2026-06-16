-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2026 a las 09:01:31
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banalva`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranes`
--

CREATE TABLE `albaranes` (
  `Numero_albaran` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `Enlace` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `CIF` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `buzon`
--

CREATE TABLE `buzon` (
  `Nombre_Buzon` varchar(200) NOT NULL,
  `Enlace` varchar(250) NOT NULL,
  `CIF` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `CIF` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Contrasena` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mail` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Contacto` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ruta_albaranes` varchar(150) CHARACTER SET latin1 NOT NULL,
  `Ruta_facturas` varchar(150) CHARACTER SET latin1 NOT NULL,
  `Ruta_buzon` varchar(150) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`CIF`, `Nombre`, `Usuario`, `Contrasena`, `Telefono`, `mail`, `Contacto`, `Ruta_albaranes`, `Ruta_facturas`, `Ruta_buzon`) VALUES
('11111111', 'Banalva S.L', 'banalva', 'b90b198beb0782c2300fd8ecdfa352f2342495638176327798', '968671208', 'administracion@oficiasistemas.es', 'Silverio Banegas', 'Empresa/banalva/albaran', 'Empresa/banalva/factura', ''),
--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `Numero_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `Enlace` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `CIF` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indices de la tabla `albaranes`
--
ALTER TABLE `albaranes`
  ADD KEY `CIF` (`CIF`);

--
-- Indices de la tabla `buzon`
--
ALTER TABLE `buzon`
  ADD KEY `CIF` (`CIF`),
  ADD KEY `Nombre_Buzon` (`Nombre_Buzon`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`CIF`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD KEY `CIF` (`CIF`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albaranes`
--
ALTER TABLE `albaranes`
  ADD CONSTRAINT `albaranes_ibfk_1` FOREIGN KEY (`CIF`) REFERENCES `empresa` (`CIF`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `buzon`
--
ALTER TABLE `buzon`
  ADD CONSTRAINT `CASCADE` FOREIGN KEY (`CIF`) REFERENCES `empresa` (`CIF`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`CIF`) REFERENCES `empresa` (`CIF`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
