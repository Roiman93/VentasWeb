DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_compra`(IN `cod_usuario` INT, IN `cod_provedor` INT, IN `token` VARCHAR(50))
BEGIN
  DECLARE factura INT;
  DECLARE registros INT;
  DECLARE total decimal(10,2);
  
  DECLARE nueva_existencia int;
  DECLARE existencia_actual int;
  
  DECLARE tmp_cod_producto int;
  DECLARE tmp_cant_producto int;
  DECLARE a int;
  SET a = 1;
  -- se crea una tabla temporal para almacenar codigo , cantidad del producto
  CREATE TEMPORARY TABLE tbl_tmp_fac_tokenuser (
       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       cod_prod BIGINT,
       cant_prod int);
  -- se consulta la tabla temporal para contar el numero de registros
  SET registros = (SELECT COUNT(*) FROM detalle_temp_facturas  WHERE token_user = token);
 
  if registros > 0 THEN
  -- se insertan los registros de la tabla detalle_temp a la tabla tbl_tmp_tokenuser 
      INSERT INTO tbl_tmp_fac_tokenuser(cod_prod,cant_prod) SELECT  codproducto,cantidad FROM detalle_temp_facturas  WHERE token_user = token;
      
  -- se insertan los registro a la tabla factura_compra y se extrae el id   
      INSERT INTO factura_compra(usuario,codprovedor) VALUES(cod_usuario,cod_provedor);
      SET factura = LAST_INSERT_ID();
       
  -- se inserta los detalles factura de la tabla tbl_tmp_tokenuser a la tabla detall_fcat_compra  y en la variable factura se guardan los registros   
      INSERT INTO detall_fact_compra(nofactura,codproducto,cantidad,precio_compra) SELECT (factura) as nofactura, codproducto, cantidad, precio_compra FROM detalle_temp_facturas WHERE token_user = token;
      
    WHILE a <= registros DO
    -- se llenan las variables temporales con el codigo y catidad de producto
       SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_fac_tokenuser WHERE id=a;
    -- se inserta a la varible existencia actual la existencia del producto
       SELECT existencia INTO existencia_actual FROM producto WHERE codigo = tmp_cod_producto;
    -- se hace el calculo de la existencia    
       SET nueva_existencia = existencia_actual + tmp_cant_producto;
    -- se actualiza la existencia en la tabla producto   
       UPDATE producto SET existencia = nueva_existencia WHERE codigo = tmp_cod_producto;
       
       set a=a+1;
    END WHILE;
    -- se realizan el calculo del total 
      SET total = (SELECT SUM(cantidad * precio_compra) FROM detalle_temp_facturas WHERE token_user = token);
    -- se inserta el total a la tabla factura   
      UPDATE factura_compra SET totalfactura = total WHERE nofactura = factura;
    -- se elimina los registros en la tabla detalle temporal  
      DELETE FROM detalle_temp_facturas WHERE token_user = token;
    -- se vacia la tabla temporal  
      TRUNCATE TABLE tbl_tmp_fac_tokenuser;
    -- se consulta la tabla factura  
      SELECT * FROM factura_compra WHERE nofactura = factura;  
      
   ELSE
   SELECT 0;
  END IF;
 END$$
DELIMITER ;