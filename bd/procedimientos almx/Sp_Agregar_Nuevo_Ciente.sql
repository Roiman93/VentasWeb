DELIMITER $$
CREATE PROCEDURE Sp_Agregar_Nuevo_Ciente( cedula VARCHAR(20), IN nombre VARCHAR(50), IN nombre_2 VARCHAR(50), IN apellido_1 VARCHAR(50), IN apellido_2 VARCHAR(50) )
 BEGIN

 SET @DX = (select COUNT(*) from cliente where cliente.cedula = cedula );

  IF ( @DX > 0 ) THEN
     
   SELECT "La cedula se encuentra Registrada";

  ELSE

     INSERT INTO cliente(cedula,nombre_1,nombre_2,apellido_1,apellido_2) 
	  VALUES(cedula,nombre,nombre_2,apellido_1,apellido_2); 
     

  END IF;



 END;$$
DELIMITER ;
