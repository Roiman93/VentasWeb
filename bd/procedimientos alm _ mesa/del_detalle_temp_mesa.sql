DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_mesa`(id_detalle int, token varchar(50),mesa int)
BEGIN 
    DELETE FROM detalle_temp  WHERE correlativo = id_detalle AND mesa = mesa;
    
    SELECT tmp.mesa,tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta, p.nombre FROM detalle_temp tmp 
    INNER JOIN producto p
    ON tmp.codproducto = p.codigo
    WHERE tmp.token_user = token;
  END$$
DELIMITER ;