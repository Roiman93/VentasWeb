DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Agregar_Nuevo_Ciente`(IN `cedula` VARCHAR(20), IN `nombre` VARCHAR(50), IN `nombre_2` VARCHAR(50), IN `apellido_1` VARCHAR(50), IN `apellido_2` VARCHAR(50))
BEGIN

 

  
     
  -- SELECT "La cedula se encuentra Registrada" AS error;

     INSERT INTO cliente(cedula,nombre_1,nombre_2,apellido_1,apellido_2) 
			      VALUES(cedula,nombre,nombre_2,apellido_1,apellido_2); 
     SELECT * FROM cliente where cliente.cedula='';              
                 





 END$$
DELIMITER ;