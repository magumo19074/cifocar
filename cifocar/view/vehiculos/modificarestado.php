<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificar el estado del vehiculo <?php echo $vehiculo->matricula;?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			Template::header(); //pone el header

			if(!$usuario) Template::login(); //pone el formulario de login
			else Template::logout($usuario); //pone el formulario de logout
			
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			
			<h2>Modificar el estado del vehiculo <?php echo $vehiculo->matricula;?></h2>
			
			<div class="contenedor">
    			<form class="texto" method="post" enctype="multipart/form-data" autocomplete="off">
    				
    				<label>Estado:</label>
					<select name="estado">
						<option value=0 <?php if($vehiculo->estado==0) echo "selected='selected'";?>>en venta</option>
						<option value=1 <?php if($vehiculo->estado==1) echo "selected='selected'";?>>reservado</option>
						<option value=2 <?php if($vehiculo->estado==2) echo "selected='selected'";?>>vendido</option>
						<option value=3 <?php if($vehiculo->estado==3) echo "selected='selected'";?>>devolución</option>
						<option value=4 <?php if($vehiculo->estado==4) echo "selected='selected'";?>>baja</option>
					</select><br/>
					
					<label>Precio de venta:</label>
					<input type="number" name="precio_venta" required="required"
					value="<?php echo $vehiculo->precio_venta;?>" /><br/>

    				<input type="submit" name="modificar" value="modificar"/><br/>
    			</form>
    			<br/>
    			<div class="imagen">
        			<figure>
            			<?php 
            			echo "<img src='$vehiculo->imagen' alt='Imagen de $vehiculo->matricula' title='Imagen de $vehiculo->matricula'/>";
            			echo "<figcaption>Imagen actual de la receta</figcaption>";
            			?>
            		</figure>
            	</div>	
        	</div>
        		
        	<p class="volver" onclick="history.back();">Atrás</p>	
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>