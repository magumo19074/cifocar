<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Portada</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			Template::header(); //pone el header

			if($usuario) Template::logout($usuario); //pone el formulario de logout
		 
			
			Template::menu($usuario); //pone el menú de login
		?>

		<section id="content">
			<?php if(!$usuario){ ?>
			
			<form class="portada" method="post" id="login" autocomplete="off">
				<input class="user" type="text" placeholder="usuario" name="user" required="required" /><br/>
				<input class="pass" type="password" placeholder="clave" name="password" required="required"/><br/>
				<input class="botonok" type="submit" name="login" value="Login" />
			</form>
			
			
			<?php }?>
		</section>
		
		<?php Template::footer();?>
    </body> 
</html>