<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificación de datos de usuario</title>
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
			
			
			<h2>Formulario de modificación de datos</h2>
			
			<div class="contenedor">
    			<article class="texto3">
			
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				
				
				<h2>Datos a modificar</h2>
			    <label>Email:</label>
				<input type="email" name="email" required="required" 
					value="<?php echo $usuarios->email;?>"/><br/>
					
				<label>Administrador</label>
				<input type="checkbox" name="admin" <?php if($usuarios->admin) echo "checked='checked'"?>>Administrador<br/>
				<br/>
					
				<label>Privilegio:</label>
				<select name="privilegio">
    					<option value="0" <?php if($usuarios->privilegio==0) echo "selected='selected'";?>>Administrador</option>
    					<option value="1" <?php if($usuarios->privilegio==1) echo "selected='selected'";?>>Responsable de compras</option>
    					<option value="2" <?php if($usuarios->privilegio==2) echo "selected='selected'";?>>Vendedor</option>
    			</select><br/>
					
				
				<label>Nueva imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" />
				<br/>
				
				</article>
				
				<figure class="imagen">
					<img src="<?php echo $usuarios->imagen;?>" 
						alt="<?php echo  $usuarios->user;?>" />
				</figure>
				</div>
				<input style="margin-left: 300px" class="botonok2" type="submit" name="modificar" value="modificar"/><br/>
		</form>
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>
