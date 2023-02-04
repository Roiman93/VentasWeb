
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Desactivar_Resolucion`(IN `Id_Resolucion` INT)
BEGIN 
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
DELIMITER ;