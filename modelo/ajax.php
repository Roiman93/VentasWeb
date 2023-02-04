<?php 

  include '../modelo/conexion.php';


//Buscar Cliente
if($_POST['action'] == 'searchCliente')
{
	
			if (!empty($_POST['cliente'])){
			$cc = $_POST['cliente'];

			$query = mysqli_query($conexion,"SELECT * FROM cliente c WHERE c.cedula = $cc");

			mysqli_close($conexion);
			$result = mysqli_num_rows($query);

			$data = '';
				
			if($result > 0){
				$data = mysqli_fetch_assoc($query);
				//print_r($data);
			}else{
				$data= 0;
			}
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
			exit;
}
//fin

 //Buscar Cliente id
 if($_POST['action'] == 'GetCliente')
 {
   
		   if (!empty($_POST['cliente'])){
			 $id = $_POST['cliente'];

			 $query = mysqli_query($conexion,"SELECT * FROM cliente c WHERE c.id_cliente = $id");

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



// buscar cliente con filtro 

if ($_POST['action'] == 'BuscarCliente'){
	$filtro = $_POST['filtro'];
	$buscar=$_POST['buscar'];
	
	if (empty($_POST['buscar'])){
		$detalletabla = '';
	    $arrayData  = array();
		$arrayhdr  = array();
  
   // Generar un nombre de archivo de salida
   $nombre_archivo="datos.csv";

   // Abrir el archivo en modo de escritura
   $fp= fopen($nombre_archivo, 'w');

   $query = mysqli_query($conexion,"SELECT * FROM cliente");
   $qr = mysqli_query($conexion,"select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA='ventas_ms' and TABLE_NAME='cliente'");
   $result = mysqli_num_rows($query);
   
   

	if ($result > 0) {

		while ($hdr =  mysqli_fetch_row($qr)) {
			$header[] = $hdr[0];
		   }fputcsv($fp, $header);

       
    
		while ($data = mysqli_fetch_assoc($query)) {
			
		
			fputcsv($fp, $data);
			
				$detalletabla .= '<tr>
									
									<td class="tx">'.$data['cedula'].'</td>
									<td class="tx">'.$data['nombre_1'].' '.$data['nombre_2'].'</td>
									<td class="tx">'.$data['apellido_1'].' '.$data['apellido_2'].'</td>
									<td class="tx">'.$data['fecha'].'</td>
									<td><a style="cursor:pointer;" onclick=Validar_Edita_Cliente(fac="'.$data['id_cliente'].'")>
									<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
									<a style="cursor:pointer;"  onclick=ValidarRemove(fac="'.$data['id_cliente'].'") >
									<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

								</tr>';             
						
		} fclose($fp);
	              $arrayData['detalle'] = $detalletabla;
				  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				    $srcfile='datos.csv';
					$dstfile='Py/datos.csv';
					//mkdir(dirname($dstfile), 0777, true);
					if (!copy($srcfile, $dstfile))
					{
						echo "Error al copiar $srcfile...\n";

					}else{

					
					
						
						 echo shell_exec('python ');

						

					}
					
                 
				    
				
	 
   } 
	mysqli_close($conexion); exit;

        if(file_exists($nombre_archivo)) 
			{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($nombre_archivo));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($nombre_archivo));
			ob_clean();
			flush();
			readfile($nombre_archivo);
			exit;
			}

	}else{

		  if($_POST['filtro'] == 1){
			

				   $detalletabla = '';
				   $arrayData  = array();
				  

				   $query = mysqli_query($conexion,"SELECT * FROM cliente c where c.cedula LIKE'$buscar%'");
				   $result = mysqli_num_rows($query);


					if ($result > 0) {
			
					while ($data = mysqli_fetch_assoc($query)) {
			 
							  $detalletabla .= '<tr>
												   
													<td class="tx">'.$data['cedula'].'</td>
													<td class="tx">'.$data['nombre_1'].' '.$data['nombre_2'].'</td>
													<td class="tx">'.$data['apellido_1'].' '.$data['apellido_2'].'</td>
													<td class="tx">'.$data['fecha'].'</td>
													<td><a style="cursor:pointer;" onclick=Validar_Edita_Cliente(fac="'.$data['id_cliente'].'")>
													<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
													<a style="cursor:pointer;"  onclick=ValidarRemove(fac="'.$data['id_cliente'].'") >
													<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

											    </tr>';             
									 
					  }
					  $arrayData['detalle'] = $detalletabla;
								  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
						mysqli_close($conexion); exit;
				   }else{
					   echo "error";exit;
				   }

		   }

		   elseif($_POST['filtro'] == 2){

				   $detalletabla = '';
				   $arrayData  = array();
				  
                                                 
				   $query = mysqli_query($conexion,"SELECT * FROM cliente c WHERE c.nombre_1 LIKE '$buscar%' OR c.nombre_2 LIKE'$buscar%'");
				   $result = mysqli_num_rows($query);                               


					if ($result > 0) {
			
					while ($data = mysqli_fetch_assoc($query)) {
			 
							  $detalletabla .= '<tr>
												   
													<td class="tx">'.$data['cedula'].'</td>
													<td class="tx">'.$data['nombre_1'].' '.$data['nombre_2'].'</td>
													<td class="tx">'.$data['apellido_1'].' '.$data['apellido_2'].'</td>
													<td class="tx">'.$data['fecha'].'</td>
													<td><a style="cursor:pointer;" onclick=Validar_Edita_Cliente(fac="'.$data['id_cliente'].'")>
													<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
													<a style="cursor:pointer;"  onclick=ValidarRemove(fac="'.$data['id_cliente'].'") >
													<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

											    </tr>';             
									 
					  }
								  $arrayData['detalle'] = $detalletabla;
								  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
								  mysqli_close($conexion); exit;
					}else{
					   echo "error";exit; }
					



		  }


				
   
	  }


 
			   

echo 'error';exit;
	

}

//fin

// Eliminar cliente 
if($_POST['action'] == 'RemoveCliente'){

	$id= $_POST['Cliente'];

	$sql="DELETE FROM cliente  WHERE id_cliente='$id'";
	
	 if(mysqli_query($conexion,$sql)){

		mysqli_close($conexion);

	 }else{

        mysqli_close($conexion);
	    echo "Error: ".$sql."<br>".mysqli_error($conexion);
		exit;

	 }

}
// fin

//Registrar Proveedor
	if($_POST['action'] == 'AddProveedor')
	{
		// print_r($_POST);
		$nit = $_POST['nit'];
		$dg = $_POST['dg'];
		$nombre = $_POST['nombre'];
		$direccion = $_POST['direccion'];
		$telefono = $_POST['telefono'];


	    $sql1=" Call Sp_Agregar_Proveedor('$nit','$dg','$nombre','$direccion','$telefono')";
        $query = mysqli_query($conexion,$sql1);
	    $result= mysqli_num_rows($query);


		if ($result > 0 ) {

			$data = mysqli_fetch_assoc($query);

            if(isset($data['error']) ){
               
				
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
				mysqli_close($conexion);
			exit;

			}else{
				
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
				mysqli_close($conexion);
			exit;

			}


			// 
			
		} else {
             
			mysqli_close($conexion);
			exit;

		}
	

	exit;		 
	}
//fin



//Modificar Proveedor
if($_POST['action'] == 'UpdateProveedor')
{
	// print_r($_POST);
	$id = $_POST['id'];
	$nit = $_POST['nit'];
	$dg = $_POST['dg'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];

	 $sql=" UPDATE  provedor SET nombre='$nombre', direccion='$direccion', telefono='$telefono', nit='$nit', dg='$dg' WHERE id_provedor='$id' ";


	if (mysqli_query($conexion,$sql)) {
		//echo "Datos Actualizados..";
		mysqli_close($conexion);
		exit;

	  } else {
		mysqli_close($conexion);

		 echo "Error:".$sql."".mysqli_error($conexion);
		exit;

	  }
 

  exit;		 
}
//fin

 //Buscar provedor nit
	if($_POST['action'] == 'searchProvedor'){
	  
			  if (!empty($_POST['provedor'])){
			    $cc = $_POST['provedor'];

				$query = mysqli_query($conexion,"SELECT * FROM provedor p WHERE p.nit = $cc");

				mysqli_close($conexion);
				$result = mysqli_num_rows($query);

				$data = '';
				 
				if($result > 0){
		           $data = mysqli_fetch_assoc($query);
				   //print_r($data);
			    }else{
					$data= 0;
				}
		        echo json_encode($data,JSON_UNESCAPED_UNICODE);
			   }
		      exit;
	}


//Registrar Cliente - ventas
	if($_POST['action'] == 'addCliente')
		{
			$cc = $_POST['cedula'];
			$nombre = $_POST['nombre1'];
			$nombre2 = $_POST['nombre2'];
			$apellido = $_POST['apellido1'];
			$apellido2 = $_POST['apellido2'];
            

			$sql1=" CALL Sp_Agregar_Nuevo_Ciente('$cc','$nombre','$nombre2','$apellido','$apellido2')";
			
			if (mysqli_query($conexion,$sql1)) {
				//echo "Datos Guardados..";
				mysqli_close($conexion);
				exit;

			} else {
				echo "Error: ". mysqli_error($conexion);
				mysqli_close($conexion);
				exit;

			}		 
		
		  exit;		 
		}
//fin

//Modificar Cliente 
	if($_POST['action'] == 'updateCliente')
		{
			// print_r($_POST);
			$id = $_POST['id_cliente'];
			$cc = $_POST['cedula'];
			$nombre = $_POST['nombre1'];
			$nombre2 = $_POST['nombre2'];
			$apellido = $_POST['apellido1'];
			$apellido2 = $_POST['apellido2'];

			$sql="UPDATE  cliente SET cedula='$cc', nombre_1 ='$nombre',nombre_2='$nombre2', apellido_1='$apellido', apellido_2='$apellido2' 
				WHERE id_cliente='$id'";


			if (mysqli_query($conexion,$sql)) {
				//echo "Datos Actualizados..";
				mysqli_close($conexion);
				exit;

			} else {
				mysqli_close($conexion);
				echo "Error: ". mysqli_error($conexion);
				exit;

			}
		

		exit;		 
		}		
//fin


 // buscar producto existencias
	  if($_POST['action'] == 'infoProducto'){

	  	  $prod = $_POST['producto'];

				$query = mysqli_query($conexion,"SELECT * FROM inventario v WHERE v.codigo = $prod");
				
				$result = mysqli_num_rows($query);
				if($result > 0){
		           $data = mysqli_fetch_assoc($query);
		           echo json_encode($data,JSON_UNESCAPED_UNICODE);
				   mysqli_close($conexion);exit();
			    }else {
				   echo "error";
				   exit;
				}
            
	  }
 // fin	  

    // agregar producto a detalle temporal
	  if($_POST['action'] == 'addProductoDetalle'){
	  	
	  	if (empty($_POST['producto']) || empty($_POST['cantidad'])){
	  		       echo "error";
	  	}else{
					  		$codproducto = $_POST['producto'];
					  		$cantidad = $_POST['cantidad'];
					  		$token = $_POST['token'];
				       
				       $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				       $result_iva = mysqli_num_rows($query_iva);
				           

				       $query_detalle_temp = mysqli_query($conexion,"CALL add_detalle_temp($codproducto,$cantidad,'$token')");
				       $result = mysqli_num_rows($query_detalle_temp);
				       
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
					       	 while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
								
					            
					            $detalletabla .= '<tr>
															          <td class="textcenter tx">'.$data['codproducto'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
																	      </tr>
																	      <tr>
																	        <td colspan="5" class="right aligned tx"><p>TOTAL $:</p></td>
																	        <td class="right aligned tx "><p>'.$tlt.'</p></td>
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


	  // extraer datos del detalle temp
     
	  if ($_POST['action'] == 'serchForDetalle'){
	  	  
	  	 if (empty($_POST['user']))
	  	 {
	  	 	 echo "error";
	  	 }else{
	  	 	  $token = $_POST['user'];
	  	 	  $query = mysqli_query($conexion,"SELECT tmp.correlativo,
	  	 	  	                                      tmp.token_user,
	  	 	  	                                      tmp.cantidad,
	  	 	  	                                      tmp.precio_venta,
	  	 	  	                                      p.codigo,
	  	 	  	                                      p.nombre
	  	 	  	                                      FROM detalle_temp tmp
	  	 	  	                                      INNER JOIN producto p
	  	 	  	                                      ON tmp.codproducto = p.codigo
	  	 	  	                                      WHERE token_user = '$token' AND mesa = 0");


	  	 	  $result = mysqli_num_rows($query);
          
          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				  $result_iva = mysqli_num_rows($query_iva);
           
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
					       	 while ($data = mysqli_fetch_assoc($query)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
					             
					            $detalletabla .= '<tr>
															          <td class="textcenter tx">'.$data['codigo'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
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
	  } //fin


	   // eliminar datos del detalle temp

	  if ($_POST['action'] == 'delProductoDetalle'){
       
       if (empty($_POST['id_detalle']))
	  	 {
	  	 	 echo "error";
	  	 }else{

	  	 	  $id_detalle = $_POST['id_detalle'];
	  	 	  $token = $_POST['token'];
	  	 	   
          
          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				  $result_iva = mysqli_num_rows($query_iva);

				  $query_detalle_temp = mysqli_query($conexion,"CALL del_detalle_temp($id_detalle,'$token')");
				  $result = mysqli_num_rows($query_detalle_temp);
           
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
					       	 while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
					             
					            $detalletabla .= '<tr>
															          <td class="textcenter tx">'.$data['codproducto'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
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
	   	 
	  }
//fin


       // cancelar venta

    
	  if ($_POST['action'] == 'anularVenta')
	  {
		  $token = $_POST['token'];
		  $query_del = mysqli_query($conexion,"DELETE  FROM detalle_temp   WHERE token_user = '$token'");
		  mysqli_close($conexion);
		  if ($query_del){
				echo "ok";
		  }
		 exit;
	  }
	  //fin


    // procesar venta
    if ($_POST['action'] == 'procesarVenta')
	  { 
			 //print_r($_POST);exit;
					if(empty($_POST['codcliente'])){
					    $codcliente= 1;
					}else{
						  $codcliente = $_POST['codcliente'];
					}

				 $token = $_POST['token']; 
				 $usuario = $_POST['usuario'];
				 $query = mysqli_query($conexion,"SELECT * FROM detalle_temp WHERE token_user = '$token'");
				 $result = mysqli_num_rows($query);

	          if($result > 0)
			      {
	            $query_procesar = mysqli_query($conexion,"CALL procesar_venta($usuario,$codcliente,'$token')");
				      $resul = mysqli_num_rows($query_procesar);

	             if ($resul > 0)
							 {
									$data = mysqli_fetch_assoc($query_procesar);
									echo json_encode($data,JSON_UNESCAPED_UNICODE);
								}else{
											  echo "error";
								}

			  }else{
				  echo " no hay registros";
			  }
			  mysqli_close($conexion);exit; 
	  }
   // fin 

   // procesar Mesa
   if ($_POST['action'] == 'ProcesarMesa')
   { 
		  //print_r($_POST);exit;
				 if(empty($_POST['codcliente'])){
					 $codcliente= 1;
				 }else{
					 $codcliente = $_POST['codcliente'];
				 }

			  $token = $_POST['token']; 
			  $usuario = $_POST['usuario'];
			  $mesa = $_POST['mesa'];
			  $query = mysqli_query($conexion,"SELECT * FROM detalle_temp WHERE token_user = '$token'");
			  $result = mysqli_num_rows($query);

		   if($result > 0){

			 $query_procesar = mysqli_query($conexion,"CALL Sp_Procesar_Mesa($usuario,$codcliente,'$token','$mesa')");
			 $resul = mysqli_num_rows($query_procesar);

			  if ($resul > 0){

								 $data = mysqli_fetch_assoc($query_procesar);
								 

								 if (in_array('error',$data)){

									echo"error_01";
									
									mysqli_close($conexion);exit;

								 }else{
                              
								   echo json_encode($data,JSON_UNESCAPED_UNICODE);
								   mysqli_close($conexion);exit; 

								 }

								

							 }else{

								 echo "error";
								 mysqli_close($conexion);exit; 

							 }

		   }else{
			   echo " no  hay respuesta";
		   }
		   mysqli_close($conexion);exit; 
   }
// fin 


 // cancelar Mesa
 if ($_POST['action'] == 'AnularMensa')
 {
	 $token =  $_POST['token'];
	 $mesa  =  $_POST['mesa'];
	// $sql1  =  "DELETE  FROM detalle_temp  WHERE token_user = '$token' AND mesa = '$mesa";
	 $sql   =  "DELETE FROM detalle_temp WHERE token_user = '$token' AND mesa = '$mesa'";
	 
	 if (mysqli_query($conexion,$sql)){
		   mysqli_close($conexion);
		   exit;
	 }else{
		echo "Error: " . $sql1 . " <br>" . mysqli_error($conexion);
		exit;

	}
	exit;
 }
 //fin

  
  // anular facturas 
	  if ($_POST['action'] == 'infoFactura'){

	      
	      if( empty($_POST['nofactur'])) {

           echo 'selecione una factura';

        }else{

               $no = $_POST['nofactur']; 
               $query_anular = mysqli_query($conexion,"CALL anular_factura('$no')");
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


// Buscar facturas
if ($_POST['action'] == 'BuscarFactura'){
	  	 
		//print_r ($_POST); exit;
		if (empty($_POST['nofactura'])){
			 $detalletabla = '';
	  $arrayData  = array();
	  

	  $query = mysqli_query($conexion,"SELECT f.codcliente,f.nofactura,f.prefijo,f.numero,f.fecha,f.totalfactura,f.estatus, u.nombre as vendedor, u.apellido, c.nombre_1 as cliente,
												 c.nombre_2, c.apellido_1,c.apellido_2  
												 from factura f 
												 INNER JOIN usuario u 
												 ON u.id_usuario = f.usuario 
												 INNER JOIN cliente c 
												 ON c.id_cliente = f.codcliente
												 WHERE f.estatus != 10");
	   $result = mysqli_num_rows($query);


		if ($result > 0) {
		
		

		while ($data = mysqli_fetch_assoc($query)) {


					if ($data["estatus"] == 1){
						$estado = '<span class="pagada">Pagada</span>';
					}else{
						$estado = '<span class="anulada">Anulada</span>';
					}

					if ($data["estatus"] == 1)
					{   $anul = '<a class="anular_factura" style="cursor: pointer;" onclick=anular_vent(f="'.$data['nofactura'].'") 
						id="anular_factura" fac="'.$data['nofactura'].'" >
						<div class="ui small icon button" data-content="Anular"><i class="window red close icon"></i></div></a>';
					}else{
							//$anul = '<a><i class="window big  grey close icon"  ></i></a>';
							$anul =' <div class="ui small icon button" data-content="Anular"><i class="window  grey close icon"></i></div></a>';
						 }


					 
					 
					 
				  $detalletabla .= '<tr>
									   
									 <td class="tx" id="nfct">'.$data['prefijo'].''.$data['numero'].'</td>
									 <td class="tx" >'.$data['fecha'].'</td>
									 <td class="tx" >'.$data['cliente'].'</td>
									 <td class="tx" >'.$data['vendedor'].'</td>
									 <td class="tx">'.$estado.'</td>
									 <td class="tx">$: '.number_format($data["totalfactura"]).'</td>
									 <div class="div_acciones">
										<td class="div_factura">
										<a class="view_facturas" id="view_facturas"  onclick=impr(cl="'.$data['codcliente'].'",fac="'.$data['nofactura'].'") >
										<div class="ui small icon button" data-content="Imprimir"><i class="print blue icon"></i></div></a>'.$anul.'			 
										</td>
									 </div>
								   </tr>';

								 
								   
						   
							
								  
						  
						 
		  }
		  $arrayData['detalle'] = $detalletabla;
					  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		 

	   }  
		mysqli_close($conexion); exit;

		}else{

			  $detalletabla = '';
			  $arrayData  = array();
			  $no = $_POST['nofactura'];
			  //print $no; exit;

			  $query = mysqli_query($conexion,"SELECT f.codcliente,f.nofactura,f.prefijo,f.numero,f.fecha,f.totalfactura,f.estatus, u.nombre as vendedor, u.apellido, c.nombre_1 as cliente,
														 c.nombre_2, c.apellido_1,c.apellido_2  
														 from factura f 
														 INNER JOIN usuario u 
														 ON u.id_usuario = f.usuario 
														 INNER JOIN cliente c 
														 ON c.id_cliente = f.codcliente
														 WHERE f.prefijo like '$no%' or f.numero like '$no%'");
			   $result = mysqli_num_rows($query);


				if ($result > 0) {
				
				

								while ($data = mysqli_fetch_assoc($query)) {


											if ($data["estatus"] == 1){
												$estado = '<span class="pagada">Pagada</span>';
											}else{
												$estado = '<span class="anulada">Anulada</span>';
											}


											 
											if ($data["estatus"] == 1)
											{   $anul = '<a class="anular_factura" style="cursor: pointer;" onclick=anular_vent(f="'.$data['nofactura'].'") 
												id="anular_factura" fac="'.$data['nofactura'].'" >
												<div class="ui small icon button" data-content="Anular"><i class="window red close icon"></i></div></a>';
											}else{
													//$anul = '<a><i class="window big  grey close icon"  ></i></a>';
													$anul =' <div class="ui small icon button" data-content="Anular"><i class="window  grey close icon"></i></div></a>';
												 }
						
						
											 
										  $detalletabla .= '<tr>
															   
															<td class="tx" id="nfct">'.$data['prefijo'].''.$data['numero'].'</td>
															<td class="tx">'.$data['fecha'].'</td>
															<td class="tx">'.$data['cliente'].'</td>
															<td class="tx" >'.$data['vendedor'].'</td>
															<td class="tx" >'.$estado.'</td>
															<td>$: '.number_format($data["totalfactura"]).'</td>
															<div class="div_acciones">
																<td class="div_factura">
																<a class="view_facturas" id="view_facturas"  onclick=impr(cl="'.$data['codcliente'].'",fac="'.$data['nofactura'].'") >
																<div class="ui small icon button" data-content="Imprimir"><i class="print blue icon"></i></div></a>'.$anul.'			 
																</td>
															</div>
															</tr>';

												   
													
														  
												  
												 
								  }
								  $arrayData['detalle'] = $detalletabla;
											  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				 

			   }  
			  mysqli_close($conexion);	exit;  	 	
					  
				   

					 
					 }


	 
				   

   echo 'error';exit;
		
   
   } 
//fin




// buscar facturas por fecha
if ($_POST['action'] == 'BuscarFactura_fecha'){
	$fecha_de = ($_POST['fecha_de']);
	$fecha_a  = ($_POST['fecha_a']);
	$no = $_POST['nofactura'];

	


		if (empty($fecha_de) || empty($fecha_a)) {
			
		   echo' selecione el rango de fechas';

		}else{

			 


			  
		 $detalletabla = '';
		 $arrayData  = array();
		 $no = $_POST['nofactura'];
		 //print $no; exit;

		 $query = mysqli_query($conexion,"SELECT f.codcliente,f.nofactura,f.prefijo,f.numero,f.fecha,f.totalfactura,f.estatus, u.nombre as vendedor, u.apellido, c.nombre_1 as cliente,
													c.nombre_2, c.apellido_1,c.apellido_2  
													from factura f 
													INNER JOIN usuario u 
													ON u.id_usuario = f.usuario 
													INNER JOIN cliente c 
													ON c.id_cliente = f.codcliente
												   WHERE f.fecha BETWEEN '$fecha_de' AND '$fecha_a'");
		  $result = mysqli_num_rows($query);


		   if ($result > 0) {
		   
		   

						   while ($data = mysqli_fetch_assoc($query)) {


									   if ($data["estatus"] == 1){
										   $estado = '<span class="pagada">Pagada</span>';
									   }else{
										   $estado = '<span class="anulada">Anulada</span>';
									   }


									   
									   if ($data["estatus"] == 1)
									   {   $anul = '<a class="anular_factura" style="cursor: pointer;" onclick=anular_vent(f="'.$data['nofactura'].'") 
										   id="anular_factura" fac="'.$data['nofactura'].'" >
										   <div class="ui small icon button" data-content="Anular"><i class="window red close icon"></i></div></a>';
									   }else{
											   //$anul = '<a><i class="window big  grey close icon"  ></i></a>';
											   $anul =' <div class="ui small icon button" data-content="Anular"><i class="window  grey close icon"></i></div></a>';
											}
										
									 $detalletabla .= '<tr>
														<td class="tx" id="nfct">'.$data['prefijo'].''.$data['numero'].'</td>
														<td class="tx">'.$data['fecha'].'</td>
														<td class="tx">'.$data['cliente'].'</td>
														<td class="tx">'.$data['vendedor'].'</td>
														<td class="tx">'.$estado.'</td>
														<td>$: '.number_format($data["totalfactura"]).'</td>
														<div class="div_acciones">
															<td class="div_factura">
															<a class="view_facturas" id="view_facturas"  onclick=impr(cl="'.$data['codcliente'].'",fac="'.$data['nofactura'].'") >
															<div class="ui small icon button" data-content="Imprimir"><i class="print blue icon"></i></div></a>'.$anul.'			 
															</td>
														</div>
													   </tr>';

											  
											 
													 
											 
											
							 }
							 $arrayData['detalle'] = $detalletabla;
							 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
			

		  }  
		 mysqli_close($conexion);exit;  	





		}



	
  // code...
}//fin
      

// buscar facturas cuadre fecha
	  if ($_POST['action'] == 'CuadreFecha'){
	  	  $fecha = ($_POST['fecha']);
		  $usuario=($_POST['usuario']);
	  	  

                if (empty($fecha)) {
                	
                   echo' selecione una fecha'; exit;
                   

                }else{
			         
					
					$sql="SELECT IFNULL(SUM(F.totalfactura),0) AS total
					FROM factura f WHERE f.usuario = '$usuario' AND f.estatus != '2' AND 
					Date(`fecha`) =  '$fecha' AND Time(`fecha`) <='24:59:54.000'";

					$query = mysqli_query($conexion,$sql);

					$result = mysqli_num_rows($query);

					$data = '';
					 
					if($result > 0){

			           $data = mysqli_fetch_assoc($query);
			           echo json_encode($data,JSON_UNESCAPED_UNICODE);
					   mysqli_close($conexion);exit;
			           
				    }else{ 
						mysqli_close($conexion);exit;
					}
			        
			           


                }
      


	  	 
	  
	  }//fin
//////////////////////////////////////////mesas///////////////////////////////////////////////////////////////////////

 // agregar producto a detalle temporal _ mesas 
	  if($_POST['action'] == 'addProductoMesa'){
	  	
	  	if (empty($_POST['producto']) || empty($_POST['cantidad'])){
	  		       echo "error";
	  	}else{
	  		          //print_r($_POST['mesa']);exit;           
					  		$codproducto = $_POST['producto'];
					  		$cantidad = $_POST['cantidad'];
					  		$token = $_POST['token'];
					  		$mesa = $_POST['mesa'];
				       
				       $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				       $result_iva = mysqli_num_rows($query_iva);
				           

				       $query_detalle_temp = mysqli_query($conexion,"CALL add_detalle_temp_mesa($codproducto,$cantidad,'$token','$mesa')");
				       $result = mysqli_num_rows($query_detalle_temp);
				       
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
					       	 while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 

					            
					            $detalletabla .= '<tr>                
					                                                  <td class="textcenter tx">'.$data['mesa'].'</td>
															          <td class="textcenter tx">'.$data['codproducto'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="del_producto_detalle('.$data['correlativo'].'); " ><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
																	      </tr>
																	      <tr>
																	        <td colspan="5" class="right aligned tx"><p>TOTAL $:</p></td>
																	        <td class="right aligned tx "><p>'.$tlt.'</p></td>
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
			  	 	 echo " id correlativo vacio";

			  	  }else{

			  	 	  $id_detalle = $_POST['id_detalle'];
			  	 	  $token = $_POST['token'];
			  	 	  $mesa = $_POST['mesa'];
			  	 	  


			  	 	   $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				       $result_iva = mysqli_num_rows($query_iva);

						  $query_detalle = mysqli_query($conexion,"CALL del_detalle_temp_mesa('$id_detalle','$token',$mesa)");
						  $result = mysqli_num_rows($query_detalle);
           
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
					       	 while ($data = mysqli_fetch_assoc($query_detalle)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
					             
					            $detalletabla .= '<tr>                
					                                                  <td class="textcenter tx">'.$data['mesa'].'</td>
															          <td class="textcenter tx">'.$data['codproducto'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
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
				}       mysqli_close($conexion);
	   	 
	  }
   //fin



    // extraer datos del detalle temp
      
	  if ($_POST['action'] == 'Detalletmp'){
	  	  
	  	 if (empty($_POST['user']))
	  	 {
	  	 	 echo "usuario vacio";
	  	 }else{

	  	 	//print_r($_POST['action']);exit;
	  	 	  $token = $_POST['user'];
	  	 	  $mesa = $_POST['mesa'];
	  	 	  $query = mysqli_query($conexion,"SELECT tmp.mesa,
	  	 	  	                                      tmp.correlativo,
	  	 	  	                                      tmp.token_user,
	  	 	  	                                      tmp.cantidad,
	  	 	  	                                      tmp.precio_venta,
	  	 	  	                                      p.codigo,
	  	 	  	                                      p.nombre
	  	 	  	                                      FROM detalle_temp tmp
	  	 	  	                                      INNER JOIN producto p
	  	 	  	                                      ON tmp.codproducto = p.codigo
	  	 	  	                                      WHERE token_user = '$token' AND mesa = '$mesa'");


	  	 	  $result = mysqli_num_rows($query);
          
          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				  $result_iva = mysqli_num_rows($query_iva);
           
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
					       	 while ($data = mysqli_fetch_assoc($query)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
					             
					            $detalletabla .= '<tr>                  
					                                                  <td class="textcenter tx">'.$data['mesa'].'</td>
															          <td class="textcenter tx">'.$data['codigo'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
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
	  } //fin

  
  // anular Mesa
	  
    
	  if ($_POST['action'] == 'anularMesa')
         {      
           
		  $token = $_POST['token'];
		  $mesa = $_POST['mesa'];

		  $query_del = mysqli_query($conexion,"DELETE FROM detalle_temp  WHERE token_user = '$token' AND mesa = '$mesa'");
		  mysqli_close($conexion);

		  if ($query_del){
				echo "ok";
		  }
		 exit;
	  }
	  //fin


	 // buscar mesas 
      
	  if ($_POST['action'] == 'bucarMesa'){
	  	  
	  	 if (empty($_POST['mesa']))
	  	 {
	  	 	 echo " mesa vacia";
	  	 }else{

	  	 	//print_r($_POST['action']);exit;
	  	 	 $token = $_POST['token'];
		     $mesa = $_POST['mesa'];
	  	 	  $query = mysqli_query($conexion,"SELECT tmp.mesa,
	  	 	  	                                      tmp.correlativo,
	  	 	  	                                      tmp.token_user,
	  	 	  	                                      tmp.cantidad,
	  	 	  	                                      tmp.precio_venta,
	  	 	  	                                      p.codigo,
	  	 	  	                                      p.nombre
	  	 	  	                                      FROM detalle_temp tmp
	  	 	  	                                      INNER JOIN producto p
	  	 	  	                                      ON tmp.codproducto = p.codigo
	  	 	  	                                      WHERE token_user = '$token' AND mesa = '$mesa'");


	  	 	  $result = mysqli_num_rows($query);
          
          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
				  $result_iva = mysqli_num_rows($query_iva);
           
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
					       	 while ($data = mysqli_fetch_assoc($query)) {
					            
					            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
					            $sub_total   = round($sub_total + $precioTotal, 2);
					            $total       = round($total + $precioTotal, 2); 
					             
					            $detalletabla .= '<tr>                  
					                                                  <td class="textcenter tx">'.$data['mesa'].'</td>
															          <td class="textcenter tx">'.$data['codigo'].'</td>
															          <td class="tx" colspan="2" >'.$data['nombre'].'</td>
															          <td class="center aligned tx">'.$data['cantidad'].'</td>
															          <td class="right aligned tx">'.$data['precio_venta'].'</td>
															          <td class="right aligned tx">'.$precioTotal.'</td>
															          <td class="">
															            <a class="link_delete" href="#" onclick="event.preventDefault();
															            del_producto_detalle('.$data['correlativo'].');"><i class="trash alternate icon"></i></a>
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
																	        <td class="right aligned tx">'.$inpto .'</td>
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
	  } //fin


/////////////////consultas inventario /////////////////////////////////////////////////
	   // Buscar facturas

	  if ($_POST['action'] == 'Buscarinvent'){
	  	 $filtro = $_POST['filtro'];
	  	 $buscar=$_POST['buscar'];
	  	 //print_r ($_POST); exit;
	  	 if (empty($_POST['buscar'])){
	  	 	 $detalletabla = '';
             $arrayData  = array();
         

          $query = mysqli_query($conexion,"SELECT * FROM inventario");
          $result = mysqli_num_rows($query);


           if ($result > 0) {
   
           while ($data = mysqli_fetch_assoc($query)) {
    
				     $detalletabla .= '<tr>
					                      
					              		<td class="tx">'.$data['codigo'].'</td>
					              		<td class="tx">'.$data['nombre'].'</td>
									    <td class="tx">$: '.number_format($data['precio_venta']).'</td>
									    <td class="center aligned tx" >'.$data['entradas'].'</td>
					                    <td class="center aligned tx" >'.$data["salidas"].'</td>
					                    <td class="center aligned tx" >'.$data["stock"].'</td>

				                       </tr>';             
                            
             }
                $arrayData['detalle'] = $detalletabla;
			    echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				mysqli_close($conexion); exit;
            
          }else {
            echo "error";
            mysqli_close($conexion); exit;

		  }
           

	  	 }else{

                 if($_POST['filtro'] == 1){
                   

                          $detalletabla = '';
				          $arrayData  = array();
				         

				          $query = mysqli_query($conexion,"SELECT * FROM inventario where codigo = '$buscar'");
				          $result = mysqli_num_rows($query);


				           if ($result > 0) {
				   
				           while ($data = mysqli_fetch_assoc($query)) {
				    
								     $detalletabla .= '<tr>
									                      
									              		<td class="tx">'.$data['codigo'].'</td>
									              		<td class="tx">'.$data['nombre'].'</td>
													    <td class="tx">$: '.$data['precio_venta'].'</td>
													    <td class="tx">'.$data['entradas'].'</td>
									                    <td class="tx">'.$data["salidas"].'</td>
									                    <td class="tx">'.$data["stock"].'</td>

								                      </tr>';             
				                            
				             }
				             $arrayData['detalle'] = $detalletabla;
										 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				               mysqli_close($conexion); exit;
				          }else {
							echo "error";
							mysqli_close($conexion); exit;
						  }

                  }

                  elseif($_POST['filtro'] == 2){

                          $detalletabla = '';
				          $arrayData  = array();
				         

				          $query = mysqli_query($conexion,"SELECT * FROM `inventario` WHERE nombre LIKE '$buscar%'");
				          $result = mysqli_num_rows($query);                               


				           if ($result > 0) {
				   
				           while ($data = mysqli_fetch_assoc($query)) {
				    
								     $detalletabla .= '<tr>
									                      
									              		<td class="tx">'.$data['codigo'].'</td>
									              		<td class="tx">'.$data['nombre'].'</td>
													    <td class="tx">$: '.$data['precio_venta'].'</td>
													    <td class="tx">'.$data['entradas'].'</td>
									                    <td class="tx">'.$data["salidas"].'</td>
									                    <td class="tx">'.$data["stock"].'</td>

								                      </tr>';             
				                            
				             }
				                         $arrayData['detalle'] = $detalletabla;
										 echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				                         mysqli_close($conexion); exit;
				           }else {
							echo "error";
							mysqli_close($conexion); exit;
							
						  }
				           



                 }


		      	 	
	 	 
			 }


        
				      

      echo 'error';exit;
	  	 
      
	  } 
	  //fin


    //// cuadre caja //////

	// if ($_POST['action'] == 'Guardar_Cuadre')

  ///////////////Registro de productos ////////////////////////////
  // Registro Producto
  if($_POST['action'] == 'AddProducto')
  {
	  
	  $codigo = $_POST['codigo'];
	  $nombre = $_POST['nombre'];
	  $tipo = $_POST['tipo'];
	  $precio_compra = $_POST['precio_compra'];
	  $precio_venta = $_POST['precio_venta'];
	   
	  $sql = "INSERT INTO producto (codigo,nombre,precio_compra,precio_venta,tipo)  VALUES ('$codigo','$nombre','$precio_compra','$precio_venta','$tipo')";	
  
  
	  if (mysqli_query($conexion,$sql)) {
		  //echo "Datos Actualizados..";
		  mysqli_close($conexion);
		  exit;
  
		} else {
		  mysqli_close($conexion);
		   echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
		  exit;
  
		}
   
  
	exit;		 
  }		

	// Modificar Producto
	if($_POST['action'] == 'UpdateProducto')
	{
		// print_r($_POST);
		$id = $_POST['id'];
		$codigo = $_POST['codigo'];
		$nombre = $_POST['nombre'];
		$tipo = $_POST['tipo'];
		$precio_compra = $_POST['precio_compra'];
		$precio_venta = $_POST['precio_venta'];

		$sql="UPDATE  producto SET codigo='$codigo', nombre ='$nombre', precio_compra='$precio_compra', precio_venta='$precio_venta', tipo='$tipo' 
			WHERE id_producto='$id'";


		if (mysqli_query($conexion,$sql)) {
			//echo "Datos Actualizados..";
			mysqli_close($conexion);
			exit;

		} else {
			mysqli_close($conexion);
			echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
			exit;

		}
	

	exit;		 
	}
	
	 // buscar producto
	 if($_POST['action'] == 'SearchProducto'){

		$prod = $_POST['producto'];

            $sql= "SELECT producto.id_producto, producto.codigo, producto.nombre, producto.tipo, producto.precio_compra, inventario.stock 
			FROM producto  inner join inventario on inventario.codigo = producto.codigo WHERE producto.codigo = '$prod'";

			// $query = mysqli_query($conexion,"SELECT p.id_producto, p.codigo, p.nombre, p.tipo, p.precio_compra, inventario.stock 
			// FROM producto p inner join inventario on inventario.codigo = p.codigo WHERE codigo = '$prod'");


             $query = mysqli_query($conexion,$sql);

			 $result = mysqli_num_rows($query);

			 if($result > 0){
			 $data = mysqli_fetch_assoc($query);
			 echo json_encode($data,JSON_UNESCAPED_UNICODE);
			 exit();
			 };
			 mysqli_close($conexion);
			 exit;
		
	 
  }
// fin	 

 // Guardar Configuracion
 if($_POST['action'] == 'AddConfiguracion'){

	
	
	$nit = $_POST['nit'];
	$dg = $_POST['dg'];
	$nombre = $_POST['nombre'];
	$dir = $_POST['direccion'];
	$tel = $_POST['telefono'];
	$email = $_POST['email'];
	$iv = $_POST['iva'];
	


 	if( (empty($nit) ||empty($nombre) || empty($tel) ||empty($dir) ||empty($iv) ) ){
			   
			
			echo "llene todos los campos...";
			
		} else{
			            $dato = array();
						$sql = "SELECT COUNT(*) AS 'numero' FROM configuracion";
						$query = mysqli_query($conexion,$sql);
						
						$result = mysqli_num_rows($query);

						while($x = mysqli_fetch_assoc($query)){
							$dato[] = $x;
						}
						$dat=$dato[0];


                        
                       // print_r($dat['numero']);
						//print_r("numero de registros:".$result);
						//print_r($data);
					   // print_r($data->numero);
					

				   if ($dat['numero'] >= 1) {

							echo "No se puede Guardar mas de 1 Configuracion";
							exit;

					 }else if ($dat['numero'] == 0 ) {

						 $sql1 = "INSERT INTO configuracion (nit,dg, nombre, direccion , telefono, email, iva) VALUES ('$nit','$dg','$nombre','$dir','$tel','$email','$iv')";
						
						if( mysqli_query($conexion,$sql1) ) {
							mysqli_close($conexion);
							exit;
						}else{
							echo "fallo en la consulta " . $sql1 . "-" . mysqli_error($conexion);
							mysqli_close($conexion);
							exit;
						}
						 
						 
						  
					 }

				

				   

			 }

}
// fin	 

// Modificar Configuracion
if($_POST['action'] == 'UpdateConfiguracion'){

	
	$id = $_POST['id'];
	$nit = $_POST['nit'];
	$dg = $_POST['dg'];
	$nombre = $_POST['nombre'];
	$dir = $_POST['direccion'];
	$tel = $_POST['telefono'];
	$email = $_POST['email'];
	$iv = $_POST['iva'];
	


 	if( (empty($nit) ||empty($nombre) || empty($tel) ||empty($dir) ||empty($iv) ) ){
			   
			
			echo "llene todos los campos...";
			
		} else{


						// $sql1 = "INSERT INTO configuracion (nit,dg, nombre, direccion , telefono, email, iva) VALUES ('$nit','$dg','$nombre','$dir','$tel','$email','$iv')";
						$sq="UPDATE configuracion SET  nit='$nit',dg='$dg', nombre = '$nombre', direccion = '$dir',telefono='$tel',email ='$email', iva='$iv' WHERE id_config = $id";
						if( mysqli_query($conexion,$sq) ) {
							mysqli_close($conexion);
							exit;
						}else{
							echo "fallo en la consulta " . $sq . "-" . mysqli_error($conexion);
							mysqli_close($conexion);
							exit;
						}
						 
						 
						  
					 

				

				   

			 }

}
// fin

// Registro de usuarios
if($_POST['action'] == 'AddUsuario'){

  //print_r($_POST);

    $cedula = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$correo = $_POST['correo'];
	$telefono = $_POST['telefono'];
	$tipo = $_POST['tipo'];
	$pass = $_POST['contraseña'];
	$passDB = md5($pass);

	function setPassword(){
		
		$valor = explode(" ","A B C D E F G H I J K L M O P Q R S T U V X W Y Z 0 1 2 3 4 5 6 7 8 9"); 
		$pass = "";
		for($x = 0; $x < 4; $x++){
			$v  = rand(0, 30);
			$pass .= $valor[(int)$v];
		}
		return $pass;
	}


	function sendEmail($nombre, $email,$pass){
		$asunto = "Registro de usuario APRENDIZ";
		$cuerpo = '<!DOCTYPE html>';
		$cuerpo .='<html xmlns="http://www.w3.org/1999/xhtml">';
		$cuerpo .='<head><title> Sistema - Ventas - Web </title></head>';
		$cuerpo .='<body>';
		$cuerpo .=	'<table width="550" border="0" cellpadding="0" cellspacing="0">';
		$cuerpo .=		'<tr>';
		$cuerpo .=			'<td><img src="img/log/icon.png" width="550" height="78" /></td>';
		$cuerpo .=      '</tr>';
		$cuerpo .=		'<tr>';
		$cuerpo .=			'<td>';
		$cuerpo .=				'Sr(a) .<b>'.$nombre.'</b> <br/> Usted se ha registrado correctamente en nuestro portal.<br> Ha recibido los datos de acceso para poder realizar el ingreso al Sistema.<br/><br/>';
		$cuerpo .=				'<b>Datos de Acceso </b><br/>';
		$cuerpo .=				'Email : '.$email.'<br/><br/>';		
		$cuerpo .=				'Password : '.$pass.'<br/><br/>';
		$cuerpo .=			'</td>';
		$cuerpo .=		'<tr/>';
		$cuerpo .= 		'<tr>';
		$cuerpo .= 			'<td> <br/><br/>Mensaje Automatico Enviado desde el portal Web  .Res:#'.md5($pass).' <br/> --<br/><br/>';
		$cuerpo .= 				'Develop by ING.Royman Rodriguez <hr/>';
		$cuerpo .= 				'';
		//$cuerpo .= 				'Telefonos : (094) 839 51 21      Cel : 311 307 76 74<br/>';
		$cuerpo .= 				'';
		$cuerpo .= 				'';
		$cuerpo .= 			'</td>';
		$cuerpo .= 		'</tr>';
		$cuerpo .=	'</table>';
		$cuerpo .=	'<hr/>';
		$cuerpo .='</html>';
		
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		//dirección del remitente
		$headers .= "From: Registro Sistema de Ventas Web<roiman1011@hotmail.com>\r\n";
		//$headers .= "Reply-To: yenis_romero@aprendiz.com.co\r\n";
		//$headers .= "Cc: \r\n";
		//direcciones que recibirán copia oculta
		$headers .= "Bcc: roiman93lopez@gmail.com\r\n";


		if(mail($email,$asunto,$cuerpo,$headers)){
			$_SESSION['msn'] = "Hemos enviado una nueva contraseña a email ".$email.", con los datos de acceso...<br/> Si el msn no se visualiza en su bandeja de entrada, favor revisar su correo no deseado.";
		}else{
			$_SESSION['msn'] = "Problemas al enviar los datos....";
		}
	}


    $sql = "INSERT INTO usuario (nombre,apellido, identificacion, email, id_tipo, password) VALUES ('$nombre','$apellido','$cedula','$correo','$tipo','$passDB')";
	//$sql1 = "INSERT INTO usuario (nombre, apellido, identificacion, id_tipo, password, email) VALUES ('$nit','$dg','$nombre','$dir','$tel','$$passDB')";
	//$sq="UPDATE configuracion SET  nit='$nit',dg='$dg', nombre = '$nombre', direccion = '$dir',telefono='$tel',email ='$email', iva='$iv' WHERE id_config = $id";
	if( mysqli_query($conexion,$sql) ) {
		mysqli_close($conexion);
		//sendEmail($nombre, $correo, $pass);
		exit;
	}else{
		echo "fallo en la consulta " . $sql . "-" . mysqli_error($conexion);
		mysqli_close($conexion);
		exit;
	}

    
   
	
	


}
//fim


// Modificar Usuario
if($_POST['action'] == 'UpdateUsuario'){

	
      $id= $_POST['id'];
	  $cedula = $_POST['cedula'];
	  $nombre = $_POST['nombre'];
	  $apellido = $_POST['apellido'];
	  $correo = $_POST['correo'];
	  
	  $tipo = $_POST['tipo'];
	  $pass = $_POST['contraseña'];
	  $passDB = md5($pass);
  
	  function setPassword(){
		  
		  $valor = explode(" ","A B C D E F G H I J K L M O P Q R S T U V X W Y Z 0 1 2 3 4 5 6 7 8 9"); 
		  $pass = "";
		  for($x = 0; $x < 4; $x++){
			  $v  = rand(0, 30);
			  $pass .= $valor[(int)$v];
		  }
		  return $pass;
	  }
  
  
	  function sendEmail($nombre, $email,$pass){
		  $asunto = "Registro de usuario APRENDIZ";
		  $cuerpo = '<!DOCTYPE html>';
		  $cuerpo .='<html xmlns="http://www.w3.org/1999/xhtml">';
		  $cuerpo .='<head><title> Sistema - Ventas - Web </title></head>';
		  $cuerpo .='<body>';
		  $cuerpo .=	'<table width="550" border="0" cellpadding="0" cellspacing="0">';
		  $cuerpo .=		'<tr>';
		  $cuerpo .=			'<td><img src="img/log/icon.png" width="550" height="78" /></td>';
		  $cuerpo .=      '</tr>';
		  $cuerpo .=		'<tr>';
		  $cuerpo .=			'<td>';
		  $cuerpo .=				'Sr(a) .<b>'.$nombre.'</b> <br/> Usted se ha registrado correctamente en nuestro portal.<br> Ha recibido los datos de acceso para poder realizar el ingreso al Sistema.<br/><br/>';
		  $cuerpo .=				'<b>Datos de Acceso </b><br/>';
		  $cuerpo .=				'Email : '.$email.'<br/><br/>';		
		  $cuerpo .=				'Password : '.$pass.'<br/><br/>';
		  $cuerpo .=			'</td>';
		  $cuerpo .=		'<tr/>';
		  $cuerpo .= 		'<tr>';
		  $cuerpo .= 			'<td> <br/><br/>Mensaje Automatico Enviado desde el portal Web  .Res:#'.md5($pass).' <br/> --<br/><br/>';
		  $cuerpo .= 				'Develop by ING.Royman Rodriguez <hr/>';
		  $cuerpo .= 				'';
		  //$cuerpo .= 				'Telefonos : (094) 839 51 21      Cel : 311 307 76 74<br/>';
		  $cuerpo .= 				'';
		  $cuerpo .= 				'';
		  $cuerpo .= 			'</td>';
		  $cuerpo .= 		'</tr>';
		  $cuerpo .=	'</table>';
		  $cuerpo .=	'<hr/>';
		  $cuerpo .='</html>';
		  
		  
		  $headers = "MIME-Version: 1.0\r\n";
		  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		  //dirección del remitente
		  $headers .= "From: Registro Sistema de Ventas Web<roiman1011@hotmail.com>\r\n";
		  //$headers .= "Reply-To: yenis_romero@aprendiz.com.co\r\n";
		  //$headers .= "Cc: \r\n";
		  //direcciones que recibirán copia oculta
		  $headers .= "Bcc: roiman93lopez@gmail.com\r\n";
  
  
		  if(mail($email,$asunto,$cuerpo,$headers)){
			  $_SESSION['msn'] = "Hemos enviado una nueva contraseña a email ".$email.", con los datos de acceso...<br/> Si el msn no se visualiza en su bandeja de entrada, favor revisar su correo no deseado.";
		  }else{
			  $_SESSION['msn'] = "Problemas al enviar los datos....";
		  }
	  }

	  if(empty($pass)){

		$sql =  "UPDATE usuario SET  nombre='$nombre', apellido = '$apellido', email = '$correo',identificacion='$cedula' WHERE id_usuario = $id";
		if( mysqli_query($conexion,$sql) ) {
			mysqli_close($conexion);
			//sendEmail($nombre, $correo, $pass);
			exit;
		}else{
			echo "fallo en la consulta " . $sql . "-" . mysqli_error($conexion);
			mysqli_close($conexion);
			exit;
		}


	}else {
		$passDB = md5($pass);

		$sql1 =  "UPDATE usuario SET  nombre='$nombre', apellido = '$apellido', email = '$correo',identificacion='$cedula',password ='$passDB' WHERE id_usuario = $id";

		
		if( mysqli_query($conexion,$sql1) ) {
			mysqli_close($conexion);
			//sendEmail($nombre, $correo, $pass);
			exit;
		}else{
			echo "fallo en la consulta " . $sql1. "-" . mysqli_error($conexion);
			mysqli_close($conexion);
			exit;
		}
  
	}
	 
	  
	  
  
  
}
//fim


// Guardara resolucion
if($_POST['action'] == 'AddResolucion'){

    
	  $prefijo = $_POST['prefijo'];
	  $inicial = $_POST['n_inicial'];
	  $final = $_POST['n_final'];
	  $resolucion = $_POST['n_resolucion'];
	  $fecha = $_POST['fecha'];	
	  $tipo = $_POST['tipo'];



	 
      $sql1 = "INSERT INTO prefijos (prefijo,n_inicio, n_final, n_resolucion , fecha_resolucion, tipo_documento) 
	           VALUES ('$prefijo','$inicial','$final','$resolucion','$fecha','$tipo')";
		
	  if( mysqli_query($conexion,$sql1) ) {
		  mysqli_close($conexion);
		  //sendEmail($nombre, $correo, $pass);
		  exit;
	  }else{
		  echo "fallo en la consulta " . $sql1. "-" . mysqli_error($conexion);
		  mysqli_close($conexion);
		  exit;
	  }


}


// modificar resolucion
if($_POST['action'] == 'UpdateResolucion'){

      $id= $_POST['id'];
	  $prefijo = $_POST['prefijo'];
	  $inicial = $_POST['n_inicial'];
	  $final = $_POST['n_final'];
	  $resolucion = $_POST['n_resolucion'];
	  $fecha = $_POST['fecha'];	
	  $tipo = $_POST['tipo'];



	 $sql1=" UPDATE prefijos SET prefijo = '$prefijo', n_inicio='$inicial', n_final='$final', 
	 n_resolucion='$resolucion', fecha_resolucion='$fecha', tipo_documento='$tipo' WHERE id='$id'";

    //   $sql1 = "UPDATE prefijos SET prefijo='$prefijo', n_inicio='$inicial', n_final='$final', 
	//            n_resolucion='$resolucion', fecha_resolucion='$fecha', tipo_documento='$tipo' WHERE id='$id' ";
		
	  if( mysqli_query($conexion,$sql1) ) {
		  mysqli_close($conexion);
		  
		  exit;
	  }else{
		  echo "fallo en la consulta " . $sql1. "-" . mysqli_error($conexion);
		  mysqli_close($conexion);
		  exit;
	  }


}

// activar Resolucion 
if($_POST['action'] == 'ActResolucion'){

	$fac= $_POST['factura'];
	$sql=" CALL Sp_Activar_Resolucion('$fac') ";

	$query = mysqli_query($conexion,$sql);
	$result = mysqli_num_rows($query);


	if($result == 0) {

	  mysqli_close($conexion);
	  exit;
	

	}else if($result > 0) {
		
	  $info = mysqli_fetch_assoc($query);
	  mysqli_close($conexion);
	  $dato = $info['Error'];
	  print $dato;
	  exit;

	}


}
// fin


// Desactivar Resolucion 
if($_POST['action'] == 'DesactResolucion'){

	$fac= $_POST['factura'];
	$sql=" CALL Sp_Desactivar_Resolucion('$fac') ";

	$query = mysqli_query($conexion,$sql);
	$result = mysqli_num_rows($query);


	if($result == 0) {

	  mysqli_close($conexion);
	  exit;
	

	}else if($result > 0) {
		
	  $info = mysqli_fetch_assoc($query);
	  mysqli_close($conexion);
	  $dato = $info['Error'];
	  print $dato;
	  exit;

	}


}
// fin

// Eliminar Resolucion 
if($_POST['action'] == 'RemoveResolucion'){

	$fac= $_POST['factura'];
	$sql=" CALL Sp_Eliminar_Resolucion('$fac') ";

	$query = mysqli_query($conexion,$sql);
	$result = mysqli_num_rows($query);


	if($result == 0) {

	  mysqli_close($conexion);
	  exit;
	

	}else if($result > 0) {
		
	  $info = mysqli_fetch_assoc($query);
	  mysqli_close($conexion);
	  $dato = $info['Error'];
	  print $dato;
	  exit;

	}


}
// fin

 //Buscar Producto por id
 if($_POST['action'] == 'GetProducto')
 {
   
		   if (!empty($_POST['producto'])){
			 $id = $_POST['producto'];

			 $query = mysqli_query($conexion,"SELECT * FROM producto  WHERE id_producto = $id");

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

// buscar producto con filtro 

if ($_POST['action'] == 'BuscarProducto'){
	$filtro = $_POST['filtro'];
	$buscar=$_POST['buscar'];
	
	if (empty($_POST['buscar'])){
		$detalletabla = '';
	    $arrayData  = array();
  

        $query = mysqli_query($conexion,"SELECT * FROM producto");
        $result = mysqli_num_rows($query);

		if ($result > 0) {

			while ($data = mysqli_fetch_assoc($query)) {

								if($data['tipo'] =='1'){
									$tipo="<td class='tx'>Und</td>";
								}else if($data['tipo']=='2') {
									$tipo="<td class='tx'>Caja</td>";
								}

					$detalletabla .= '<tr>
										
										<td class="tx">'.$data['codigo'].'</td>
										<td class="tx">'.$data['nombre'].'</td>
										'.$tipo.'
										<td class="center aligned tx" >'.$data['precio_compra'].'</td>
										<td class="center aligned tx" >'.$data['precio_venta'].'</td>
										<td class="center aligned tx" >'.$data['fecha'].'</td>
										<td><a style="cursor:pointer;" onclick=Validar_Edit_Producto(fac="'.$data['id_producto'].'")>
										<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
										<a style="cursor:pointer;"  onclick=ValidarRemove_P(fac="'.$data['id_producto'].'") >
										<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

									</tr>';             
							
			}
					$arrayData['detalle'] = $detalletabla;
					echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
					mysqli_close($conexion); exit;
		
		}else{
			echo'error';
			mysqli_close($conexion); exit;
		}

	

	}else{

		  if($_POST['filtro'] == 1){
			

				   $detalletabla = '';
				   $arrayData  = array();
				  

				   $query = mysqli_query($conexion,"SELECT * FROM producto where codigo = '$buscar'");
				   $result = mysqli_num_rows($query);


					if ($result > 0) {
			
					while ($data = mysqli_fetch_assoc($query)) {
						   
						if($data['tipo'] =='1'){
							$tipo="<td class='tx'>Und</td>";
						}else if($data['tipo']=='2') {
							$tipo="<td class='tx'>Caja</td>";
						}
			 
							  $detalletabla .= '<tr>
												   
												<td class="tx">'.$data['codigo'].'</td>
												<td class="tx">'.$data['nombre'].'</td>
												'.$tipo.'
												<td class="center aligned tx" >'.$data['precio_compra'].'</td>
												<td class="center aligned tx" >'.$data['precio_venta'].'</td>
												<td class="center aligned tx" >'.$data['fecha'].'</td>
												<td><a style="cursor:pointer;" onclick=Validar_Edit_Producto(fac="'.$data['id_producto'].'")>
												<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
												<a style="cursor:pointer;"  onclick=ValidarRemove_P(fac="'.$data['id_producto'].'") >
												<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>

											    </tr>';             
									 
					  }
					  $arrayData['detalle'] = $detalletabla;
								  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
						mysqli_close($conexion); exit;
				   }else{
					echo'error';
					mysqli_close($conexion); exit;
				   }

		   }

		   elseif($_POST['filtro'] == 2){

				   $detalletabla = '';
				   $arrayData  = array();
				  
                                                 
				   $query = mysqli_query($conexion,"SELECT * FROM producto  WHERE nombre LIKE '$buscar%' ");
				   $result = mysqli_num_rows($query);                               


					if ($result > 0) {
			
					while ($data = mysqli_fetch_assoc($query)) {

						if($data['tipo'] =='1'){
							$tipo="<td class='tx'>Und</td>";
						}else if($data['tipo']=='2') {
							$tipo="<td class='tx'>Caja</td>";
						}
			 
							  $detalletabla .= '<tr>
												   
													<td class="tx">'.$data['codigo'].'</td>
													<td class="tx">'.$data['nombre'].'</td>
													'.$tipo.'
													<td class="center aligned tx" >'.$data['precio_compra'].'</td>
													<td class="center aligned tx" >'.$data['precio_venta'].'</td>
													<td class="center aligned tx" >'.$data['fecha'].'</td>
													<td><a style="cursor:pointer;" onclick=Validar_Edit_Producto(fac="'.$data['id_producto'].'")>
													<div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
													<a style="cursor:pointer;"  onclick=ValidarRemove_P(fac="'.$data['id_producto'].'") >
													<div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>
											    </tr>';             
									 
					  }
								  $arrayData['detalle'] = $detalletabla;
								  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
								  mysqli_close($conexion); exit;
					}else{
						echo'error';
						mysqli_close($conexion); exit;
					}
					



		  }


				
   
	  }


 
			   

echo 'error';exit;
	

}

//fin

// Eliminar Resolucion 
if($_POST['action'] == 'RemoveProducto'){

	$id= $_POST['id'];
	$sql=" CALL Sp_Eliminar_Producto('$id') ";

	$query = mysqli_query($conexion,$sql);
	$result = mysqli_num_rows($query);


	if($result == 0) {

	  mysqli_close($conexion);
	  exit;
	

	}else if($result > 0) {
		
	  $info = mysqli_fetch_assoc($query);
	  mysqli_close($conexion);
	  $dato = $info['Error'];
	  print $dato;
	  exit;

	}


}
// fin










   
	?>