DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Activar_Resolucion`(IN `Id_Resolucion` INT)
BEGIN 
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
DELIMITER ;