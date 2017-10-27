<?php
    require_once '../../config/Config.php';
    require_once '../../libraries/database_library.php';
    require_once '../MarcaModel.php';
    
    //TEST GUARDAR
    //MarcaModel::guardar('Renault');
    
    
    //TEST RECUPERAR
    //var_dump(MarcaModel::getMarcas());
    
    //devuelve todas las marcas
   // $marcas = MarcaModel::getMarcas(3,0,'t','ASC');
 //  foreach ($marcas as $m){
 //       echo "<p>$m->marca</p>";
   // }
    
    //test avtualizar
    //echo MarcaModel::actualizar('citroen','CITROEN')
    
    //test borrar
   echo MarcaModel::borrar('SEAT');
?>


