DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_facturas`(IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))
BEGIN
      
      DECLARE precio_actual decimal(10,2);
      SELECT pr.precio_venta INTO precio_actual FROM     producto pr WHERE pr.codigo = codigo;
      
      INSERT INTO detalle_temp_facturas(token_user,codproducto,cantidad,precio_compra) VALUES(token_user,codigo,cantidad,precio_actual);
      
     SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = p.codigo 
     WHERE token_user = token_user; 
      
      END$$
DELIMITER ;