-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.27-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sistem_confg
CREATE DATABASE IF NOT EXISTS `sistem_confg` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `sistem_confg`;

-- Volcando estructura para tabla sistem_confg.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` char(50) DEFAULT NULL,
  `apellido` char(50) DEFAULT NULL,
  `email` char(80) DEFAULT NULL,
  `telefono` char(20) DEFAULT NULL,
  `admin` char(20) DEFAULT NULL,
  `confirmado` char(20) DEFAULT NULL,
  `token` char(100) DEFAULT NULL,
  `password` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sistem_confg.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `admin`, `confirmado`, `token`, `password`) VALUES
	(1, ' Royman David', 'Rodriguez Lopez', 'roiman93lopez@gmail.com', '3023724860', '1', '1', '', '$2y$10$xgDXnNUTHl4JestvB5YJIeIYkMxLQ1.Sr8/aiWfUL1/FK.p0pmYTi');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
