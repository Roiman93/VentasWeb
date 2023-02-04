DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura_compra`(no_factura int)

BEGIN
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

DELIMITER ;

