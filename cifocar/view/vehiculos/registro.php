<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta charset="UTF-8">
		<title>Registro de vehiculos</title>
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
			<h2>Formulario de registro de vehiculos</h2>
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				<label>Marca:</label>
				<input type="text" name="user" required="required" 
					pattern="^[a-zA-Z]\w{2,9}" title="3 a 10 caracteres (numeros, letras o guión bajo), comenzando por letra"/><br/>
				
				<label>Modelo:</label>
				<input type="text" name="modelo" required="required" 
					pattern=".{4,16}" title="4 a 16 caracteres"/><br/>
				
				<label>Matricula:</label>
				<input type="text" name="matricula" required="required"/><br/>
				
				<label>Kms:</label>
				<input type="number" name="kms" required="required"/><br/>
				
				<label>Caballos:</label>
				<input type="number" name="caballos" required="required"/><br/>
				
				<label>Año matriculacion:</label>
				<input type="date" name="any_matriculacion" required="required"/><br/>
				
				<label>Color:</label>
				<input type="text" name="color" required="required"/><br/>
				
				<label>Estado:</label>
				<input type="number" name="estado" required="required"/><br/>
				
				<label>Detalles:</label>
				<input type="text" name="detalles" required="required"/><br/>
				
				<label>Imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" />
				<span>max <?php echo intval($max_image_size/1024);?>kb</span><br />
				
				<label></label>
				<input type="submit" name="guardar" value="guardar"/><br/>
			</form>
		</section>
		
		<?php Template::footer();?>
    </body>
</html>