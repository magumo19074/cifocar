<?php
	//CONTROLADOR VEHICULO
	class Vehiculo extends Controller{

		//PROCEDIMIENTO PARA GUARDAR UN NUEVO VEHI
		public function nuevo(){
		   
		    //comprobar si eres comprador
		    if(!Login::getUsuario() || Login::getUsuario()->privilegio!=1)
		        throw new Exception('Debes ser responsable de compras');

			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
			   
			    //Para llenar el desplegable de las marcas
			    $this->load('model/MarcaModel.php');
			  
			    $marcas = MarcaModel::getMarcas();
		 
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['marcas'] = $marcas;
				$this->load_view('view/vehiculos/nueva.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia de Vehiculo
				$this->load('model/VehiculoModel.php');
				$vehiculo = new VehiculoModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$vehiculo->matricula = $conexion->real_escape_string($_POST['matricula']);
				$vehiculo->modelo = $conexion->real_escape_string($_POST['modelo']);
				$vehiculo->color = $conexion->real_escape_string($_POST['color']);
				$vehiculo->precio_venta = intval($_POST['precio_venta']);
				$vehiculo->precio_compra = intval($_POST['precio_compra']);
				$vehiculo->kms = intval($_POST['kms']);
				$vehiculo->caballos = intval($_POST['caballos']);
				//$vehiculo->fecha_venta= $conexion->real_escape_string($_POST['fecha_venta']);
				$vehiculo->estado = intval($_POST['estado']);
				$vehiculo->any_matriculacion = intval($_POST['any_matriculacion']);
				$vehiculo->detalles = $conexion->real_escape_string($_POST['detalles']);
			//	$vehiculo->vendedor = intval($_POST['vendedor']);
				$vehiculo->marca = $conexion->real_escape_string($_POST['marca']);
			
				//recuperar el fichero
				$fichero = $_FILES['imagen'];
				
				$destino = 'images/vehiculos/';
				$tam_maximo = 1000000; //1MB aprox
				$renombrar = true;
				
				$upload = new Upload($fichero, $destino, $tam_maximo, $renombrar);
				$vehiculo->imagen = $upload->upload_image();
							
				//guardar el vehiculo en BDD
				if(!$vehiculo->guardar()){
				    unlink($vehiculo->imagen);
					throw new Exception('No se pudo guardar el vehiculo');
				}
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Operación de guardado completada con éxito';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMIENTO PARA LISTAR LOS VEHICULOS
		public function listar($pagina){
		    $this->load('model/VehiculoModel.php');
		    
		    //si me piden APLICAR un filtro
		    if(!empty($_POST['filtrar'])){
		        //recupera el filtro a aplicar
		        $f = new stdClass(); //filtro
		        $f->texto = htmlspecialchars($_POST['texto']);
		        $f->campo = htmlspecialchars($_POST['campo']);
		        $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
		        $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
		        
		        //guarda el filtro en un var de sesión
		        $_SESSION['filtroVehiculos'] = serialize($f);
		    }
		  
		    //si me piden QUITAR un filtro
		    if(!empty($_POST['quitarFiltro']))
		        unset($_SESSION['filtroVehiculos']);
		    
		    
	        //comprobar si hay filtro
	        $filtro = empty($_SESSION['filtroVehiculos'])? false : unserialize($_SESSION['filtroVehiculos']);
		        
		    //para la paginación
		    $num = 5; //numero de resultados por página
		    $pagina = abs(intval($pagina)); //para evitar cosas raras por url
		    $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
		    $offset = $num*($pagina-1); //offset
		    
		    //si no hay que filtrar los resultados...
		    if(!$filtro){
		      //recupera todas los vehiculos
		      $vehiculos = VehiculoModel::getVehiculos($num, $offset);
		      //total de registros (para paginación)
		      $totalRegistros = VehiculoModel::getTotal();
		    }else{
		      //recupera los vehiculos con el filtro aplicado
		        $vehiculos = VehiculoModel::getVehiculos($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
		      //total de registros (para paginación)
		      $totalRegistros = VehiculoModel::getTotal($filtro->texto, $filtro->campo);
		    }
		    
		    //cargar la vista del listado
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['vehiculos'] = $vehiculos;
		    $datos['filtro'] = $filtro;
		    $datos['paginaActual'] = $pagina;
		    $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
		    $datos['totalRegistros'] = $totalRegistros;
		    $datos['regPorPagina'] = $num;
		    
		  //  if(Login::isAdmin())
		  //    $this->load_view('view/vehiculos/lista_admin.php', $datos);
		  //  else
		      $this->load_view('view/vehiculos/lista.php', $datos);
		}
		
		
		
		//PROCEDIMIENTO PARA VER LOS DETALLES DE UN VEHICULO
		public function ver($id=0){
		    //comprobar que llega la ID
		    if(!$id) 
		        throw new Exception('No se ha indicado la ID del vehiculo');
		    
		    //recuperar la receta con la ID seleccionada
		    $this->load('model/VehiculoModel.php');
		    $vehiculo = VehiculoModel::getVehiculo($id);
		    
		    //comprobar que el vehiculo existe
		    if(!$vehiculo)
		        throw new Exception('No existe el vehiculo con código '.$id);
		    
		    //cargar la vista de detalles
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['vehiculo'] = $vehiculo;
		    $this->load_view('view/vehiculos/detalles.php', $datos);
		}
		
		
		//PROCEDIMIENTO PARA EDITAR UN VEHICULO
		public function editar($id=0){
		    
		    //comprobar si eres comprador
		    if(!Login::getUsuario() || Login::getUsuario()->privilegio!=1)
		        throw new Exception('Debes ser responsable de compras');
		          
		    //comprobar que me llega un id
		    if(!$id)
		        throw new Exception('No se indicó la id del vehiculo');
		        
		    //recuperar el vehiculo con esa id
		    $this->load('model/VehiculoModel.php');
		    $vehiculo = VehiculoModel::getVehiculo($id);
		    
		    //comprobar que existe la receta
		    if(!$vehiculo)
		        throw new Exception('No existe el vehiculo');   
		    
		    //si no me están enviando el formulario
		    if(empty($_POST['modificar'])){
		      //poner el formulario
		        $datos = array();
		        $datos['usuario'] = Login::getUsuario();
		        $datos['vehiculo'] = $vehiculo;
		        $this->load_view('view/vehiculos/modificarvehiculo.php', $datos);

		    }else{
		    //en caso contrario
		      $conexion = Database::get();
		      //actualizar los campos de la receta con los datos POST
		      $vehiculo->matricula = $conexion->real_escape_string($_POST['matricula']);
		      $vehiculo->modelo = $conexion->real_escape_string($_POST['modelo']);
		      $vehiculo->color = $conexion->real_escape_string($_POST['color']);
		      $vehiculo->precio_venta = intval($_POST['precio_venta']);
		      $vehiculo->precio_compra = intval($_POST['precio_compra']);
		      $vehiculo->kms = intval($_POST['kms']);
		      $vehiculo->caballos = intval($_POST['caballos']);
		      $vehiculo->fecha_venta= $conexion->real_escape_string($_POST['fecha_venta']);
		      $vehiculo->estado = intval($_POST['estado']);
		      $vehiculo->any_matriculacion = intval($_POST['any_matriculacion']);
		      $vehiculo->detalles = $conexion->real_escape_string($_POST['detalles']);
		      $vehiculo->vendedor = intval($_POST['vendedor']);
		      $vehiculo->marca = $conexion->real_escape_string($_POST['marca']);
		      		      
		      //tratamiento de la imagen
		      $fichero = $_FILES['imagen'];
		      
		      //si me indican una nueva imagen
		      if($fichero['error']!=UPLOAD_ERR_NO_FILE){
		          $fotoAntigua = $vehiculo->imagen;
		          
		          //subir la nueva imagen
		          $destino = 'images/vehiculos/';
		          $tam_maximo = 1000000;
		          $renombrar = true;
		          
		          $upload = new Upload($fichero, $destino , $tam_maximo, $renombrar);
		          $vehiculo->imagen = $upload->upload_image();
		          
		          //borrar la antigua
		          unlink($fotoAntigua);
		      }
		      
		      //modificar el vehiculo en la BDD
		      if(!$vehiculo->actualizar())
		          throw new Exception('No se pudo actualizar');
		      
		      //cargar la vista de éxito 
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = "Datos del vehiculo <a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'>'$vehiculo->modelo'</a> actualizados correctamente.";
	          $this->load_view('view/exito.php', $datos);
		    }
		}
		
		
		//PROCEDIMIENTO PARA EDITAR EL ESTADO DE UN VEHICULO
		public function editarestado($id=0){
		  
		      //comprobar si eres vendedor
		      if(!Login::getUsuario() || Login::getUsuario()->privilegio!=2)
		          throw new Exception('Debes ser vendedor');
		    
		    //comprobar que me llega un id
		    if(!$id)
		        throw new Exception('No se indicó la id del vehiculo');
		        
		        //recuperar el vehiculo con esa id
		        $this->load('model/VehiculoModel.php');
		        $vehiculo = VehiculoModel::getVehiculo($id);
		        
		        //comprobar que existe el vehiculo
		        if(!$vehiculo)
		            throw new Exception('No existe el vehiculo');
		            
		            //si no me están enviando el formulario
		            if(empty($_POST['modificar'])){
		                //poner el formulario
		                $datos = array();
		                $datos['usuario'] = Login::getUsuario();
		                $datos['vehiculo'] = $vehiculo;
		                $this->load_view('view/vehiculos/modificarestado.php', $datos);
		                
		            }else{
		                //en caso contrario
		                $conexion = Database::get();
		                //actualizar los campos del vehiculo con los datos POST
		              //  $vehiculo->precio_venta = intval($_POST['precio_venta']);
		              //  $vehiculo->fecha_venta= $conexion->real_escape_string($_POST['fecha_venta']);
		                $vehiculo->estado = intval($_POST['estado']);
		               	
		                if ($vehiculo->estado==2){
		                    $vehiculo->fecha_venta = date_format(new DateTime(), 'Y-m-d h:m:s');
		                    $vehiculo->vendedor=Login::getUsuario()->id;
		                }
		                
		                //modificar el estado del vehiculo 
		                //y si se ha vendido poner poner la fecha de venta del sistema en la BDD
		                if(!$vehiculo->actualizarestado())
		                    throw new Exception('No se pudo actualizar');
		                    
		                //cargar la vista de éxito
		                $datos = array();
		                $datos['usuario'] = Login::getUsuario();
		                $datos['mensaje'] = "Datos del vehiculo <a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'>'$vehiculo->modelo'</a> actualizados correctamente.";
		                $this->load_view('view/exito.php', $datos);
		            }
		  }      
		
		//PROCEDIMIENTO PARA BORRAR UNA RECETA
		public function borrar($id=0){
		   //comprobar que el usuario sea admin
		   if(!Login::isAdmin())
		       throw new Exception('Debes ser ADMIN');
		   
	       //comprobar que se ha indicado un id
	       if(!$id)
	           throw new Exception('No se indicó el vehiculo a borrar');
		       
	       //recuperar la receta con esa id
	       $this->load('model/VehiculoModel.php');
	       $vehiculo = VehiculoModel::getVehiculo($id);
	       
	       //comprobar que existe dicho vehiculo
	       if(!$vehiculo)
	           throw new Exception('No existe el vehiculo con id '.$id);
	           
	       
		   //si no me envian el formulario de confirmación
		   if(empty($_POST['confirmarborrado'])){
		      //mostrar el formularion de confirmación junto con los datos de la receta
		      $datos = array();
		      $datos['usuario'] = Login::getUsuario();
		      $datos['vehiculo'] = $vehiculo; 
		      $this->load_view('view/vehiculos/borrarvehiculo.php', $datos);
		   
		   //si me envian el formulario...
		   }else{
		      //borramos la receta de la BDD
		      if(!VehiculoModel::borrar($id))
		          throw new Exception('No se pudo borrar, es posible que se haya borrado ya.');
		      
		      //borra la imagen de la receta del servidor
		      unlink($vehiculo->imagen);    
		      
		      //cargar la vista de éxito
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = 'Operación de borrado ejecutada con éxito.';
	          $this->load_view('view/exito.php', $datos);
		          
		   }
		}

	}
?>