<?php
session_start();

require 'controlador/Base.php';
include 'modelo/conexion.php';
include 'modelo/usuario.php';
include 'modelo/configuracion.php';
include 'modelo/provedor.php';
include 'modelo/clientes.php';
include 'modelo/producto.php';
include 'modelo/facturas.php';
include 'modelo/caja.php';
include 'modelo/resolucion.php';

 



class Controller extends date{
	// INICIO DE CONTROLADOR 
		function Controlador() {

			$fecha = $this->fechaLarga();

			if(isset($_GET['opcion'])){
				$opc = $_GET['opcion'];
				
				if(method_exists($this, $opc)){
					
					$this->$opc();

				}else{
					
				$this->error();

				}
			}else{

				$this->login();	
			}
			


		}

        function error(){
			print "pagina 404.html";
		}

		function login(){
			if(isset($_SESSION['ih_id'])){
				$this->inicio();
			}else{
				include "vistas/acceso.php";
			}
		}


		function closini(){

			unset($_SESSION['ih_id']);
			unset($_SESSION['ih_email']);
			unset($_SESSION['ih_nombre']);
			unset($_SESSION['ih_tipo']);
			session_destroy();
			$this->redireccionar('inicio');
		}

		function close(){
			unset($_SESSION['ih_id']);
			unset($_SESSION['ih_email']);
			unset($_SESSION['ih_nombre']);
			unset($_SESSION['ih_tipo']);
			session_destroy();
			$this->redireccionar('login');
		}


		function ingresofact(){
			    $mo = new Configuracion();
				if(isset($_SESSION['ih_id'])){

					if($_SESSION['ih_tipo'] == 1){

						$cfg = $mo->get_config();
						$f_larga = $this->fechaLarga();
						include "vistas/ingreso.php";
				
					}else{
					
					print('usuario no es admin');
						
						}

					}else{
						$this->redireccionar('login');
					}

		}

		function list_ventas(){

			    $mo = new Configuracion();
				if(isset($_SESSION['ih_id'])){

					    $cfg = $mo->get_config();
						$f_larga = $this->fechaLarga();
						include "vistas/List_Ventas.php";
	

					}else{
						$this->redireccionar('login');
					}

		}

		function list_compras(){
			
		     	$mo = new Configuracion();
				if(isset($_SESSION['ih_id'])){

					if($_SESSION['ih_tipo'] == 1){

					    $cfg = $mo->get_config();
						$f_larga = $this->fechaLarga();
						
						include "vistas/liscompras.php";
				
					}else{
					
					print('usuario no es admin');
						
						}

					}else{
						$this->redireccionar('login');
					}

		}


		function anular_factura(){
					$mod = new facturas();
			$mod->anular();
			$this->redireccionar('list_ventas');
		}

		function inicio(){
				
			$mod = new Configuracion();
			if(isset($_SESSION['ih_id'])){


				        $cfg = $mod->get_config();
						$dato = $mod->ventas_dia();
						$dt = $mod->num_productos();
						$prv = $mod->num_provedor();
						$f_larga = $this->fechaLarga();
						include "vistas/inicio.php";

					

				}else{
					$this->redireccionar('login');
				}
				
		}


		function ventas(){
			
			    $mo = new Configuracion();
				if(isset($_SESSION['ih_id'])){

				    	$cfg = $mo->get_config();
						$prefj = $mo->Get_Prefijo();
						$f_larga = $this->fechaLarga();
						include "vistas/ventas.php";

					

				}else{
					$this->redireccionar('login');
				}

				
		}

		function clientes(){
			    $mo = new Configuracion();
				$mod = new clientes();
				if(isset($_SESSION['ih_id'])){

					$cfg = $mo->get_config();
				    //$dato = $mod->get_Clientes();

						$f_larga = $this->fechaLarga();

					if(isset($_GET['edit'])){

							$datoE = $mod->getClient_Id();
							}
						include "vistas/clientes.php";

					

					}else{
						$this->redireccionar('login');
					}

		}


		function delete(){
					$mod = new clientes();
			$mod->dle();
			$this->redireccionar('clientes');
		}

		
				
		function provedores(){

			$mo = new Configuracion();
			//$mod = new provedor();
				if(isset($_SESSION['ih_id'])){


					if($_SESSION['ih_tipo'] == 1){
						$cfg = $mo->get_config();
			        	//$dato = $mod->get_Provedor();
						$f_larga = $this->fechaLarga();

					if(isset($_GET['edit'])){

							//$datoE = $mod->getProve_Id();
							}
					include "vistas/provedores.php";

					}else{
					
					print('usuario no es admin');
						
						}

				}else{
					$this->redireccionar('login');
				}
				
		}


		function delprovedor(){

			$mod = new provedor();
			$mod->eliminar();
			$this->redireccionar('provedores');

		}

