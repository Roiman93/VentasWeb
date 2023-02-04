DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp`(id_detalle int, token varchar(50))
BEGIN 
    DELETE FROM detalle_temp  WHERE correlativo = id_detalle;
    
    SELECT tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp 
    INNER JOIN producto p
    ON tmp.codproducto = p.codigo
    WHERE tmp.token_user = token;
  END$$
DELIMITER ;