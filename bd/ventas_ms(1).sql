-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2023 a las 21:22:01
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
-- Base de datos: `ventas_ms`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))   BEGIN
      
      DECLARE precio_actual decimal(10,2);
      DECLARE CodigoPr int;
      
      SELECT pr.precio_venta INTO precio_actual FROM producto pr WHERE pr.id_producto = codigo;
      SELECT pr.codigo  INTO CodigoPr FROM producto pr WHERE pr.id_producto = codigo;
      
      INSERT INTO detalle_temp(token_user,codproducto, 	id_prod ,cantidad,precio_venta)               VALUES(token_user,CodigoPr,codigo,cantidad,precio_actual);
      
      SELECT tmp.correlativo, tmp.codproducto,tmp.id_prod, p.nombre, tmp.cantidad, tmp.precio_venta  FROM detalle_temp tmp
      INNER JOIN producto p
      ON tmp.codproducto = p.codigo
      WHERE tmp.token_user = token_user;
      
      END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_facturas` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))   BEGIN
      
      DECLARE precio_actual decimal(10,2);
      SELECT pr.precio_compra INTO precio_actual FROM     producto pr WHERE pr.id_producto = codigo;
      
      INSERT INTO detalle_temp_facturas(token_user,codproducto,cantidad,precio_compra) VALUES(token_user,codigo,cantidad,precio_actual);
      
     SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = p.id_producto
     WHERE token_user = token_user; 
      
      END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_mesa` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50), IN `mesa` INT)   BEGIN
      
      DECLARE precio_actual decimal(10,2);
      DECLARE CodigoPr VARCHAR(50);
      SELECT pr.precio_venta INTO precio_actual FROM producto pr WHERE pr.id_producto = codigo;
      
      SELECT pr.codigo INTO CodigoPr FROM producto pr WHERE pr.id_producto = codigo;
      
      
      INSERT INTO detalle_temp(token_user,mesa,codproducto,id_prod,cantidad,precio_venta) VALUES(token_user,mesa,CodigoPr,codigo,cantidad,precio_actual);
      
      SELECT tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta,tmp.mesa  FROM detalle_temp tmp
      INNER JOIN producto p
      ON tmp.codproducto = p.codigo
      WHERE tmp.token_user = token_user AND tmp.mesa = mesa;
      
      END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura` (IN `no_factura` INT)   BEGIN
    -- declaracion de variables 
        DECLARE existe_factura int;
       
    -- consultamos si existe la factura 
        SET existe_factura = (SELECT COUNT(*) FROM factura WHERE nofactura = no_factura and estatus = 1);
    -- validamos con condicional    
        IF existe_factura > 0 THEN
  
   
    --  actualizamso el estado de la factuta 
              UPDATE factura SET estatus = 2 WHERE nofactura = no_factura;
              update detallefactura SET estatus = 2 WHERE nofactura = no_factura;
  
    -- consultamos la factura           
              SELECT * FROM factura WHERE nofactura = no_factura;

        --    END IF;

           ELSE
           SELECT 0 factura;
           END if;

    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (IN `id_detalle` INT, IN `token` VARCHAR(50))   BEGIN 
    DELETE FROM detalle_temp  WHERE correlativo = id_detalle;
    
    SELECT tmp.id_prod, tmp.correlativo,tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp 
    INNER JOIN producto p
    ON tmp.codproducto = p.codigo
    WHERE tmp.token_user = token;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_facturas` (`id_detalle` INT, `token` VARCHAR(50))   BEGIN 
    DELETE FROM detalle_temp_facturas  WHERE correlativo = id_detalle;
    
    SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = p.codigo 
     WHERE token_user = token_user; 
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_mesa` (IN `id_detalle` INT, IN `token` VARCHAR(50), IN `mesa` INT)   BEGIN 
    DELETE FROM detalle_temp  WHERE correlativo = id_detalle AND mesa = mesa;
    
    SELECT tmp.mesa,tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta, p.nombre FROM detalle_temp tmp 
    INNER JOIN producto p
    ON tmp.codproducto = p.codigo
    WHERE tmp.token_user = token;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_compra` (IN `documento` VARCHAR(50), IN `cod_usuario` INT, IN `cod_provedor` INT, IN `token` VARCHAR(50))   BEGIN
  DECLARE factura INT;
  DECLARE registros INT;
  DECLARE total decimal(10,2);
  
 
  -- se crea una tabla temporal para almacenar codigo , cantidad del producto
  CREATE TEMPORARY TABLE tbl_tmp_fac_tokenuser (
       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       cod_prod BIGINT,
       cant_prod int);
  -- se consulta la tabla temporal para contar el numero de registros
  SET registros = (SELECT COUNT(*) FROM detalle_temp_facturas  WHERE token_user = token);
 
  if registros > 0 THEN
  -- se insertan los registros de la tabla detalle_temp a la tabla tbl_tmp_tokenuser 
      INSERT INTO tbl_tmp_fac_tokenuser(cod_prod,cant_prod) SELECT  codproducto,cantidad FROM detalle_temp_facturas  WHERE token_user = token;
      
  -- se insertan los registro a la tabla factura_compra y se extrae el id   
      INSERT INTO factura_compra(numero,usuario,codprovedor) VALUES(documento,cod_usuario,cod_provedor);
      SET factura = LAST_INSERT_ID();
       
  -- se inserta los detalles factura de la tabla tbl_tmp_tokenuser a la tabla detall_fcat_compra  y en la variable factura se guardan los registros   
      INSERT INTO detall_fact_compra(nofactura,codproducto,cantidad,precio_compra) SELECT (factura) as nofactura, codproducto, cantidad, precio_compra FROM detalle_temp_facturas WHERE token_user = token;

    -- se realizan el calculo del total 
      SET total = (SELECT SUM(cantidad * precio_compra) FROM detalle_temp_facturas WHERE token_user = token);

    -- se inserta el total a la tabla factura   
      UPDATE factura_compra SET totalfactura = total WHERE nofactura = factura;

    -- se elimina los registros en la tabla detalle temporal  
      DELETE FROM detalle_temp_facturas WHERE token_user = token;

    -- se vacia la tabla temporal  
      TRUNCATE TABLE tbl_tmp_fac_tokenuser;

    -- se consulta la tabla factura  
      SELECT * FROM factura_compra WHERE nofactura = factura;  
      
   ELSE
   SELECT 'No se encontro Productos para facturar' as error;
  END IF;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))   BEGIN
  DECLARE factura INT;
  DECLARE registros INT;
  DECLARE total decimal(10,2);
  

  DECLARE Prefijo VARCHAR(50);
  DECLARE numero_factura_actual varchar(50);
  DECLARE nuevo_numero varchar(50);
  
  DECLARE tmp_cod_producto int;
  DECLARE tmp_cant_producto int;
  DECLARE a int;
  SET a = 1;
  -- se crea una tabla temporal para almacenar codigo , cantidad del producto
  CREATE TEMPORARY TABLE tbl_tmp_tokenuser (
       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       cod_prod BIGINT,
       cant_prod int);
  -- se consulta la tabla temporal para contar el numero de registros
  SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
 
  if registros > 0 THEN
  -- se insertan los registros de la tabla detalle_temp a la tabla tbl_tmp_tokenuser 
      INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT  id_prod,cantidad FROM detalle_temp WHERE token_user = token;

    -- se consulta si el prefijo esta activo
    set prefijo =( SELECT p.prefijo FROM prefijos p WHERE p.estado = 1 AND p.tipo_documento = '1');

    -- se consulta si el numero factura actual esta activo
    set numero_factura_actual =( SELECT p.n_actual FROM prefijos p WHERE p.estado = 1 AND p.tipo_documento = '1');

  -- se insertan los registro a la tabla factura y se extrae el id   
      INSERT INTO factura(usuario,codcliente,prefijo,numero) VALUES(cod_usuario,cod_cliente,Prefijo,numero_factura_actual);
      SET factura = LAST_INSERT_ID();
       
  -- se inserta los detalles factura de la tabla tbl_tmp_tokenuser a la tabla detallefactura  y en la variable factura se guardan los registros   
      INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) SELECT (factura) as nofactura, id_prod, cantidad, precio_venta FROM detalle_temp WHERE token_user = token;
      



    -- se realizan el calculo del total 
      SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
    -- se inserta el total a la tabla factura   
      UPDATE factura SET totalfactura = total WHERE nofactura = factura;


    -- se actualiza el numero actual de la  factura
      set nuevo_numero = numero_factura_actual + 1;
      UPDATE prefijos SET n_actual = nuevo_numero WHERE estado = '1' AND tipo_documento = '1';

 
    -- se elimina los registros en la tabla detalle temporal  
      DELETE FROM detalle_temp WHERE token_user = token;
    -- se vacia la tabla temporal  
      TRUNCATE TABLE tbl_tmp_tokenuser;
    -- se consulta la tabla factura  
      SELECT * FROM factura WHERE nofactura = factura;  
      
   ELSE
   SELECT 0;
  END IF;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Activar_Resolucion` (IN `Id_Resolucion` INT)   BEGIN 
     -- declaracion de variables
    declare tipo int;
    declare numero int;

    -- se consulta el tipo de docuemento con el id
     Set tipo =(select tipo_documento  from prefijos  where  id = Id_Resolucion);

    -- validamos si existen resolucion activa del mismo tipo de documento
    set numero =( select COUNT(*) as dato from prefijos  where tipo_documento = tipo AND estado = 1);

     IF numero > 0 THEN

        select "No se puede activar mas de una Resolucion para un mismo Tipo de Documento " as Error;

     ELSE
        
       update prefijos  set estado ='1' where id = Id_Resolucion; 
       
     SELECT * FROM prefijos LIMIT 0,0;
       
       
        

     END IF;
    
  
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Agregar_Nuevo_Ciente` (IN `cedula` VARCHAR(20), IN `nombre` VARCHAR(50), IN `nombre_2` VARCHAR(50), IN `apellido_1` VARCHAR(50), IN `apellido_2` VARCHAR(50))   BEGIN

 SET @DX = (select COUNT(*) from cliente where cliente.cedula = cedula );

  IF ( @DX > 0 ) THEN
     
   SELECT "La cedula se encuentra Registrada";

  ELSE

     INSERT INTO cliente(cedula,nombre_1,nombre_2,apellido_1,apellido_2) 
			      VALUES(cedula,nombre,nombre_2,apellido_1,apellido_2); 
     SELECT * FROM cliente where cliente.cedula='';              
                 

  END IF;



 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Anular_Factura_Compra` (`no_factura` INT)   BEGIN
    -- declaracion de variables 
        DECLARE existe_factura int;

     -- consultamos si existe la factura 
         SET existe_factura = (SELECT COUNT(*) FROM factura_compra WHERE nofactura = no_factura and estatus = 1);
     -- validamos con condicional    
     IF existe_factura > 0 THEN

     --  actualizamso el estado de la factuta compra
         UPDATE factura_compra SET estatus = 2 WHERE nofactura = no_factura;
     --  actualizamso el estado de la factuta compra
         UPDATE detall_fact_compra SET estatus = 2 WHERE nofactura = no_factura;

   
    -- consultamos la factura compra          
              SELECT * FROM factura_compra WHERE nofactura = no_factura;

           
    ELSE

        SELECT 0 factura;

    END if;

    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Desactivar_Resolucion` (IN `Id_Resolucion` INT)   BEGIN 
     -- declaracion de variables
    declare tipo int;
    declare numero int;

    -- se consulta el tipo de docuemento con el id
     Set tipo =(select tipo_documento  from prefijos  where  id = Id_Resolucion);

    -- validamos si existen resolucion activa del mismo tipo de documento
    set numero =( select COUNT(*) as dato from prefijos  where tipo_documento = tipo AND estado = 1);

     IF numero > 0 THEN
   
       update prefijos  set estado ='2' where id = Id_Resolucion; 
       SELECT * FROM prefijos LIMIT 0,0;

     ELSE
        
        select "No se puede Desactivar " as Error;
              

     END IF;
    
  
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Eliminar_Producto` (IN `Id` INT)   BEGIN 
     -- declaracion de variables
   
    declare numero int;

    set numero =(select count(*) from detallefactura  where codproducto= id );

      IF numero > 0 then
  
               SELECT "No se puede Eliminar el producto, tiene movimientos" AS Error;
        
        
        ELSE
         delete  from producto where id_producto = Id;
         SELECT * FROM producto LIMIT 0,0;
  

     END IF;
    
  
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Eliminar_Resolucion` (IN `Id_Resolucion` INT)   BEGIN 
     -- declaracion de variables
   
    declare numero int;

  

    -- validamos si existen resolucion activa del mismo tipo de documento
    set numero =( select COUNT(*) as dato from prefijos  where  estado = 1 and id =Id_Resolucion);

     IF numero > 0 THEN
   
      select "Desactive la Resolucion antes de Eliminar " as Error;
              

     ELSE
         delete  from prefijos where id = Id_Resolucion;
         SELECT * FROM prefijos LIMIT 0,0;
        
        

     END IF;
    
  
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Procesar_Mesa` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `Nmesa` INT)   BEGIN
  DECLARE factura INT;
  DECLARE registros INT;
  DECLARE total decimal(10,2);
  

  DECLARE Prefijo VARCHAR(50);
  DECLARE numero_factura_actual varchar(50);
  DECLARE nuevo_numero varchar(50);

  DECLARE tmp_cod_producto int;
  DECLARE tmp_cant_producto int;
  DECLARE a int;
  SET a = 1;

 -- se crea una tabla temporal para almacenar codigo , cantidad del producto
  CREATE TEMPORARY TABLE tbl_tmp_tokenuser (
       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       cod_prod BIGINT,
       cant_prod int);
  -- se consulta la tabla temporal para contar el numero de registros
  SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token and mesa = Nmesa);
 
  if registros > 0 THEN
  -- se insertan los registros de la tabla detalle_temp a la tabla tbl_tmp_tokenuser 
      INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT  id_prod,cantidad FROM detalle_temp WHERE token_user = token and mesa = Nmesa;
      
    -- se consulta si el prefijo esta activo
    set prefijo =( SELECT p.prefijo FROM prefijos p WHERE p.estado = 1 AND p.tipo_documento = '1');

    -- se consulta si el numero factura actual esta activo
    set numero_factura_actual =( SELECT p.n_actual FROM prefijos p WHERE p.estado = 1 AND p.tipo_documento = '1');

  -- se insertan los registro a la tabla factura y se extrae el id   
      INSERT INTO factura(usuario,codcliente,prefijo,numero) VALUES(cod_usuario,cod_cliente,Prefijo,numero_factura_actual);
      SET factura = LAST_INSERT_ID();
       
 -- se inserta los detalles factura de la tabla tbl_tmp_tokenuser a la tabla detallefactura  y en la variable factura se guardan los registros   
      INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) SELECT (factura) as nofactura, id_prod, cantidad, precio_venta
      FROM detalle_temp WHERE token_user = token and mesa = Nmesa;
      
    -- WHILE a <= registros DO
    -- -- se llenan las variables temporales con el codigo y catidad de producto
    --    SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id=a;
    -- -- se inserta a la varible existencia actual la existencia del producto
    --    SELECT existencia INTO existencia_actual FROM producto WHERE codigo = tmp_cod_producto;
    -- -- se hace el calculo de la existencia    
    --    SET nueva_existencia = existencia_actual - tmp_cant_producto;
    -- -- se actualiza la existencia en la tabla producto   
    --    UPDATE producto SET existencia = nueva_existencia WHERE codigo = tmp_cod_producto;
       
    --    set a=a+1;
    -- END WHILE;


 
    -- se realizan el calculo del total 
      SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
    -- se inserta el total a la tabla factura   
      UPDATE factura SET totalfactura = total WHERE nofactura = factura;


    -- se actualiza el numero actual de la  factura
      set nuevo_numero = numero_factura_actual + 1;
      UPDATE prefijos SET n_actual = nuevo_numero WHERE estado = '1' AND tipo_documento = '1';

 
    -- se elimina los registros en la tabla detalle temporal  
      DELETE FROM detalle_temp WHERE token_user = token and mesa = Nmesa;
    -- se vacia la tabla temporal  
      TRUNCATE TABLE tbl_tmp_tokenuser;
    -- se consulta la tabla factura  
      SELECT * FROM factura WHERE nofactura = factura;  
      
   ELSE
   SELECT 0;
  END IF;
 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_caja` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(50) NOT NULL,
  `tipo_doc` char(5) NOT NULL DEFAULT '',
  `documento` char(20) NOT NULL DEFAULT '',
  `nombre` varchar(50) NOT NULL,
  `s_nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `s_apellido` varchar(50) NOT NULL,
  `sexo` char(5) NOT NULL DEFAULT '',
  `g_sanguineo` char(5) NOT NULL DEFAULT '',
  `edad` char(5) NOT NULL DEFAULT '',
  `est_civil` char(5) NOT NULL DEFAULT '',
  `ocupacion` char(50) NOT NULL DEFAULT '',
  `direccion` varchar(80) NOT NULL,
  `telefono` char(15) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `tipo_doc`, `documento`, `nombre`, `s_nombre`, `apellido`, `s_apellido`, `sexo`, `g_sanguineo`, `edad`, `est_civil`, `ocupacion`, `direccion`, `telefono`, `fecha`) VALUES
(1, 'TI', '112341234', 'nombre', 'david', 'apellido', 'juarex', 'm', 'o+', '25', 'DV', 'mototaxi', 'santafe', '3127503702', '2023-04-15 00:02:55'),
(2, 'CC', '112341234', 'nombre', 'david', 'apellido', 'juarex', 'm', 'o+', '25', 'SO', 'oasjdljflas', 'pradera', '3023724860', '2023-04-15 00:05:28'),
(18, 'CC', '1137', 'valeria', 'sofia', 'rodriguez', 'lopez', 'f', 'A+', '19', 'SO', 'estudiante', 'altos de santafe', '3104302587', '2023-04-19 00:49:24'),
(19, 'CC', '23495698263', 'validacion', 'validar', 'apelido', 'perez', 'm', 'O-', '13', 'SO', 'nada', 'nada', '3009003124', '2023-04-19 01:00:55'),
(20, 'TI', '1234123', 'nombre', 'segundo', 'maza', 'perez', 'o', 'A+', '17', 'SP', 'joyero', 'santafe', '3002302545', '2023-04-19 01:06:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp_factura_compra`
--

