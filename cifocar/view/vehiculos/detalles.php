<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Detalles del vehiculo <?php echo $vehiculo->matricula;?></title>
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
			
			<h2>Detalles del vehiculo <?php echo $vehiculo->matricula;?></h2>
			
			<div class="contenedor">
    			<article class="texto">
        			
        			<label>Matricula: </label>
    					<?php echo $vehiculo->matricula;?><br/>
    					   					
					<label>Modelo: </label>
    					<?php echo $vehiculo->modelo;?><br/>
				
					<label>Color: </label>
						<?php echo $vehiculo->color;?><br/>
				
					<label>Precio de venta:</label>
						<?php echo $vehiculo->precio_venta;?><br/>
				
					<label>Precio de compra:</label>
						<?php echo $vehiculo->precio_compra;?><br/>
				
					<label>Kms:</label>
						<?php echo $vehiculo->kms;?><br/>			
				
					<label>Caballos:</label>
						<?php echo $vehiculo->caballos;?><br/>
				
					<label>Fecha de venta:</label>
						<?php echo $vehiculo->fecha_venta;?><br/>
				
					<label>Estado:</label>
						<?php if($vehiculo->estado==0) echo "en venta";
						      if($vehiculo->estado==1) echo "reservado";
						      if($vehiculo->estado==2) echo "vendido";
							  if($vehiculo->estado==3) echo "devolución";
							  if($vehiculo->estado==4) echo "baja";
					     ?>
					<br/>
				
					<label>Año matriculación:</label>
						<?php echo $vehiculo->any_matriculacion;?><br/>
				
					<label>Detalles:</label>
						<?php echo $vehiculo->detalles;?><br/>
				
					<label>Vendedor:</label>
						<?php echo $vehiculo->vendedor;?><br/>
				
					<label>Marca:</label>
						<?php echo $vehiculo->marca;?><br/>    				
    			</article>	
  				    			
    			<figure class="imagen">
            			<?php 
            			echo "<img src='$vehiculo->imagen' alt='Imagen del $vehiculo->matricula' title='Imagen del $vehiculo->matricula'/>";
            			echo "<figcaption>$vehiculo->matricula</figcaption>";
            			?>
            		</figure>
            	</div>	
        		
    		<p class="volver" onclick="history.back();">Atrás</p>
    		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>