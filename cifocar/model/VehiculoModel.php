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
    
}
    
  ?>  