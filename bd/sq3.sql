-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.27-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando datos para la tabla sistem_confg.company: ~1 rows (aproximadamente)
REPLACE INTO `company` (`id`, `nombre`, `direccion`, `telefono`, `email`, `url`, `nit`, `dg`, `iva`) VALUES
	(1, 'Nombre de la Empresa', 'mz 5 lote 1 br Santafe', '3023724861', 'roiman93l2opez@gmail.com', 'www.ejemplo.com', '123456789', 0, 19);

-- Volcando datos para la tabla sistem_confg.prefixes: ~1 rows (aproximadamente)
REPLACE INTO `prefixes` (`id`, `prefijo`, `n_inicio`, `n_final`, `n_actual`, `n_resolucion`, `fecha_resolucion`, `estado`, `tipo_documento`) VALUES
	(1, 'FAC', 1, 1500, 29, '1990', '2020-12-02', 2, 1);

-- Volcando datos para la tabla sistem_confg.us_type: ~2 rows (aproximadamente)
REPLACE INTO `us_type` (`usuario_tipo`, `tipo`) VALUES
	(1, 'admin'),
	(2, 'vendedor');

-- Volcando datos para la tabla sistem_confg.us_user: ~1 rows (aproximadamente)
REPLACE INTO `us_user` (`id`, `cedula`, `nombre`, `snombre`, `apellido`, `sapellido`, `email`, `telefono`, `admin`, `confirmado`, `token`, `password`) VALUES
	(3, 1067927688, ' Royman', 'David', 'Rodriguez', 'lopez', 'roiman93lopez@gmail.com', '3023724860', '1', '1', NULL, '$2y$10$m2pD8Cnqds6XvBMobaK6LujzpgBYb.LnG/fVURRwGcvNqjPBePmd2');

-- Volcando datos para la tabla ventas_ms.caja: ~0 rows (aproximadamente)

-- Volcando datos para la tabla ventas_ms.cliente: ~5 rows (aproximadamente)
REPLACE INTO `cliente` (`id`, `tipo_doc`, `documento`, `nombre`, `s_nombre`, `apellido`, `s_apellido`, `sexo`, `g_sanguineo`, `edad`, `est_civil`, `ocupacion`, `direccion`, `telefono`, `fecha`) VALUES
	(1, 'TI', '112341234', 'nombre', 'david', 'apellido', 'juarex', 'm', 'o+', '25', 'DV', 'mototaxi', 'santafe', '3127503702', '2023-04-15 00:02:55'),
	(2, 'CC', '112341234', 'nombre', 'david', 'apellido', 'juarex', 'm', 'o+', '25', 'SO', 'oasjdljflas', 'pradera', '3023724860', '2023-04-15 00:05:28'),
	(18, 'CC', '1137', 'valeria', 'sofia', 'rodriguez', 'lopez', 'f', 'A+', '19', 'SO', 'estudiante', 'altos de santafe', '3104302587', '2023-04-19 00:49:24'),
	(19, 'CC', '23495698263', 'validacion', 'validar', 'apelido', 'perez', 'm', 'O-', '13', 'SO', 'nada', 'nada', '3009003124', '2023-04-19 01:00:55'),
	(20, 'TI', '1234123', 'nombre', 'segundo', 'maza', 'perez', 'o', 'A+', '17', 'SP', 'joyero', 'santafe', '3002302545', '2023-04-19 01:06:10');

-- Volcando datos para la tabla ventas_ms.detalle_temp_factura_compra: ~0 rows (aproximadamente)

-- Volcando datos para la tabla ventas_ms.detalle_tmp_factura: ~2 rows (aproximadamente)
REPLACE INTO `detalle_tmp_factura` (`id`, `id_producto`, `cantidad`, `precio_venta`, `mesa`, `token_user`) VALUES
	(96, 12, 20, 700.00, 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3 '),
	(97, 12, 10, 700.00, 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3 ');

-- Volcando datos para la tabla ventas_ms.detall_fact_compra: ~0 rows (aproximadamente)

-- Volcando datos para la tabla ventas_ms.dt_fact: ~15 rows (aproximadamente)
REPLACE INTO `dt_fact` (`id`, `id_fact`, `id_producto`, `cantidad`, `precio_venta`, `estatus`) VALUES
	(1, 1, 12, 1, 700.00, 1),
	(2, 1, 12, 1, 700.00, 1),
	(3, 2, 12, 1, 700.00, 1),
	(4, 2, 12, 1, 700.00, 1),
	(5, 3, 12, 1, 700.00, 1),
	(6, 3, 12, 2, 700.00, 1),
	(7, 4, 12, 4, 700.00, 1),
	(8, 5, 12, 5, 700.00, 1),
	(9, 5, 12, 4, 700.00, 1),
	(10, 6, 12, 40, 700.00, 1),
	(11, 6, 12, 20, 700.00, 1),
	(12, 6, 12, 10, 700.00, 1),
	(13, 6, 12, 1, 700.00, 1),
	(14, 6, 12, 3, 700.00, 1),
	(15, 7, 12, 5, 700.00, 1);

-- Volcando datos para la tabla ventas_ms.fact: ~7 rows (aproximadamente)
REPLACE INTO `fact` (`id`, `prefijo`, `numero`, `id_cliente`, `usuario`, `total`, `estatus`, `fecha`) VALUES
	(1, '  FAC', '22', 1, 3, 1400.00, 1, '2023-04-07 20:38:45'),
	(2, '  FAC', '23', 1, 3, 1400.00, 1, '2023-04-07 20:43:44'),
	(3, '  FAC', '24', 1, 3, 2100.00, 1, '2023-04-10 02:57:44'),
	(4, '  FAC', '25', 1, 3, 2800.00, 1, '2023-04-10 03:01:06'),
	(5, '  FAC', '26', 1, 3, 6300.00, 1, '2023-04-10 04:43:13'),
	(6, '  FAC', '27', 1, 3, 51800.00, 1, '2023-04-11 02:22:35'),
	(7, '  FAC', '28', 1, 3, 3500.00, 1, '2023-04-13 22:46:49');

-- Volcando datos para la tabla ventas_ms.factura_compra: ~0 rows (aproximadamente)

-- Volcando datos para la tabla ventas_ms.mesatemp: ~0 rows (aproximadamente)

-- Volcando datos para la tabla ventas_ms.producto: ~1 rows (aproximadamente)
REPLACE INTO `producto` (`id_producto`, `nombre`, `codigo`, `tipo`, `precio_compra`, `precio_venta`, `fecha`) VALUES
	(12, 'agua', 1, '1', 200.00, 700.00, '2023-02-25 21:52:00');

-- Volcando datos para la tabla ventas_ms.provedor: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
