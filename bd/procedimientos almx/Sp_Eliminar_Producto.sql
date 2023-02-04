DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Eliminar_Producto`(IN `Id` INT)
BEGIN 
     -- declaracion de variables
   
    declare numero int;

    set numero =(select count(*) from detallefactura  where codproducto= id );

      IF numero > 0 then
  

         delete  from producto where id_producto = Id;
         SELECT * FROM producto LIMIT 0,0;
        
        ELSE

        SELECT "No se puede borrar el producto, tiene movimientos" AS Error;

     END IF;
    
  
  END$$
DELIMITER ;