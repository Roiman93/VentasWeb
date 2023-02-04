


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

-- se consulta la tabla de entrada productos facturas compra  sumando la columna cantidad de los productos iguales entradas
(SELECT IFNULL(SUM(dc.cantidad),0)FROM detall_fact_compra dc WHERE dc.codproducto = p.id_producto AND dc.estatus = 1) as entradas,

-- se consulta la tabla de salida de productos sumando la  columna cantidad de los productos iguales salidas
(SELECT IFNULL(sum(df.cantidad),0) from detallefactura df WHERE df.codproducto=p.id_productoAND df.estatus = 1) +

-- se consulta salida tmp de productos que se generen al facturar
(SELECT IFNULL(sum(dtmp.cantidad),0) from detalle_temp dtmp WHERE dtmp.id_prod=p.id_producto ) as salidas,

-- se  realiza la resta de entradas y salidas  para obtener el stock
(SELECT IFNULL(SUM(dc.cantidad),0)FROM detall_fact_compra dc WHERE dc.codproducto = p.id_producto AND dc.estatus = 1) - 
((SELECT IFNULL(sum(df.cantidad),0) from detallefactura df WHERE df.codproducto=p.id_producto AND df.estatus = 1) +
(SELECT IFNULL(sum(dtmp.cantidad),0) from detalle_temp dtmp WHERE dtmp.id_prod=p.id_producto) ) as stock

FROM producto p;
