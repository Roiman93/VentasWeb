DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_compra`(IN `documento` VARCHAR(50), IN `cod_usuario` INT, IN `cod_provedor` INT, IN `token` VARCHAR(50))
BEGIN
  DECLARE factura INT;
  DECLARE registros INT;
  DECLARE total decimal(10,2);
  
 
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
      INSERT INTO factura_compra(numero,usuario,codprovedor) VALUES(documento,cod_usuario,cod_provedor);
      SET factura = LAST_INSERT_ID();
       
  -- se inserta los detalles factura de la tabla tbl_tmp_tokenuser a la tabla detall_fcat_compra  y en la variable factura se guardan los registros   
      INSERT INTO detall_fact_compra(nofactura,codproducto,cantidad,precio_compra) SELECT (factura) as nofactura, codproducto, cantidad, precio_compra FROM detalle_temp_facturas WHERE token_user = token;

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
   SELECT 'No se encontro Productos para facturar' as error;
  END IF;
 END$$
DELIMITER ;