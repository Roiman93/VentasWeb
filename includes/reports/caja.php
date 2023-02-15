<?php
	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	$tl_sniva   = 0;
	$total 		= 0;
	setlocale(LC_MONETARY, 'en_US');

// print_r($configuracion); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php echo $anulada; ?>
    <div id="page_pdf">
        <table id="factura_head">
            <tr>
                <td class="logo_factura">
                    <div>
                        <img src="img/logo.png">
                    </div>
                </td>
                <td class="info_empresa">
                    <?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
				 ?>
                    <div>
                        <span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span>
                        <p>Razon Social: <?php echo $configuracion['nombre']; ?></p>
                        <p>Dirección: <?php echo $configuracion['direccion']; ?></p>
                        <p>Nit: <?php echo $configuracion['nit']; ?></p>
                        <p>Teléfono: <?php echo $configuracion['telefono']; ?></p>
                        <p>Email: <?php echo $configuracion['email']; ?></p>
                    </div>
                    <?php
					}
				 ?>
                </td>
               <td>
				   
			   </td>

            </tr>
        </table>

        <span class="h3">Cuadre de Caja General</span>

        <table id="factura_detalle">
            <thead>
                <tr>
                    <th width="50px">N_Factura</th>
                    <th class="textleft" width="50px">Fecha</th>
                    <th class="textcenter" width="120px">Vendedor</th>
                    <th class="textcenter" width="80px">Total</th>
                </tr>
            </thead>
            <tbody id="detalle_productos">

                <?php

				if($result > 0){

					while ($row = mysqli_fetch_assoc($query)){
			 ?>
                <tr>
                    <td width="50px" class="textcenter"><?php echo $row['prefijo']."".$row['numero'] ; ?></td>
                    <td width="50px"><?php echo $row['fecha']; ?></td>
                    <td width="120px" class="textcenter"> <?php echo $row['vendedor']; ?></td>
                    <td width="80px" class="textcenter"><?php echo number_format ($row['totalfactura']); ?></td>
                </tr>
                <?php
						$precio_total = $row['totalfactura'];
						$subtotal = round($subtotal + $precio_total, 2);
					}
				}

				$impuesto 	= round($subtotal * ($iva / 100), 2);
				$tl_sniva 	= round($subtotal - $impuesto,2 );
				$total 		= round($tl_sniva + $impuesto,2);
			?>
            </tbody>




        </table>


        <p>  </p>

        <table class="info_factura">
            <div class="round" style="float:right;">
                <span class="h4">Total</span>
                <p class="textcenter">SUBTOTAL: <strong> <?php echo ' $'.number_format($tl_sniva); ?></strong></p>
                <p class="textcenter">IVA:<strong> <?php echo ' $'.number_format($impuesto); ?></strong> </p>
                <!-- <p>Hora: <?php // echo $factura['hora']; ?></p> -->
                <p class="textcenter">TOTAL:<strong> <?php echo ' $'.number_format($total); ?></strong> </p>
            </div>
        </table>


        <div >
            <p  style="margin-top: 80px;" class="nota"> Firma Emcargado:____________________ <br>Firma Quien Recibe:___________________</p>
            <h4 class="label_gracias">¡Lea bien el documento antes de Firmar!</h4>
        </div>

    </div>

</body>

</html>