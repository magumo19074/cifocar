<?php
//definición de la clase Juegos
class VehiculoModel{
    //propiedades "¿qué tienen?"
    public $id, $matricula, $detalles, $modelo,$precio_venta,$imagen,$precio_compra,$kms,$caballos;
    public $fecha_venta,$estado,$any_matriculacion,$vendedor,$marca,$color;
    
    //métodos "¿Qué podemos hacer con ellos?"
    //método que guarda un vehiculo
    public function guardar(){
        //conectar con la base de datos
        $conexion = Database::get();
        
        //preparar la consulta de inserción
        $consulta = "INSERT INTO vehiculos (id, modelo, matricula, detalles,precio_venta,imagen,precio_compra,kms,caballos,fecha_venta,estado,any_matriculacion,vendedor,marca,color)
                         VALUES(DEFAULT, '$this->modelo', '$this->matricula', '$this->detalles','$this->precio_venta','$this->imagen','$this->precio_compra','$this->kms','$this->caballos','$this->fecha_venta','$this->estado','$this->any_matriculacion','$this->vendedor','$this->marca','$this->color');";
        
        //lanzar la consulta
        return $conexion->query($consulta);
    }
    
    
    //método que recupera todos los vehiculos
    public static function recuperarTodo($l=10,$o=0,$t='', $c='modelo', $co='id', $so='ASC'){
        //conectar con la BDD
        $conexion = Database::get();
        
        //preparar la consulta
        $consulta = "SELECT * FROM vehiculos WHERE $c LIKE '%$t%'
                         ORDER BY $co $so LIMIT $l OFFSET $o;";

       //ejecutar la consulta
        $resultado = $conexion->query($consulta);
        
        //crear la lista de vehiculos
        $lista = array();
        while($vehiculos = $resultado->fetch_object('VehiculoModel')){
            $lista[] = $vehiculos;
        }
        
        //liberar memoria
        $resultado->free();
        
        //retornar la lista de vehiculos
        return $lista;
    }
    
    
    //método que recupera un vehiculo a partir de una id
    public static function getVehiculo($id=0){
        //conectar con la BDD
        $conexion = Database::get();
        
        //preparar la consulta
        $consulta = "SELECT * FROM vehiculos WHERE id=$id";
        
        //ejecutar la consulta
        $resultado = $conexion->query($consulta);
        if(!$resultado)return null;
        
        //convierte el resultado a un objeto de tipo "Vehiculos"
        $vehiculos = $resultado->fetch_object('VehiculoModel');
        
        //liberar memoria
        $resultado->free();
        
        //retornar el resultado
        return $vehiculos;
    }
    
    //método que actualiza un vehiculo en la BDD
    public function actualizar(){
        //conectar con la BDD
        $conexion = Database::get();
        
        //preparar la consulta
        $consulta = "UPDATE vehiculos SET
                    modelo='$this->modelo',
                    matricula='$this->matricula',
                    color='$this->color',
                    precio_venta=$this->precio_venta,
                    precio_compra=$this->precio_compra,
                    kms=$this->kms,
                    caballos=$this->caballos,
                    fecha_venta=$this->fecha_venta,
                    estado=$this->estado,
                    any_matriculacion=$this->any_matriculacion,
                    detalles=$this->detalles,
                    vendedor='$this->precio',
                    marca='$this->marca',
                    imagen='$this->imagen'
                WHERE id=$this->id;";
        
        //echo $consulta;
        
        //ejecutar la consulta
        return $conexion->query($consulta);
    }
    
    
    //borra un vehiculo de la BDD (de objeto)
    //PROTOTIPO:public boolean borrar()
    public  function borrar2(){
        //conectar con la BDD
        $conexion = Database::get();
        
        //preparar la consulta
        $consulta = "DELETE FROM vehiculos WHERE id=$this->id;";
        
        
        //ejecutar la consulta
        $conexion->query($consulta);
        
        //retornar el número de filas afectadas
        return $conexion->affected_rows;
    }
    
    
    //borra un vehiculo de la BDD (estatico)
    //PROTOTIPO:public static boolean borrar(int $id)
    public static function borrar($id){
        //conectar con la BDD
        $conexion = Database::get();
        
        //preparar la consulta
        $consulta = "DELETE FROM vehiculos WHERE id=$id;";
        
        
        //ejecutar la consulta
        $conexion->query($consulta);
        
        //retornar el número de filas afectadas
        return $conexion->affected_rows;
    }
    
    //método que me recupera el total de registros (incluso con filtros)
    public static function getTotal($t='', $c='modelo'){
        $consulta = "SELECT * FROM vehiculos
                     WHERE $c LIKE '%$t%'";
            
            $conexion = Database::get();
            $resultados = $conexion->query($consulta);
            $total = $resultados->num_rows;
            $resultados->free();
            return $total;
        }

}
?>
