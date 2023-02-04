DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Actualizar_Producto`(IN ID INT,IN CODIGO VARCHAR(50), NOMBRE VARCHAR(50),IN TIPO INT,IN PRECIO_C VARCHAR(50),IN PRECIO_V VARCHAR(50))
BEGIN 
   
       DECLARE N INT;
       UPDATE  producto SET codigo=CODIGO, nombre =NOMBRE, precio_compra=PRECIO_C, precio_venta=PRECIO_V, tipo=TIPO
	   WHERE id_producto=ID;

      SET N =( SELECT COUNT(*) FROM detall_fact_compra WHERE codproducto = ID);
              SELECT * FROM detallefactura  WHERE codproducto= ID;

       IF N > 0 THEN
          UPDATE  producto SET codigo=CODIGO, nombre =NOMBRE, precio_compra=PRECIO_C, precio_venta=PRECIO_V, tipo=TIPO
	      WHERE id_producto=ID;
          
          UPDATE  detall_fact_compra SET codproducto=CODIGO
	      WHERE codproducto = ID;

          UPDATE  detall_fact_compra SET codproducto=CODIGO
	      WHERE codproducto = ID;
       END IF
  
  END$$
DELIMITER ;