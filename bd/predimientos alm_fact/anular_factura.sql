DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura`(no_factura int)
BEGIN
    -- declaracion de variables 
        DECLARE existe_factura int;
        -- DECLARE registros int;
        -- DECLARE a int;
        -- DECLARE cod_producto int;
        -- DECLARE cant_producto int;
        -- DECLARE existencia_actual int;
        -- DECLARE nueva_existencia int;
    -- consultamos si existe la factura 
        SET existe_factura = (SELECT COUNT(*) FROM factura WHERE nofactura = no_factura and estatus = 1);
    -- validamos con condicional    
        IF existe_factura > 0 THEN
    -- creamos un tabla temporal       
        --    CREATE TEMPORARY TABLE tbl_tmp (
	    --        	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	    --        	cod_prod BIGINT,
	    --        	cant_prod int);
        --    SET a =1;
    -- consultamos la catidad de productos de la factura selecionada       
        --    SET registros = (SELECT COUNT(*) FROM detallefactura where nofactura = no_factura);
    -- validamos con condicional la variable registros 
        --    IF registros > 0 THEN
    -- insertamos datos a la tabla temporal  de la tabla detalle factura       
            --   INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detallefactura WHERE nofactura = no_factura;
              
    --           WHILE a <= registros DO
    -- --  selecionamos codigo y catidad de un producto del tabla temporal a las variables         
	--               SELECT cod_prod,cant_prod INTO cod_producto,cant_producto from tbl_tmp WHERE id = a;
    -- --  consultamos la existencia en la tabla productos  y la almacenamos en la variable  existencia actual               
	--               SELECT existencia INTO existencia_actual FROM producto WHERE codigo = cod_producto;
    -- --  calculamos el valor de la existencia               
	--               SET nueva_existencia = existencia_actual + cant_producto;
    -- --  actualizamos la el campo existencia en la tabla productos              
	--               UPDATE producto SET existencia = nueva_existencia WHERE codigo = cod_producto;

	--               SET a=a+1;

    --           END WHILE;
    --  actualizamso el estado de la factuta 
              UPDATE factura SET estatus = 2 WHERE nofactura = no_factura;
              update detallefactura SET estatus = 2 WHERE nofactura = no_factura;
    -- vaciamos la tabla temporal          
            --   DROP TABLE tbl_tmp;
    -- consultamos la factura           
              SELECT * FROM factura WHERE nofactura = no_factura;

        --    END IF;

           ELSE
           SELECT 0 factura;
           END if;

    END$$
DELIMITER ;