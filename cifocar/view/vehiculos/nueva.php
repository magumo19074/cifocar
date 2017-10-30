<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Nuevo vehiculo</title>
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
			<h2>Nuevo vehiculo</h2>
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				
				<label>Matricula:</label>
				<input type="text" name="matricula" required="required"/><br/>
				
				<label>Modelo:</label>
				<input type="text" name="modelo" required="required"/><br/>
				
				<label>Color:</label>
				<input type="text" name="color" required="required"/><br/>
				
				<label>Precio de compra:</label>
				<input type="number" name="precio_compra" required="required"/><br/>
				
				<label>Kms:</label>
				<input type="number" name="kms" required="required"/><br/>				
				
				<label>Caballos:</label>
				<input type="number" name="caballos" required="required"/><br/>
				
				<label>Estado:</label>
				<select name="estado">
					<option value=0>en venta</option>
					<option value=1>reservado</option>
					<option value=2>vendido</option>
					<option value=3>devolución</option>
					<option value=4>baja</option>
				</select><br/>
				
				<label>Año matriculación:</label>
				<input type="number" name="any_matriculacion" required="required"/><br/>
				
				<label>Detalles:</label>
				<input type="text" name="detalles" required="required"/><br/>
				
				<label>Imagen:</label>
				<input type="file" name="imagen" accept="image/*" required="required"/><br>
				
				<label>Marca:</label>			
					<select name="marca">
						<?php foreach ($marcas as $m){
                            echo "<option value='$m->marca'>$m->marca</option>";
    
                        }?>
                        </select>
                    <br/>   
				
				<input type="submit" name="guardar" value="guardar"/><br/>
			</form>
			
			<p class="volver" onclick="history.back();">Atrás</p>
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>