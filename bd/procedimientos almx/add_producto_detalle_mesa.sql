DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_mesa`(IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50), mesa int)
BEGIN
      
      DECLARE precio_actual decimal(10,2);
      SELECT pr.precio_venta INTO precio_actual FROM producto pr WHERE pr.codigo = codigo;
      
      INSERT INTO detalle_temp(token_user,mesa,codproducto,cantidad,precio_venta) VALUES(token_user,mesa,codigo,cantidad,precio_actual);
      
      SELECT tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta,tmp.mesa  FROM detalle_temp tmp
      INNER JOIN producto p
      ON tmp.codproducto = p.codigo
      WHERE tmp.token_user = token_user AND tmp.mesa = mesa;
      
      END$$
DELIMITER ;