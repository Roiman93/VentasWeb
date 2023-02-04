DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_facturas`(id_detalle int, token varchar(50))
BEGIN 
    DELETE FROM detalle_temp_facturas  WHERE correlativo = id_detalle;
    
    SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = p.codigo 
     WHERE token_user = token_user; 
  END$$
DELIMITER ;