

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Eliminar_Resolucion`(IN `Id_Resolucion` INT)
BEGIN 
     -- declaracion de variables
   
    declare numero int;

  

    -- validamos si existen resolucion activa del mismo tipo de documento
    set numero =( select COUNT(*) as dato from prefijos  where  estado = 1);

     IF numero > 0 THEN
   
      select "Desactive la Resolucion antes de Eliminar " as Error;
              

     ELSE
         delete  from refijos where id = Id_Resolucion;
         SELECT * FROM prefijos LIMIT 0,0;
        
        

     END IF;
    
  
  END$$
DELIMITER ;