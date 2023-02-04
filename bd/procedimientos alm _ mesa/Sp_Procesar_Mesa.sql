DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Procesar_Mesa`(IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `Nmesa` INT)
BEGIN
  DECLARE factura INT;
  DECLARE registros INT;
  DECLARE total decimal(10,2);
  

  DECLARE Prefijo VARCHAR(50);
  DECLARE numero_factura_actual varchar(50);
  DECLARE nuevo_numero varchar(50);

  DECLARE tmp_cod_producto int;
  DECLARE tmp_cant_producto int;
  DECLARE a int;
  SET a = 1;


 -- se crea una tabla temporal para almacenar codigo , cantidad del producto
  CREATE TEMPORARY TABLE tbl_tmp_tokenuser (
       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       cod_prod BIGINT,
       cant_prod int);
  -- se consulta la tabla temporal para contar el numero de registros
  SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token and mesa = Nmesa);

  -- se consulta si el prefijo esta activo
  set prefijo =( SELECT p.prefijo FROM prefijos p WHERE p.estado = 1 AND p.tipo_documento = '1');


  IF (!IsNull(prefijo)) THEN

          if (registros > 0  ) THEN

        -- se insertan los registros de la tabla detalle_temp a la tabla tbl_tmp_tokenuser 
              INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT  id_prod,cantidad FROM detalle_temp WHERE token_user = token and mesa = Nmesa;
              
        -- se consulta si el numero factura actual esta activo
              set numero_factura_actual =( SELECT p.n_actual FROM prefijos p WHERE p.estado = 1 AND p.tipo_documento = '1');

        -- se insertan los registro a la tabla factura y se extrae el id   
              INSERT INTO factura(usuario,codcliente,prefijo,numero) VALUES(cod_usuario,cod_cliente,Prefijo,numero_factura_actual);
              SET factura = LAST_INSERT_ID();
              
        -- se inserta los detalles factura de la tabla tbl_tmp_tokenuser a la tabla detallefactura  y en la variable factura se guardan los registros   
              INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) SELECT (factura) as nofactura, id_prod, cantidad, precio_venta
              FROM detalle_temp WHERE token_user = token and mesa = Nmesa;

            -- se realizan el calculo del total 
              SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
            -- se inserta el total a la tabla factura   
              UPDATE factura SET totalfactura = total WHERE nofactura = factura;

            -- se actualiza el numero actual de la  factura
              set nuevo_numero = numero_factura_actual + 1;
              UPDATE prefijos SET n_actual = nuevo_numero WHERE estado = '1' AND tipo_documento = '1';

        
            -- se elimina los registros en la tabla detalle temporal  
              DELETE FROM detalle_temp WHERE token_user = token and mesa = Nmesa;
            -- se vacia la tabla temporal  
              TRUNCATE TABLE tbl_tmp_tokenuser;
            -- se consulta la tabla factura  
              SELECT * FROM factura WHERE nofactura = factura;  
              
          ELSE

          SELECT 0;

          END IF;
  ELSE
  
      SELECT "error";

  END IF;      
 END$$
DELIMITER ;