CREATE TABLE `detalle_temp_factura_compra` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `token_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_tmp_factura`
--

CREATE TABLE `detalle_tmp_factura` (
  `id` int(11) NOT NULL,
  `id_producto` int(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `mesa` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_tmp_factura`
--

INSERT INTO `detalle_tmp_factura` (`id`, `id_producto`, `cantidad`, `precio_venta`, `mesa`, `token_user`) VALUES
(96, 12, 20, '700.00', 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3 '),
(97, 12, 10, '700.00', 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detall_fact_compra`
--

CREATE TABLE `detall_fact_compra` (
  `correlativo` int(11) NOT NULL,
  `nofactura` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dt_fact`
--

CREATE TABLE `dt_fact` (
  `id` int(50) NOT NULL,
  `id_fact` int(50) NOT NULL,
  `id_producto` int(50) NOT NULL,
  `cantidad` int(50) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dt_fact`
--

INSERT INTO `dt_fact` (`id`, `id_fact`, `id_producto`, `cantidad`, `precio_venta`, `estatus`) VALUES
(1, 1, 12, 1, '700.00', 1),
(2, 1, 12, 1, '700.00', 1),
(3, 2, 12, 1, '700.00', 1),
(4, 2, 12, 1, '700.00', 1),
(5, 3, 12, 1, '700.00', 1),
(6, 3, 12, 2, '700.00', 1),
(7, 4, 12, 4, '700.00', 1),
(8, 5, 12, 5, '700.00', 1),
(9, 5, 12, 4, '700.00', 1),
(10, 6, 12, 40, '700.00', 1),
(11, 6, 12, 20, '700.00', 1),
(12, 6, 12, 10, '700.00', 1),
(13, 6, 12, 1, '700.00', 1),
(14, 6, 12, 3, '700.00', 1),
(15, 7, 12, 5, '700.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact`
--

CREATE TABLE `fact` (
  `id` int(50) NOT NULL,
  `prefijo` char(50) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `id_cliente` int(50) NOT NULL,
  `usuario` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fact`
--

INSERT INTO `fact` (`id`, `prefijo`, `numero`, `id_cliente`, `usuario`, `total`, `estatus`, `fecha`) VALUES
(1, '  FAC', '22', 1, 3, '1400.00', 1, '2023-04-07 20:38:45'),
(2, '  FAC', '23', 1, 3, '1400.00', 1, '2023-04-07 20:43:44'),
(3, '  FAC', '24', 1, 3, '2100.00', 1, '2023-04-10 02:57:44'),
(4, '  FAC', '25', 1, 3, '2800.00', 1, '2023-04-10 03:01:06'),
(5, '  FAC', '26', 1, 3, '6300.00', 1, '2023-04-10 04:43:13'),
(6, '  FAC', '27', 1, 3, '51800.00', 1, '2023-04-11 02:22:35'),
(7, '  FAC', '28', 1, 3, '3500.00', 1, '2023-04-13 22:46:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE `factura_compra` (
  `nofactura` int(11) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `codprovedor` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalfactura` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesatemp`
--

CREATE TABLE `mesatemp` (
  `id_mesa` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `cedula` varchar(50) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `numero` int(11) NOT NULL,
  `precio` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` char(50) NOT NULL,
  `codigo` int(11) NOT NULL,
  `tipo` char(20) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `codigo`, `tipo`, `precio_compra`, `precio_venta`, `fecha`) VALUES
(12, 'agua', 1, '1', '200.00', '700.00', '2023-02-25 21:52:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedor`
--

CREATE TABLE `provedor` (
  `id_provedor` int(11) NOT NULL,
  `nombre` char(60) NOT NULL,
  `direccion` char(60) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `nit` char(50) NOT NULL,
  `dg` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `iva` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `stock` (
`id_producto` int(11)
,`codigo` int(11)
,`nombre` char(50)
,`precio_venta` decimal(10,2)
,`entradas` decimal(32,0)
,`salidas` decimal(65,0)
,`stock` decimal(65,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `stock_nuevo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `stock_nuevo` (
`id_producto` int(11)
,`codigo` int(11)
,`nombre` char(50)
,`precio_venta` decimal(10,2)
,`entradas` decimal(32,0)
,`salidas` decimal(65,0)
,`stock` decimal(65,0)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `stock`
--
DROP TABLE IF EXISTS `stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock`  AS SELECT `p`.`id_producto` AS `id_producto`, `p`.`codigo` AS `codigo`, `p`.`nombre` AS `nombre`, `p`.`precio_venta` AS `precio_venta`, (select ifnull(sum(`dc`.`cantidad`),0) from `detall_fact_compra` `dc` where `dc`.`codproducto` = `p`.`id_producto` and `dc`.`estatus` = 1) AS `entradas`, (select ifnull(sum(`df`.`cantidad`),0) from `dt_fact` `df` where `df`.`id_producto` = `p`.`id_producto` and `df`.`estatus` = 1) + (select ifnull(sum(`dtmp`.`cantidad`),0) from `detalle_tmp_factura` `dtmp` where `dtmp`.`id_producto` = `p`.`id_producto`) AS `salidas`, (select ifnull(sum(`dc`.`cantidad`),0) from `detall_fact_compra` `dc` where `dc`.`codproducto` = `p`.`id_producto` and `dc`.`estatus` = 1) - ((select ifnull(sum(`df`.`cantidad`),0) from `dt_fact` `df` where `df`.`id_producto` = `p`.`id_producto` and `df`.`estatus` = 1) + (select ifnull(sum(`dtmp`.`cantidad`),0) from `detalle_tmp_factura` `dtmp` where `dtmp`.`id_producto` = `p`.`id_producto`)) AS `stock` FROM `producto` AS `p``p`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `stock_nuevo`
--
DROP TABLE IF EXISTS `stock_nuevo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_nuevo`  AS SELECT `p`.`id_producto` AS `id_producto`, `p`.`codigo` AS `codigo`, `p`.`nombre` AS `nombre`, `p`.`precio_venta` AS `precio_venta`, coalesce((select sum(`dc`.`cantidad`) from `detall_fact_compra` `dc` where `dc`.`codproducto` = `p`.`id_producto` and `dc`.`estatus` = 1),0) AS `entradas`, coalesce((select sum(`df`.`cantidad`) from `dt_fact` `df` where `df`.`id_producto` = `p`.`id_producto` and `df`.`estatus` = 1),0) + coalesce((select sum(`dtmp`.`cantidad`) from `detalle_tmp_factura` `dtmp` where `dtmp`.`id_producto` = `p`.`id_producto`),0) AS `salidas`, coalesce((select sum(`dc`.`cantidad`) from `detall_fact_compra` `dc` where `dc`.`codproducto` = `p`.`id_producto` and `dc`.`estatus` = 1),0) - (coalesce((select sum(`df`.`cantidad`) from `dt_fact` `df` where `df`.`id_producto` = `p`.`id_producto` and `df`.`estatus` = 1),0) + coalesce((select sum(`dtmp`.`cantidad`) from `detalle_tmp_factura` `dtmp` where `dtmp`.`id_producto` = `p`.`id_producto`),0)) AS `stock` FROM `producto` AS `p``p`  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `detalle_temp_factura_compra`
--
ALTER TABLE `detalle_temp_factura_compra`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `detalle_tmp_factura`
--
ALTER TABLE `detalle_tmp_factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detall_fact_compra`
--
ALTER TABLE `detall_fact_compra`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `dt_fact`
--
ALTER TABLE `dt_fact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nofactura` (`id_fact`);

--
-- Indices de la tabla `fact`
--
ALTER TABLE `fact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `codcliente` (`id_cliente`);

--
-- Indices de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `codprovedor` (`codprovedor`);

--
-- Indices de la tabla `mesatemp`
--
ALTER TABLE `mesatemp`
  ADD PRIMARY KEY (`id_mesa`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `detalle_tmp_factura`
--
ALTER TABLE `detalle_tmp_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `dt_fact`
--
ALTER TABLE `dt_fact`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `fact`
--
ALTER TABLE `fact`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
