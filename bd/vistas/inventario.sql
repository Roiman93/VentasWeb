


-- vista inventario
CREATE VIEW inventario AS

SELECT p.codigo, p.nombre,p.precio_venta,
-- se consulta la tabla de entrada productos facturas compra  sumando la columna cantidad de los productos iguales entradas
(SELECT IFNULL(SUM(dc.cantidad),0)FROM detall_fact_compra dc WHERE dc.codproducto = p.codigo AND dc.estatus = 1) as entradas,
-- se consulta la tabla de salida de productos sumando la  columna cantidad de los productos iguales salidas
(SELECT IFNULL(sum(df.cantidad),0) from detallefactura df WHERE df.codproducto=p.codigo AND df.estatus = 1) as salidas,
-- se  realiza la resta de entradas y salidas  para obtener el stock
(SELECT IFNULL(SUM(dc.cantidad),0)FROM detall_fact_compra dc WHERE dc.codproducto = p.codigo AND dc.estatus = 1) - 
(SELECT IFNULL(sum(df.cantidad),0) from detallefactura df WHERE df.codproducto=p.codigo AND df.estatus = 1) as stock

FROM producto p;
--fin----



-- Vista Inventario Tmp
CREATE View inventario_tmp AS

SELECT p.codigo, p.nombre,p.precio_venta,

/* -- se consulta la tabla de entrada productos facturas compra  sumando la columna cantidad de los productos iguales entradas */
(SELECT IFNULL(SUM(dtfc.cantidad),0)FROM detall_fact_compra dtfc WHERE dtfc.codproducto = p.id_producto AND dc.estatus = 1) as entradas,

/* -- se consulta la tabla de salida de productos sumando la  columna cantidad de los productos iguales salidas */
(SELECT IFNULL(sum(dtf.cantidad),0) from detallefactura dtf WHERE dtf.codproducto=p.id_productoAND dtf.estatus = 1) +

/* -- se consulta salida tmp de productos que se generen al facturar */
(SELECT IFNULL(sum(dtmpf.cantidad),0) from detalle_tmp_factura dtmpf WHERE dtmpf.id_producto=p.id_producto ) as salidas,

/* -- se  realiza la resta de entradas y salidas  para obtener el stock */
(SELECT IFNULL(SUM(dtfc.cantidad),0)FROM detall_fact_compra dtfc WHERE dtfc.codproducto = p.id_producto AND dtfc.estatus = 1) - 
((SELECT IFNULL(sum(df.cantidad),0) from detallefactura df WHERE df.codproducto=p.id_producto AND df.estatus = 1) +
(SELECT IFNULL(sum(dtmp.cantidad),0) from detalle_tmp_factura dtmp WHERE dtmp.id_producto=p.id_producto) ) as stock
t
FROM producto p;
