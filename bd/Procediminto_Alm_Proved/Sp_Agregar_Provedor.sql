

DELIMITER $$
CREATE  PROCEDURE `Sp_Agregar_Proveedor`(IN `nit_provedor` VARCHAR(20), IN `dg_verificacion` VARCHAR(10),
IN `nombre` VARCHAR(50), IN `direccion` VARCHAR(50), IN `telefono` VARCHAR(50))

BEGIN
declare x int;
declare id_p int;

  set x=(SELECT COUNT(*) FROM provedor p where concat(p.nit,p.dg) = concat(nit_provedor,dg_verificacion)); 

  IF x > 0 THEN
     
  SELECT "El nit se encuentra Registrado en nuestra base de datos" AS error;

  ELSE 

  INSERT INTO `provedor` (`nombre`, `direccion`, `telefono`, `nit`, `dg`) VALUES
  (nombre, direccion,telefono, nit_provedor, dg_verificacion);
 SET id_p = LAST_INSERT_ID();


     SELECT * from provedor where id_provedor= id_p;              
                 
  END IF;
 END$$
DELIMITER;


DELIMITER $$
ALTER DEFINER=`root`@`localhost` PROCEDURE `Sp_Agregar_Proveedor`(IN `nit_provedor` VARCHAR(20), IN `dg_verificacion` VARCHAR(2), IN `nombre` VARCHAR(50), IN `direccion` VARCHAR(50), IN `telefono` VARCHAR(50))
BEGIN
declare x int;

  set x=(SELECT COUNT(*) FROM provedor p where concat(p.nit,p.dg) = concat(nit_provedor,dg_verificacion)); 

  IF x > 0 THEN
     
  SELECT "El nit se encuentra Registrado en nuestra base de datos" AS error;

  ELSE 

  INSERT INTO `provedor` (`nombre`, `direccion`, `telefono`, `nit`, `dg`) VALUES
(nombre, direccion,telefono, nit_provedor, dg_verificacion);
 
     SELECT * from provedor WHERE dg='';              
                 
  END IF;
 END$$
DELIMITER ;