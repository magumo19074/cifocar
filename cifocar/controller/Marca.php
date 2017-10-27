<?php
	//CONTROLADOR MARCA 
	class Marca extends Controller{

		//PROCEDIMIENTO PARA GUARDAR UNA NUEVA MARCA
		public function nuevo(){
		    
		    //comprobar si eres comprador
		    if(!Login::getUsuario() || Login::getUsuario()->privilegio!=1)
		        throw new Exception('Debes ser responsable de compras');
		    
			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$this->load_view('view/marcas/nueva.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia de Marca
				$this->load('model/MarcaModel.php');
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$marca = $conexion->real_escape_string($_POST['marca']);
							
				//guardar la marca en BDD
				if(!MarcaModel::guardar($marca)){
					throw new Exception('No se pudo guardar la marca');
				}
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Operación de guardado completada con éxito';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMIENTO PARA LISTAR LAS MARCAS
		public function listar($pagina){
		    
		    //comprobar si eres comprador
		    if(!Login::getUsuario() || Login::getUsuario()->privilegio!=1)
		        throw new Exception('Debes ser responsable de compras');
		    
		    $this->load('model/MarcaModel.php');
		    
		    //si me piden APLICAR un filtro
		    if(!empty($_POST['filtrar'])){
		        //recupera el filtro a aplicar
		        $f = new stdClass(); //filtro
		        $f->texto = htmlspecialchars($_POST['texto']);
		        $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
		        
		        //guarda el filtro en un var de sesión
		        $_SESSION['filtroMarcas'] = serialize($f);
		    }
		  
		    //si me piden QUITAR un filtro
		    if(!empty($_POST['quitarFiltro']))
		        unset($_SESSION['filtroMarcas']);
		    
		    
	        //comprobar si hay filtro
	        $filtro = empty($_SESSION['filtroMarcas'])? false : unserialize($_SESSION['filtroMarcas']);
		        
		    //para la paginación
		    $num = 10; //numero de resultados por página
		    $pagina = abs(intval($pagina)); //para evitar cosas raras por url
		    $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
		    $offset = $num*($pagina-1); //offset
		    
		    //si no hay que filtrar los resultados...
		    if(!$filtro){
		      //recupera todas las marcas
		      $marcas = MarcaModel::getMarcas($num, $offset);
		      //total de registros (para paginación)
		      $totalRegistros = MarcaModel::getTotal();
		    }else{
		      //recupera las marcas con el filtro aplicado
		      $marcas = MarcaModel::getMarcas($num, $offset, $filtro->texto, $filtro->sentidoOrden);
		      //total de registros (para paginación)
		      $totalRegistros = MarcaModel::getTotal($filtro->texto);
		    }
		    
		    //cargar la vista del listado
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['marcas'] = $marcas;
		    $datos['filtro'] = $filtro;
		    $datos['paginaActual'] = $pagina;
		    $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
		    $datos['totalRegistros'] = $totalRegistros;
		    $datos['regPorPagina'] = $num;
		    
		    $this->load_view('view/marcas/lista.php', $datos);
		}
		
		//PROCEDIMIENTO PARA EDITAR UNA MARCA
		public function editar($marca){
		   
		    //comprobar si eres comprador
		    if(!Login::getUsuario() || Login::getUsuario()->privilegio!=1)
		        throw new Exception('Debes ser responsable de compras');
		    
		    //comprobar que me llega una marca
		    if(!$marca)
		        throw new Exception('No se indicó la marca');
		        
		    //si no me están enviando el formulario
		    if(empty($_POST['modificar'])){
		      //poner el formulario
		        $datos = array();
		        $datos['usuario'] = Login::getUsuario();
		        $datos['marca'] = $marca;
		        $this->load_view('view/marcas/modificar.php', $datos);

		    }else{
		    //en caso contrario
		        $this->load('model/MarcaModel.php');
		        $conexion = Database::get();
		          //actualizar los campos de la marca con los datos POST
		        $marcanew = $conexion->real_escape_string($_POST['marca']);
		      		      
		        if(!MarcaModel::actualizar($marcanew,$marca)){
		              throw new Exception('No se pudo guardar la marca');
		        }		          
		        
		        //cuando se modifica una marca informando una marca que ya existe en la BDD
		        $result= MarcaModel::actualizar($marcanew,$marca);
		        if ($result) {
		            throw new Exception('No se pudo guardar la marca porque posiblemente ya exista');
		        }
		          
		      //cargar la vista de éxito 
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = "Datos de la marca actualizados correctamente.";
	          $this->load_view('view/exito.php', $datos);
		    }
		}
		
		//PROCEDIMIENTO PARA BORRAR UNA MARCA
		public function borrar($marca){
		    
		    //comprobar si eres comprador
		    if(!Login::getUsuario() || Login::getUsuario()->privilegio!=1)
		        throw new Exception('Debes ser responsable de compras');
		   
	       //comprobar que se ha indicado una marca
	       if(!$marca)
	           throw new Exception('No se indicó la marca a borrar');
		       
	       //recuperar la marca con esa marca
	       $this->load('model/MarcaModel.php');


		   //si no me envian el formulario de confirmación
		   
		   if(empty($_POST['confirmarborrado'])){
		      //mostrar el formularion de confirmación junto con los datos de la marca
		      $datos = array();
		      $datos['usuario'] = Login::getUsuario();
		      $datos['marca'] = $marca;
		      
		      $this->load_view('view/marcas/confirmarborrado.php', $datos);
		   
		   //si me envian el formulario...
		   }else{
		      //borramos la marca de la BDD
		       if(!MarcaModel::borrar($marca))
		          throw new Exception('No se pudo borrar, es posible que se haya borrado ya.');
		      
		      //cargar la vista de éxito
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = 'Operación de borrado ejecutada con éxito.';
	          $this->load_view('view/exito.php', $datos);
		          
		   }
		}

	}
?>