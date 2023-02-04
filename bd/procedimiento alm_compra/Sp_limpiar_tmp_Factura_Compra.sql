DELIMITER $$
CREATE PROCEDURE Sp_limpiar_tmp_Factura_Compra (token int)
BEGIN

DELETE FROM detalle_temp_facturas WHERE token_user= token;
SELECT * FROM detalle_temp_facturas;


END$$
DELIMITER ;