		function usuarios(){

			$mo = new Configuracion();
			$mod = new usuario();
				if(isset($_SESSION['ih_id'])){
			

					if($_SESSION['ih_tipo'] == 1){
			    $cfg = $mo->get_config();
				$dato = $mod->usu_tipo();
				$datoE = $mod->tipous();
						$f_larga = $this->fechaLarga();
				$tipo = $mod->tipous();
				if(isset($_GET['edit'])){

							$datoE = $mod->getUsuarioId();

							}

						include "vistas/usuarios.php";

					}else{
					
					print('usuario no es admin');
						
						}

				}else{
					$this->redireccionar('login');
				}

				
		}

		function delusuario(){

			$mod = new usuario();
			$mod->eliminar();
			$this->redireccionar('usuarios');

		}


		function productos(){

			    $mo = new Configuracion();
				//$mod = new producto();

				if(isset($_SESSION['ih_id'])){

					if($_SESSION['ih_tipo'] == 1){
						$cfg = $mo->get_config();
				       // $dato = $mod->get_Product();
						$f_larga = $this->fechaLarga();
						if(isset($_GET['edit'])){

							//$datoE = $mod->getProduct_Id();

							}
						include "vistas/productos.php";

					}else{
					
					print('usuario no es admin');
						
						}

				}else{
					$this->redireccionar('login');
				}
				
		}

		function del_P(){
				$mod = new producto();
				$mod->eliminar();
				$this->redireccionar('productos');	
				
		}

		function caja(){

			$mo = new Configuracion();
			$mod = new caja();
				if(isset($_SESSION['ih_id'])){


					
				$cfg = $mo->get_config();
				$dato = $mod->get_Caja();
				$f_larga = $this->fechaLarga();
				include "vistas/caja.php";

					

				}else{
					$this->redireccionar('login');
				}

				
		}

		function delcaja(){

			$mod = new caja();
			$mod-> dle();
			$this->redireccionar('caja');

		}


		function inventario(){

			    $mo = new Configuracion();

				if(isset($_SESSION['ih_id'])){


					if($_SESSION['ih_tipo'] == 1){

                        $cfg = $mo->get_config();
						$f_larga = $this->fechaLarga();
						include "vistas/inventario.php";

					}else{
					
					print('usuario no es admin');
						
						}

				}else{
					$this->redireccionar('login');
				}

		}

		function vista_config(){
			$mod = new Configuracion();
				if(isset($_SESSION['ih_id'])){
		
			

					if($_SESSION['ih_tipo'] == 1){


					
				    $cfg = $mod->get_config();
					$dato = $mod->get_config();
					$dat = $mod->contar_filas();
						$f_larga = $this->fechaLarga();
				

					if(isset($_GET['edit'])){

							$datoE = $mod->getConfig();

							}

						include "vistas/configuracion.php";

					}else{
					
					print('usuario no es admin');
						
						}

				}else{
					$this->redireccionar('login');
				}

				
		}


		function delconfig(){

			$mod = new Configuracion();
			$mod->eliminar();
			$this->redireccionar('vista_config');

		}


		function mesas(){
			    $mo = new Configuracion();
				if(isset($_SESSION['ih_id'])){


					
					    $cfg = $mo->get_config();
						$f_larga = $this->fechaLarga();
						include "vistas/mesas.php";

					

				}else{
					$this->redireccionar('login');
				}

				
		}


		function Resolucion(){
			$mo = new Configuracion();
			$mod = new Resolucion();
			if(isset($_SESSION['ih_id'])){


				    $dato = $mod->Get_Resolucion();
				    $cfg = $mo->get_config();
					$f_larga = $this->fechaLarga();
					if(isset($_GET['edit'])){

						$datoE = $mod->Get_id();

						}
					include "vistas/resolucion.php";

				

			}else{
				$this->redireccionar('login');
			}

			
	    }

		function ActivarR(){
			$mod = new Resolucion();
			$mod->Activar_Resolucion();
			$this->redireccionar('clientes');
		}


		function List_Cliente(){

			$mo = new Configuracion();
			if(isset($_SESSION['ih_id'])){


				
					$cfg = $mo->get_config();
					$f_larga = $this->fechaLarga();
					include "vistas/List_Clientes.php";

				

			}else{
				$this->redireccionar('login');
			}

		}

		
		function List_Producto(){

			$mo = new Configuracion();
			if(isset($_SESSION['ih_id'])){


				
					$cfg = $mo->get_config();
					$f_larga = $this->fechaLarga();
					include "vistas/List_Productos.php";

				

			}else{
				$this->redireccionar('login');
			}

		}

		
		function List_Proveedor(){

			$mo = new Configuracion();
			if(isset($_SESSION['ih_id'])){


				
					$cfg = $mo->get_config();
					$f_larga = $this->fechaLarga();
					include "vistas/List_Proveedores.php";

				

			}else{
				$this->redireccionar('login');
			}

		}



	}

?>