-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2022 a las 02:20:02
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))  BEGIN
      
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_facturas` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))  BEGIN
      
      DECLARE precio_actual decimal(10,2);
      SELECT pr.precio_compra INTO precio_actual FROM     producto pr WHERE pr.id_producto = codigo;
      
      INSERT INTO detalle_temp_facturas(token_user,codproducto,cantidad,precio_compra) VALUES(token_user,codigo,cantidad,precio_actual);
      
     SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = p.id_producto
     WHERE token_user = token_user; 
      
      END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_mesa` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50), IN `mesa` INT)  BEGIN
      
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura` (IN `no_factura` INT)  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (IN `id_detalle` INT, IN `token` VARCHAR(50))  BEGIN 
    DELETE FROM detalle_temp  WHERE correlativo = id_detalle;
    
    SELECT tmp.id_prod, tmp.correlativo,tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp 
    INNER JOIN producto p
    ON tmp.codproducto = p.codigo
    WHERE tmp.token_user = token;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_facturas` (`id_detalle` INT, `token` VARCHAR(50))  BEGIN 
    DELETE FROM detalle_temp_facturas  WHERE correlativo = id_detalle;
    
    SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = p.codigo 
     WHERE token_user = token_user; 
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_mesa` (IN `id_detalle` INT, IN `token` VARCHAR(50), IN `mesa` INT)  BEGIN 
    DELETE FROM detalle_temp  WHERE correlativo = id_detalle AND mesa = mesa;
    
    SELECT tmp.mesa,tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta, p.nombre FROM detalle_temp tmp 
    INNER JOIN producto p
    ON tmp.codproducto = p.codigo
    WHERE tmp.token_user = token;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_compra` (IN `documento` VARCHAR(50), IN `cod_usuario` INT, IN `cod_provedor` INT, IN `token` VARCHAR(50))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Activar_Resolucion` (IN `Id_Resolucion` INT)  BEGIN 
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Agregar_Nuevo_Ciente` (IN `cedula` VARCHAR(20), IN `nombre` VARCHAR(50), IN `nombre_2` VARCHAR(50), IN `apellido_1` VARCHAR(50), IN `apellido_2` VARCHAR(50))  BEGIN

 SET @DX = (select COUNT(*) from cliente where cliente.cedula = cedula );

  IF ( @DX > 0 ) THEN
     
   SELECT "La cedula se encuentra Registrada";

  ELSE

     INSERT INTO cliente(cedula,nombre_1,nombre_2,apellido_1,apellido_2) 
			      VALUES(cedula,nombre,nombre_2,apellido_1,apellido_2); 
     SELECT * FROM cliente where cliente.cedula='';              
                 

  END IF;



 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Anular_Factura_Compra` (`no_factura` INT)  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Desactivar_Resolucion` (IN `Id_Resolucion` INT)  BEGIN 
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Eliminar_Producto` (IN `Id` INT)  BEGIN 
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Eliminar_Resolucion` (IN `Id_Resolucion` INT)  BEGIN 
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Procesar_Mesa` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `Nmesa` INT)  BEGIN
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(50) NOT NULL,
  `cedula` int(50) NOT NULL,
  `nombre_1` varchar(50) NOT NULL,
  `nombre_2` varchar(50) NOT NULL,
  `apellido_1` varchar(50) NOT NULL,
  `apellido_2` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `cedula`, `nombre_1`, `nombre_2`, `apellido_1`, `apellido_2`, `fecha`) VALUES
(1, 1, 'CONSUMIDOR FINAL', 'CONSUMIDOR FINAL ', 'CONSUMIDOR FINAL', 'CONSUMIDOR FINAL', '2021-10-06'),
(29, 1067927688, 'ROYMAN', 'DAVID', 'RODRIGUEZ', 'LOPEZ', '2022-02-08'),
(30, 23, 'JUAN', 'PEREZ', 'PEREZ', 'PEREZ', '2022-02-08'),
(31, 78696517, 'luis', 'alfonso', 'rodriguez', 'vasquez', '2022-02-08'),
(32, 50895589, 'ivon', 'olga', 'lopez', 'polo', '2022-02-08'),
(33, 25765246, 'alina', '', 'polo', 'delopez', '2022-02-08'),
(34, 12346, 'pablo', 'andres', 'suarez', 'paez', '2022-02-08'),
(35, 12234, 'daniela', 'sofia', 'rodriguez', 'lopez', '2022-02-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_config` int(11) NOT NULL,
  `nombre` char(50) NOT NULL,
  `direccion` char(70) NOT NULL,
  `telefono` char(50) NOT NULL,
  `nit` char(50) NOT NULL,
  `dg` int(3) NOT NULL,
  `iva` int(3) NOT NULL,
  `email` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_config`, `nombre`, `direccion`, `telefono`, `nit`, `dg`, `iva`, `email`) VALUES
(2, 'Nombre de la Empresa', 'mz 5 lote 1 br Santafe', '3023724861', '1067927688', 0, 17, 'roiman93l2opez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(20) NOT NULL,
  `nofactura` bigint(20) NOT NULL,
  `codproducto` bigint(20) NOT NULL,
  `cantidad` int(50) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `id_prod` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `mesa` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp_facturas`
