-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2023 a las 21:21:18
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistem_confg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `id` int(50) NOT NULL,
  `nombre` char(50) NOT NULL,
  `direccion` char(70) NOT NULL,
  `telefono` char(50) NOT NULL,
  `email` char(50) NOT NULL,
  `url` char(80) NOT NULL,
  `nit` char(50) NOT NULL,
  `dg` int(3) NOT NULL,
  `iva` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`id`, `nombre`, `direccion`, `telefono`, `email`, `url`, `nit`, `dg`, `iva`) VALUES
(1, 'Nombre de la Empresa', 'mz 5 lote 1 br Santafe', '3023724861', 'roiman93l2opez@gmail.com', 'www.ejemplo.com', '123456789', 0, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefixes`
--

CREATE TABLE `prefixes` (
  `id` int(11) NOT NULL,
  `prefijo` char(50) NOT NULL,
  `n_inicio` int(50) NOT NULL,
  `n_final` int(50) NOT NULL,
  `n_actual` int(50) NOT NULL,
  `n_resolucion` varchar(50) NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `estado` int(50) NOT NULL,
  `tipo_documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prefixes`
--

INSERT INTO `prefixes` (`id`, `prefijo`, `n_inicio`, `n_final`, `n_actual`, `n_resolucion`, `fecha_resolucion`, `estado`, `tipo_documento`) VALUES
(1, 'FAC', 1, 1500, 29, '1990', '2020-12-02', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `us_type`
--

CREATE TABLE `us_type` (
  `usuario_tipo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `us_type`
--

INSERT INTO `us_type` (`usuario_tipo`, `tipo`) VALUES
(1, 'admin'),
(2, 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `us_user`
--

CREATE TABLE `us_user` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` char(50) DEFAULT NULL,
  `snombre` char(50) NOT NULL,
  `apellido` char(50) DEFAULT NULL,
  `sapellido` char(50) NOT NULL,
  `email` char(80) DEFAULT NULL,
  `telefono` char(20) DEFAULT NULL,
  `admin` char(20) DEFAULT NULL,
  `confirmado` char(20) DEFAULT NULL,
  `token` char(100) DEFAULT NULL,
  `password` char(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `us_user`
--

INSERT INTO `us_user` (`id`, `cedula`, `nombre`, `snombre`, `apellido`, `sapellido`, `email`, `telefono`, `admin`, `confirmado`, `token`, `password`) VALUES
(3, 1067927688, ' Royman', 'David', 'Rodriguez', 'lopez', 'roiman93lopez@gmail.com', '3023724860', '1', '1', NULL, '$2y$10$m2pD8Cnqds6XvBMobaK6LujzpgBYb.LnG/fVURRwGcvNqjPBePmd2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nit` (`nit`);

--
-- Indices de la tabla `prefixes`
--
ALTER TABLE `prefixes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `us_type`
--
ALTER TABLE `us_type`
  ADD PRIMARY KEY (`usuario_tipo`);

--
-- Indices de la tabla `us_user`
--
ALTER TABLE `us_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prefixes`
--
ALTER TABLE `prefixes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `us_user`
--
ALTER TABLE `us_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
