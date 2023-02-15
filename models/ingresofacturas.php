<?php 
header('Access-Control-Allow-Origin:*');
 
  include '../modelo/conexion.php';

/////////////////////////////////////////////////ingreso facturas compra /////////////////////////////////////////////////////////

 
 // agregar producto a detalle temporal _ facturas compra 
	  if($_POST['action'] == 'addProductoFact'){
	  	
	  	if (empty($_POST['producto']) || empty($_POST['cantidad'])){
	  		       echo "error";
	  	}else{
	  		                   
					  		$codproducto = $_POST['producto'];
					  		$cantidad = $_POST['cantidad'];
					  		$token = $_POST['token'];
					  		
				       
				       $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				       $result_iva = mysqli_num_rows($query_iva);
				           

		 $query_detalle_temp_fact = mysqli_query($conexion,"CALL add_detalle_temp_facturas('$codproducto','$cantidad','$token')");
	     $result = mysqli_num_rows($query_detalle_temp_fact);
				       
				       $detalletabla = '';
				       $sub_total  = 0;
				       $iva        = 0;
				       $total      = 0;
				       $arrayData  = array();

				       if ($result > 0) {
				       	  if ($result_iva > 0) {
				       	  	$info_iva = mysqli_fetch_assoc($query_iva);
				       	  	$iva = $info_iva['iva'];
				       	  	
				       	   }
					       	 while ($data = mysqli_fetch_assoc($query_detalle_temp_fact)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_compra'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 

					            
					            $detalletabla .= '<tr>                
					                                                  
															          <td class="textcenter tx">'.$data['codigo'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.number_format($data['precio_compra']).'</td>
															          <td class="right aligned tx">'.number_format($precioTotal).'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="del_producto_detalle_facturas('.$data['correlativo'].'); " ><i class="trash alternate icon"></i></a>
															          </td>
														         </tr>'; 
					       	    }

					       	   
                                

					       	    $impuesto = round($sub_total * ($iva / 100 ), 2);
					       	    $tl_sniva = round($sub_total - $impuesto, 2);
					       	    $total    = round($tl_sniva + $impuesto, 2);

					       	    
					       	    $tlt = number_format($total, 2, ".", "."); 
                                $tl_s  = number_format($tl_sniva, 2, ".", "."); 
					       	    $inpto = number_format($impuesto, 2, ".", "."); 
				              
				              $detalletotales = '<tr>                 
																	         <td colspan="5" class="right aligned tx"><p>SUBTOTAL $:</p></td>
																	         <td class="right aligned tx"><p>'.$tl_s.'</p></td>
																	      </tr>
																	      <tr>
																	        <td colspan="5" class="right aligned tx"><p>Iva(19%)</p></td>
																	        <td class="right aligned tx">'.$inpto.'</td>
																	      </tr>
																	      <tr>
																	        <td colspan="5" class="right aligned tx"><p>TOTAL $:</p></td>
																	        <td class="right aligned tx"><p>'.$tlt.'</p></td>
																	      </tr>';


									        $arrayData['detalle']= $detalletabla;
											$arrayData['totales']= $detalletotales;

											echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				       }else{
				       	 echo "error";
				        }
				       mysqli_close($conexion);
					}
      	exit;

	  }//fin

    

     // eliminar datos detalle temp mesas

	  if ($_POST['action'] == 'delDetalle'){
       
		       if (empty($_POST['id_detalle']))
			  	 {
			  	 	 echo " id correlativo vacio ";exit;

			  	  }else{

			  	 	  $id_detalle = $_POST['id_detalle'];
			  	 	  $token = $_POST['token'];
			
						  $sql = "CALL del_detalle_temp_facturas('$id_detalle','$token')";

						  if (mysqli_query($conexion,$sql)) {
							//echo "Datos Actualizados..";
							mysqli_close($conexion);
							exit;
					
						  } else {
							mysqli_close($conexion);
							 echo $sql." ".mysqli_error($conexion);
							exit;
					
						  }
						 
           
				  
  
				}       
	   	 exit;
	  }
   //fin

 
 // extraer datos del detalle temp facturas
      
	  if ($_POST['action'] == 'Detalletmpfact'){
	  	  
	  	 if (empty($_POST['user']))
	  	 {
	  	 	 echo "usuario vacio";

	  	 }else{

	  	 	
	  	 	  $token = $_POST['user'];
	  	 	  $query = mysqli_query($conexion,"SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,p.codigo,p.nombre,p.precio_compra 
				 FROM detalle_temp_facturas tmp INNER JOIN producto p ON tmp.codproducto = id_producto WHERE token_user = '$token' ");


	  	 	  $result = mysqli_num_rows($query);
          
			  $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
			  $result_iva = mysqli_num_rows($query_iva);
				
						$detalletabla = '';
						$sub_total  = 0;
						$iva        = 0;
						$total      = 0;
						$arrayData  = array();

			 //var_dump($result);

           if ($result > 0) {

				       	  if ($result_iva > 0) {
				       	  	$info_iva = mysqli_fetch_assoc($query_iva);
				       	  	$iva = $info_iva['iva'];
				       	  	
				       	   }
					       	 while ($data = mysqli_fetch_assoc($query)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_compra'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
					             
					            $detalletabla .= '<tr>                  
					                                                 
															          <td class="textcenter tx">'.$data['codigo'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.number_format($data['precio_compra']).'</td>
															          <td class="right aligned tx">'.number_format($precioTotal).'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle_facturas('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
															          </td>
														         </tr>'; 
					       	    }

					       	    $impuesto = round($sub_total * ($iva / 100 ), 2);
					       	    $tl_sniva = round($sub_total - $impuesto, 2);
					       	    $total    = round($tl_sniva + $impuesto, 2);

                                $tlt = number_format($total); 
                                $tl_s  = number_format($tl_sniva); 
					       	    $inpto = number_format($impuesto); 
				              
				              $detalletotales = '<tr>
																	         <td colspan="5" class="right aligned tx"><p>SUBTOTAL $:</p></td>
																	         <td class="right aligned tx"><p>'.$tl_s.'</p></td>
																	      </tr>
																	      <tr>
																	        <td colspan="5" class="right aligned tx"><p>Iva(19%)</p></td>
																	        <td class="right aligned tx">'.$inpto.'</td>
																	      </tr>
																	      <tr>
																	        <td colspan="5" class="right aligned tx"><p>TOTAL $:</p></td>
																	        <td class="right aligned tx"><p>'.$tlt.'</p></td>
																	      </tr>';

									    $arrayData['detalle']= $detalletabla;
										$arrayData['totales']= $detalletotales;

										echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
										mysqli_close($conexion);exit;
				       }else{
				       	 echo "error";
				        }
				       mysqli_close($conexion);exit;
	  	 }
      exit;
	  } //fin




// procesar factura compra
    if ($_POST['action'] == 'procesarCompra')
	  { 
			 //print_r($_POST);exit;
					
                 $codprov = $_POST['provedor'];
				 $N_Docuemnto = $_POST['numero'];
				 $token = $_POST['token']; 
				 $usuario = $_POST['usuario'];
				 $query = mysqli_query($conexion,"SELECT * FROM detalle_temp_facturas WHERE token_user = '$token'");
				 $result = mysqli_num_rows($query);

	          if($result > 0)
			      {
	            $query_procesar = mysqli_query($conexion,"CALL procesar_compra('$N_Docuemnto','$usuario','$codprov','$token')");
				$resul = mysqli_num_rows($query_procesar);

	             if ($resul > 0)
				    {
						//$data = mysqli_fetch_assoc($query_procesar);
						//echo json_encode($data,JSON_UNESCAPED_UNICODE);
					}else{
						echo "No se proceso la Compra";
					}

				}else{
					echo " no hay registros";
				}
			  mysqli_close($conexion);exit; 
	  }
   // fin 

  
  // anular facturas compra
	  if ($_POST['action'] == 'anulFactura'){

	      //print_r($_POST['action']);exit;
	      if( empty($_POST['nofactur'])) {

           echo 'selecione una factura';

        }else{

               $no = $_POST['nofactur']; 
               $query_anular = mysqli_query($conexion,"CALL Sp_Anular_Factura_Compra('$no')");
               $resul = mysqli_num_rows($query_anular);
  
               if ($resul > 0)
               {
                  $data = mysqli_fetch_assoc($query_anular);
                  echo json_encode($data,JSON_UNESCAPED_UNICODE);
                }else{
                        echo "error";
                }

       
        mysqli_close($conexion);exit; 

        }

	  }

	  //fin

// cancelar factura compra 

if ($_POST['action'] == 'CancelarFacturaCompra'){

	
	if( empty($_POST['token'])) {
       
	 echo '';
	 exit;

  }else{

	     $token_id= $_POST['token'];
		 $query_anular = mysqli_query($conexion,"CALL Sp_limpiar_tmp_Factura_Compra('$token_id')");
		 $resul = mysqli_num_rows($query_anular);

		 if ($resul > 0)
		 {
			$data = mysqli_fetch_assoc($query_anular);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
			mysqli_close($conexion);exit;
		  }else{
				  mysqli_close($conexion);exit;
		  }

 
  mysqli_close($conexion);exit; 

  }

}
 

// fin

//////////////////// buscar facturas compra ///////////////////////////

// Buscar facturas
	if ($_POST['action'] == 'BuscarCompra')
	  {
	  	 
	  	 //print_r ($_POST); exit;
	  	 if (empty($_POST['nofactura'])){
	  	 	 $detalletabla = '';
         $arrayData  = array();
         

         $query = mysqli_query($conexion,"SELECT f.nofactura,f.numero,f.codprovedor,f.fecha,f.totalfactura,f.estatus, u.nombre as vendedor, u.apellido, p.nombre 
                                                    from factura_compra f 
                                                    INNER JOIN usuario u 
                                                    ON u.id_usuario = f.usuario 
                                                    INNER JOIN provedor p 
                                                    ON p.id_provedor = f.codprovedor
                                                    WHERE f.estatus != 10");
          $result = mysqli_num_rows($query);


           if ($result > 0) {
           
           

           while ($data = mysqli_fetch_assoc($query)) {


                       if ($data["estatus"] == 1){

                           $estado = '<span class="pagada">Pagada</span>';
                       }else{
                           $estado = '<span class="anulada">Anulada</span>';
                       }

					   if ($data["estatus"] == 1) {   
						$anul = '<a class="anular_factura" style="cursor: pointer;" onclick=anular_comp(f="'.$data['nofactura'].'") id="anular_factura" fac="'.$data['nofactura'].'" >
						<div class="ui small icon button" data-content="Anular"><i class="window red close icon"></i></div></a>';
						}else{
							$anul =' <div class="ui small icon button" data-content="Anular"><i class="window  grey close icon"></i></div></a>';
						}		


                        
                        
                        
				     $detalletabla .= '<tr>
					                      
					              		<td class="tx" id="nfct">'.$data['numero'].'</td>
					              		<td class="tx">'.$data['fecha'].'</td>
									    <td class="tx">'.$data['nombre'].'</td>
									    <td class="tx">'.$data['vendedor'].'</td>
									    <td class="tx">'.$estado.'</td>
					                    <td class="tx">$: '.number_format($data["totalfactura"]).'</td>
					                    <div class="div_acciones">
						                   <td class="div_factura">
										   <a class="" href="#" onclick=impr(cl="'.$data['codprovedor'].'",fac="'.$data['nofactura'].'") >
										   <div class="ui small icon button" data-content="Imprimir"><i class="print blue icon"></i></div></a>'.$anul.'					    
	                                       </td>
					                    </div>
				                      </tr>';

				              
                               
				                     
                             
                            
             }
             $arrayData['detalle'] = $detalletabla;
						 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
            

          }else{
          	echo'error';
          }  
           mysqli_close($conexion); exit;

	  	 }else{

			  	 $detalletabla = '';
		         $arrayData  = array();
		         $no = $_POST['nofactura'];
		         //print $no; exit;

		         $query = mysqli_query($conexion,"SELECT f.nofactura,f.numero,f.codprovedor,f.fecha,f.totalfactura,f.estatus, u.nombre as vendedor, u.apellido, p.nombre 
                                                    from factura_compra f 
                                                    INNER JOIN usuario u 
                                                    ON u.id_usuario = f.usuario 
                                                    INNER JOIN provedor p 
                                                    ON p.id_provedor = f.codprovedor
                                                    WHERE f.numero like '$no%'");
		          $result = mysqli_num_rows($query);


		           if ($result > 0) {
		           
		           

						           while ($data = mysqli_fetch_assoc($query)) {


						                       if ($data["estatus"] == 1){
						                           $estado = '<span class="pagada">Pagada</span>';
						                       }else{
						                           $estado = '<span class="anulada">Anulada</span>';
						                       }


						                        
												// if ($data["estatus"] == 1){
												// 	$anul = '<button class="anular_factura" onclick=anular_comp('.$data['nofactura'].') id="anular_cmp" fac="'.$data['nofactura'].'" ><i class="window big red close icon"></i></button>';
												// }else{
												// 		$anul = '<button><i class="window big red close icon"  ></i></button>';
												// 	}

												if ($data["estatus"] == 1) {   
													$anul = '<a class="anular_factura" style="cursor: pointer;" onclick=anular_comp(f="'.$data['nofactura'].'") id="anular_factura" fac="'.$data['nofactura'].'" >
													<div class="ui small icon button" data-content="Anular"><i class="window red close icon"></i></div></a>';
												}else{
													$anul =' <div class="ui small icon button" data-content="Anular"><i class="window  grey close icon"></i></div></a>';
												}			
						                        
						                        
										     $detalletabla .= '<tr>
											                      
																<td class="tx" id="nfct">'.$data['numero'].'</td>
																<td class="tx">'.$data['fecha'].'</td>
																<td class="tx">'.$data['nombre'].'</td>
																<td class="tx">'.$data['vendedor'].'</td>
																<td class="tx">'.$estado.'</td>
																<td class="tx">$: '.number_format($data["totalfactura"]).'</td>
																<div class="div_acciones">
																	<td class="div_factura">
																	<a class="" href="#" onclick=impr(cl="'.$data['codprovedor'].'",fac="'.$data['nofactura'].'") >
																	<div class="ui small icon button" data-content="Imprimir"><i class="print blue icon"></i></div></a>'.$anul.'					    
																	</td>
																</div>
										                       </tr>';

										              
						                               
										                     
						                             
						                            
						             }
						             $arrayData['detalle'] = $detalletabla;
												 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		            

		          }else{
		          	echo'error';
		          }  
		         mysqli_close($conexion);	exit;  	 	
			  	 	  
		              

			  	 	 
			 }


        
				      

         echo 'error';exit;
	  	 
      
	  } 
//fin

// buscar facturas por fecha
	if ($_POST['action'] == 'Buscarcompraf'){
	  	  $fecha_de = ($_POST['fecha_de']);
	  	  $fecha_a  = ($_POST['fecha_a']);


                if (empty($fecha_de) || empty($fecha_a)) {
                	
                   echo' selecione el rango de fechas';

                }else{

                     


                      
                 $detalletabla = '';
		         $arrayData  = array();
		         $no = $_POST['nofactura'];
		         //print $no; exit;

		         $query = mysqli_query($conexion,"SELECT f.nofactura,f.numero,f.codprovedor,f.fecha,f.totalfactura,f.estatus, u.nombre as vendedor, u.apellido, p.nombre 
                                                    from factura_compra f 
                                                    INNER JOIN usuario u 
                                                    ON u.id_usuario = f.usuario 
                                                    INNER JOIN provedor p 
                                                    ON p.id_provedor = f.codprovedor
                                                    WHERE f.fecha BETWEEN '$fecha_de' AND '$fecha_a' ");
		          $result = mysqli_num_rows($query);


		           if ($result > 0) {
		           
		           

						           while ($data = mysqli_fetch_assoc($query)) {


						                       if ($data["estatus"] == 1){
						                           $estado = '<span class="pagada">Pagada</span>';
						                       }else{
						                           $estado = '<span class="anulada">Anulada</span>';
						                       }


											   if ($data["estatus"] == 1) {   
												$anul = '<a class="anular_factura" style="cursor: pointer;" onclick=anular_comp(f="'.$data['nofactura'].'") id="anular_factura" fac="'.$data['nofactura'].'" >
												<div class="ui small icon button" data-content="Anular"><i class="window red close icon"></i></div></a>';
												}else{
													$anul =' <div class="ui small icon button" data-content="Anular"><i class="window  grey close icon"></i></div></a>';
												}			
												
						                        
						                        
										     $detalletabla .= '<tr>
											                      
																<td class="tx" id="nfct">'.$data['numero'].'</td>
																<td class="tx">'.$data['fecha'].'</td>
																<td class="tx">'.$data['nombre'].'</td>
																<td class="tx">'.$data['vendedor'].'</td>
																<td class="tx">'.$estado.'</td>
																<td class="tx">$: '.number_format($data["totalfactura"]).'</td>
																<div class="div_acciones">
																	<td class="div_factura">
																	<a class="" href="#" onclick=impr(cl="'.$data['codprovedor'].'",fac="'.$data['nofactura'].'") >
																	<div class="ui small icon button" data-content="Imprimir"><i class="print blue icon"></i></div></a>'.$anul.'					    
																	</td>
																</div>
										                       </tr>';

										              
						                             
										                     
						                             
						                            
						             }
						             $arrayData['detalle'] = $detalletabla;
									 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		            

		          }else{
		          	echo"error";
		          }
		         mysqli_close($conexion);exit;  	





                }
      


	  	  
	  	// code...
	  }
//fin

// buscar todos los provedores buscar lupa

if ($_POST['action'] == 'SeachProveedor'){

	
	
		$detalletabla = '';
	    $arrayData  = array();
  

		$query = mysqli_query($conexion,"SELECT * FROM provedor");
		$result = mysqli_num_rows($query);


		if ($result > 0) {

			while ($data = mysqli_fetch_assoc($query)) {

					$detalletabla .= '<tr>
					                    <td style="display: none;" class="tx">'.$data['id_provedor'].'</td>
										<td style="display: none;" class="tx">'.$data['nit'].'</td>
										<td class="tx">'.$data['nit'].'-'.$data['dg'].'</td>
										<td style="display: none;" class="tx">'.$data['dg'].'</td>
										<td class="tx">'.$data['nombre'].'</td>
										<td class="tx" >'.$data['direccion'].'</td>
										<td class="tx" >'.$data['telefono'].'</td>
									  </tr>';             
							
			}
			 $arrayData['detalle'] = $detalletabla;
			 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
			 mysqli_close($conexion); exit;
		
		}else{
	
			echo'error';
			exit;
		} 
	}		

//fin 

// buscar proveedor con filtro 

if ($_POST['action'] == 'BuscarProveedor'){
	$filtro = $_POST['filtro'];
	$buscar=$_POST['buscar'];
	
	if (empty($_POST['buscar'])){
		$detalletabla = '';
	    $arrayData  = array();
  

		$query = mysqli_query($conexion,"SELECT * FROM provedor");
		$result = mysqli_num_rows($query);


		if ($result > 0) {

			while ($data = mysqli_fetch_assoc($query)) {

					$detalletabla .= '<tr>
										
										<td class="tx">'.$data['nit'].'-'.$data['dg'].'</td>
										<td class="tx">'.$data['nombre'].'</td>
										<td class="tx" >'.$data['direccion'].'</td>
										<td class="tx" >'.$data['telefono'].'</td>
										<td><a style="cursor:pointer;" onclick=Validar_Edita_Proveedor(fac="'.$data['id_provedor'].'")>
										<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
										<a style="cursor:pointer;"  onclick=ValidarRemove(fac="'.$data['id_provedor'].'") >
										<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

									</tr>';             
							
			}
			 $arrayData['detalle'] = $detalletabla;
			 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
			 mysqli_close($conexion); exit;
		
		}else{
	
			echo'error';
			exit;
		} 
	

	}else{

		  if($_POST['filtro'] == 1){
			

				   $detalletabla = '';
				   $arrayData  = array();
				  

				   $query = mysqli_query($conexion,"SELECT * FROM provedor where nit like '$buscar%' or dg like '$buscar%'");
				   $result = mysqli_num_rows($query);


					if ($result > 0) {
			
					while ($data = mysqli_fetch_assoc($query)) {
			 
							  $detalletabla .= '<tr>
												   
													   
													<td class="tx">'.$data['nit'].'-'.$data['dg'].'</td>
													<td class="tx">'.$data['nombre'].'</td>
													<td class="center aligned tx" >'.$data['direccion'].'</td>
													<td class="center aligned tx" >'.$data['telefono'].'</td>
													<td><a style="cursor:pointer;" onclick=Validar_Edita_Proveedor(fac="'.$data['id_provedor'].'")>
													<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
													<a style="cursor:pointer;"  onclick=ValidarRemove(fac="'.$data['id_provedor'].'") >
													<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>


											    </tr>';             
									 
					  }
					    $arrayData['detalle'] = $detalletabla;
						echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
						mysqli_close($conexion); exit;
				   }else{

					   mysqli_close($conexion);
					   echo"error";exit;

				   }

		   }

		   elseif($_POST['filtro'] == 2){

				   $detalletabla = '';
				   $arrayData  = array();
				  
                                                 
				   $query = mysqli_query($conexion,"SELECT * FROM provedor  WHERE nombre LIKE '$buscar%'");
				   $result = mysqli_num_rows($query);                               


					if ($result > 0) {
			
					while ($data = mysqli_fetch_assoc($query)) {
			 
							  $detalletabla .= '<tr>
												   
												<td class="tx">'.$data['nit'].'-'.$data['dg'].'</td>
												<td class="tx">'.$data['nombre'].'</td>
												<td class="center aligned tx" >'.$data['direccion'].'</td>
												<td class="center aligned tx" >'.$data['telefono'].'</td>
												<td><a style="cursor:pointer;" onclick=Validar_Edita_Proveedor(fac="'.$data['id_provedor'].'")>
												<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
												<a style="cursor:pointer;"  onclick=ValidarRemove(fac="'.$data['id_provedor'].'") >
												<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

											    </tr>';             
									 
					  }
								  $arrayData['detalle'] = $detalletabla;
								  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
								  mysqli_close($conexion); exit;
					}else{

					   mysqli_close($conexion);
					   echo "error";exit; 
					}
					



		  }


				
   
	  }


 
			   

 echo 'error';exit;
	
}

//fin

// Eliminar provedor 
if($_POST['action'] == 'RemoveCliente'){

	$id= $_POST['Proveedor'];

	$sql="DELETE FROM provedor  WHERE id_provedor='$id'";
	
	 if(mysqli_query($conexion,$sql)){

		mysqli_close($conexion);

	 }else{

        mysqli_close($conexion);
	    echo "Error: ".$sql."<br>".mysqli_error($conexion);
		exit;

	 }

}
// fin

//Buscar Cliente id
if($_POST['action'] == 'GetProveedor')
{
  
		  if (!empty($_POST['cliente'])){
			$id = $_POST['cliente'];

			$query = mysqli_query($conexion,"SELECT * FROM provedor  WHERE id_provedor = $id");

			mysqli_close($conexion);
			$result = mysqli_num_rows($query);

			$data = '';
			 
			if($result > 0){
			   $data = mysqli_fetch_assoc($query);
			   
			}else{
				$data= 0;
			}
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
			
		   }
		  exit;
}
//fin

 ?>