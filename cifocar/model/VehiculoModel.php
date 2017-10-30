<?php
//definición de la clase VEHICULOS
class VehiculoModel{
    //propiedades "¿qué tienen?"
    public $id, $matricula, $detalles, $modelo,$precio_venta,$imagen,$precio_compra,$kms,$caballos;
    public $fecha_venta,$estado,$any_matriculacion,$vendedor,$marca,$color;
    
    
    //método que guarda un vehiculo
    public function guardar(){
        //conectar con la base de datos
        $conexion = Database::get();
        
        //preparar la consulta de inserción
        $consulta = "INSERT INTO vehiculos (modelo, matricula, detalles,imagen,precio_compra,kms,caballos,estado,any_matriculacion,marca,color)
                    VALUES (
                    '$this->modelo', 
                    '$this->matricula', 
                     '$this->detalles',
                    '$this->imagen',
                    $this->precio_compra,
                    $this->kms,
                    $this->caballos,
                    $this->estado,
                    $this->any_matriculacion,
                    '$this->marca',
                    '$this->color');";
      
        //lanzar la consulta
        return $conexion->query($consulta);
    }
    
    //método que me recupera el total de vehiculos (incluso con filtros)
    public static function getTotal($t='', $c='matricula'){
        $consulta = "SELECT * FROM vehiculos
                         WHERE $c LIKE '%$t%'";
        
        $conexion = Database::get();
        $resultados = $conexion->query($consulta);
        $total = $resultados->num_rows;
        $resultados->free();
        return $total;
    }
    
    //método que me recupere todos los vehiculos
    //PROTOTIPO: public static array<VehiculoModel> getVehiculoss()
    public static function getVehiculos($l=10, $o=0, $t='', $c='matricula', $co='id', $so='ASC'){
        //preparar la consulta
        $consulta = "SELECT * FROM vehiculos
                         WHERE $c LIKE '%$t%'
                         ORDER BY $co $so
		                 LIMIT $l
		                 OFFSET $o;";
        
        //conecto a la BDD y ejecuto la consulta
        $conexion = Database::get();
        $resultados = $conexion->query($consulta);
        
        //creo la lista de RecetaModel
        $lista = array();
        while($vehiculo = $resultados->fetch_object('VehiculoModel'))
            $lista[] = $vehiculo;
            
            //liberar memoria
            $resultados->free();
            
            //retornar la lista de RecetaModel
            return $lista;
    }
    
    //Método que me recupera una vehiculo a partir de su ID
    //PROTOTIPO: public static VehiculoModel getVehiculo(number $id=0);
    public static function getVehiculo($id=0){
        //preparar consulta
        $consulta = "SELECT * FROM vehiculos WHERE id=$id;";
        
        //ejecutar consulta
        $conexion = Database::get();
        $resultado = $conexion->query($consulta);
        
        //si no había resultados, retornamos NULL
        if(!$resultado) return null;
        
        //convertir el resultado en un objeto RecetaModel
        $vehiculo = $resultado->fetch_object('VehiculoModel');
        
        //liberar memoria
        $resultado->free();
        
        //devolver el resultado
        return $vehiculo;
    }
    
    //actualiza los datos del vehiculo en la BDD
    //PROTOTIPO: public boolean actualizar();
    public function actualizar(){
        $consulta = "UPDATE vehiculos
					       SET matricula='$this->matricula',
						      modelo='$this->modelo',
                              color='$this->color',
                              precio_venta=$this->precio_venta,
						  	  precio_compra=$this->precio_compra,
                              kms=$this->kms,
                              caballos=$this->caballos,
                              estado=$this->estado,
                              any_matriculacion=$this->any_matriculacion,
                              detalles='$this->detalles',
                              vendedor=$this->vendedor,
                              marca='$this->marca',
                              imagen='$this->imagen'
						  WHERE id=$this->id;";
        return Database::get()->query($consulta);
    }
        
    //Método que borra un vehiculo de la BDD (estático)
    //PROTOTIPO: public static boolean borrar(int $id)
    public static function borrar($id){
        $consulta = "DELETE FROM vehiculos
                         WHERE id=$id;";
        
        $conexion = Database::get(); //conecta
        $conexion->query($consulta); //ejecuta consulta
        return $conexion->affected_rows; //devuelve el num de filas afectadas
    }
    
    //actualiza el estado del vehiculo y informa la fecha del sistema del vehiculo en la BDD
    //PROTOTIPO: public boolean actualizar();
    public function actualizarestado(){
        $consulta = "UPDATE vehiculos
					       SET 
                              precio_venta=$this->precio_venta,
						  	  fecha_venta='$this->fecha_venta',
                              estado=$this->estado,
                              vendedor=$this->vendedor
                            WHERE id=$this->id;";
        return Database::get()->query($consulta);
    }
}



    
  ?>  