<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Confirmar borrado de <?php echo $vehiculo->matricula;?></title>
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
			<h2>Confirmar borrado de <?php echo $vehiculo->matricula;?></h2>
			
			<p>Estos son los datos del vehiculo a borrar:</p>
			
			<div class="contenedor">
				<div class="texto">
        			<h3>Matricula</h3>
        			<p><?php echo $vehiculo->matricula;?></p>
        			
        			<h3>Modelo</h3>
        			<p><?php echo $vehiculo->modelo;?></p>
        			
        	
        			<form method="POST">
        				<label>Estas seguro?</label>
        				<input type="submit" name="confirmarborrado" value="Confirmar" />
        				<input type="button" onclick="history.back();" value="Cancelar"/>
        			</form>
    			</div>
    			
    			<figure class="imagen">
        			<?php 
        			echo "<img src='$vehiculo->imagen' alt='Imagen de $vehiculo->matricula' title='Imagen de $vehiculo->matricula'/>";
        			echo "<figcaption>$vehiculo->matricula</figcaption>";
        			?>
        		</figure>	
    		</div>
    		
    		<p class="volver" onclick="history.back();">Atrás</p>
    		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>