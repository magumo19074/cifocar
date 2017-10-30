<?php
require_once '../../config/Config.php';
require_once '../../libraries/database_library.php';
require_once '../MarcaModel.php';

//en el controlador VEHICULO en el metodo nievo nehiculo antes de mostrar el formulario
$marcas = MarcaModel::getMarcas();
?>
<select name="marca">
<?php foreach ($marcas as $m){
    echo "<option value='$m->marca'>$m->marca</option>";
    
}?>

</select>