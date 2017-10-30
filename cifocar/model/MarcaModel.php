<?php
	class MarcaModel{
		//PROPIEDADES
		public $marca; 
			
		//METODOS
		//guarda la marca en la BDD
		//PROTOTIPO public boolean guardar()
		public static function guardar($marca){
			$consulta = "INSERT INTO marcas(marca)
                            VALUES ('$marca');";
			
			return Database::get()->query($consulta);
		}
		
		
		//método que me recupera el total de registros (incluso con filtros)
		public static function getTotal($t=''){
		    $consulta = "SELECT * FROM marcas
                         WHERE marca LIKE '%$t%'";
		    
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    $total = $resultados->num_rows;
		    $resultados->free();
		    return $total;
		}
		
		
		//método que me recupere todas las marcas
		//PROTOTIPO: public static array<MarcaModel> getMarcas()
		public static function getMarcas($l=10, $o=0, $texto='', $sentido='ASC'){
		    //preparar la consulta
		    $consulta = "SELECT * FROM marcas
                         WHERE marca LIKE '%$texto%'
                         ORDER BY marca $sentido ";
		    
		    if($l>0) $consulta.= "LIMIT $l";
		    if($o>0) $consulta.= "OFFSET $o";
		    
		    //conecto a la BDD y ejecuto la consulta
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    
		    //creo la lista para los resultados
		    $lista = array();
		    while($marca = $resultados->fetch_object('MarcaModel'))
		      $lista[] = $marca; 
		        
		    //liberar memoria
		    $resultados->free();
		    
		    //retornar la lista de MarcaModel
		    return $lista;
		}
		
		
	    //actualiza los datos de la marca en la BDD
	    //PROTOTIPO: public boolean actualizar();
	    //tengo que saber cual es la marca de antes
		public static function actualizar($new, $old){
			//preparar la consulta
		    $consulta = "UPDATE marcas
					       SET marca='$new'
						  WHERE marca='$old';";
			
		    Database::get()->query($consulta);
		    //devuelve el num de filas afectadas
		    return Database::get()->affected_rows;
		    
		}
		
		
		//Método que borra una marca de la BDD (estático)
		//PROTOTIPO: public static boolean borrar($marca)
		public static function borrar($marca){
		    $consulta = "DELETE FROM marcas
                         WHERE marca='$marca';";
		    
		    $conexion = Database::get(); //conecta
		    $conexion->query($consulta); //ejecuta consulta
		    return $conexion->affected_rows; //devuelve el num de filas afectadas
		}				
	}
?>