--

CREATE TABLE `detalle_temp_facturas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `token_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(20) NOT NULL,
  `prefijo` char(50) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `codcliente` int(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) NOT NULL,
  `totalfactura` decimal(10,2) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `inventario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `inventario` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefijos`
--

CREATE TABLE `prefijos` (
  `id` int(11) NOT NULL,
  `prefijo` char(50) NOT NULL,
  `n_inicio` int(50) NOT NULL,
  `n_final` int(50) NOT NULL,
  `n_actual` int(50) NOT NULL,
  `n_resolucion` varchar(50) NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `estado` int(50) NOT NULL,
  `tipo_documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `prefijos`
--

INSERT INTO `prefijos` (`id`, `prefijo`, `n_inicio`, `n_final`, `n_actual`, `n_resolucion`, `fecha_resolucion`, `estado`, `tipo_documento`) VALUES
(1, 'FAC', 1, 1500, 15, '1990', '2020-12-02', 2, 1);

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
  `existencia` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` char(50) NOT NULL,
  `apellido` char(100) NOT NULL,
  `identificacion` int(50) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `email` char(70) NOT NULL,
  `password` char(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `identificacion`, `id_tipo`, `email`, `password`) VALUES
(1, 'ROYMAN DAVID', 'RODRIGUEZ LOPEZ', 1067927688, 1, 'roiman93lopez@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tipo`
--

CREATE TABLE `usuario_tipo` (
  `usuario_tipo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_tipo`
--

INSERT INTO `usuario_tipo` (`usuario_tipo`, `tipo`) VALUES
(1, 'admin'),
(2, 'vendedor');

-- --------------------------------------------------------

--
-- Estructura para la vista `inventario`
--
DROP TABLE IF EXISTS `inventario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventario`  AS SELECT `p`.`id_producto` AS `id_producto`, `p`.`codigo` AS `codigo`, `p`.`nombre` AS `nombre`, `p`.`precio_venta` AS `precio_venta`, (select ifnull(sum(`dc`.`cantidad`),0) from `detall_fact_compra` `dc` where `dc`.`codproducto` = `p`.`id_producto` and `dc`.`estatus` = 1) AS `entradas`, (select ifnull(sum(`df`.`cantidad`),0) from `detallefactura` `df` where `df`.`codproducto` = `p`.`id_producto` and `df`.`estatus` = 1) + (select ifnull(sum(`dtmp`.`cantidad`),0) from `detalle_temp` `dtmp` where `dtmp`.`id_prod` = `p`.`id_producto`) AS `salidas`, (select ifnull(sum(`dc`.`cantidad`),0) from `detall_fact_compra` `dc` where `dc`.`codproducto` = `p`.`id_producto` and `dc`.`estatus` = 1) - ((select ifnull(sum(`df`.`cantidad`),0) from `detallefactura` `df` where `df`.`codproducto` = `p`.`id_producto` and `df`.`estatus` = 1) + (select ifnull(sum(`dtmp`.`cantidad`),0) from `detalle_temp` `dtmp` where `dtmp`.`id_prod` = `p`.`id_producto`)) AS `stock` FROM `producto` AS `p` ;

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
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `detalle_temp_facturas`
--
ALTER TABLE `detalle_temp_facturas`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `detall_fact_compra`
--
ALTER TABLE `detall_fact_compra`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `codcliente` (`codcliente`);

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
-- Indices de la tabla `prefijos`
--
ALTER TABLE `prefijos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `provedor`
--
ALTER TABLE `provedor`
  ADD PRIMARY KEY (`id_provedor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `usuario_tipo`
--
ALTER TABLE `usuario_tipo`
  ADD PRIMARY KEY (`usuario_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `detalle_temp_facturas`
--
ALTER TABLE `detalle_temp_facturas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `detall_fact_compra`
--
ALTER TABLE `detall_fact_compra`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `nofactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mesatemp`
--
ALTER TABLE `mesatemp`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prefijos`
--
ALTER TABLE `prefijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `provedor`
--
ALTER TABLE `provedor`
  MODIFY `id_provedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario_tipo`
--
ALTER TABLE `usuario_tipo`
  MODIFY `usuario_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`);

--
-- Filtros para la tabla `detall_fact_compra`
--
ALTER TABLE `detall_fact_compra`
  ADD CONSTRAINT `detall_fact_compra_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura_compra` (`nofactura`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Filtros para la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD CONSTRAINT `factura_compra_ibfk_1` FOREIGN KEY (`codprovedor`) REFERENCES `provedor` (`id_provedor`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `usuario_tipo` (`usuario_tipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
