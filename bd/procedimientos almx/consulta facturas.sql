SELECT f.nofactura,f.fecha,f.totalfactura,f.estatus, u.nombre, u.apellido, c.nombre_1, c.nombre_2, c.apellido_1,c.apellido_2  from factura f INNER JOIN usuario u ON u.id_usuario = f.usuario 
INNER JOIN cliente c ON c.id_cliente = f.codcliente
WHERE f.estatus != 10;