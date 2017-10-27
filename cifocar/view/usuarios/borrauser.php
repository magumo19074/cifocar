<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta charset="UTF-8">
		<title>Borrar usuario</title>
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
			<h2>Borrar un usuario</h2>
			
		       <h3>Usuario a eliminar de la base de datos</h3>
            
            <form method="post">
            
           		 <figure>
					<img class="imagenactual" src="<?php echo $usuarioM->imagen;?>" 
						alt="<?php echo  $usuarioM->user;?>" />
				 </figure>
				
				<label>Usuario</label>
				<input type="text" name="usuario"  value="<?php echo $usuarioM->user;?>" /><br/>
				<label>Password</label>
				<input type="text" name="password" value="<?php echo $usuarioM->password;?>" /><br/>
				<label>Email</label>
				<input type="text" name="email"  value="<?php echo $usuarioM->email;?>" /><br/>
				<label>Admin</label>
				<input type="text" name="admin"  value="<?php echo $usuario->admin;?>" /><br/>
				<label>Privilegio</label>
				<input type="text" name="privilegio"  value="<?php echo $usuarioM->privilegio;?>" /><br/>
				
				
				<label>Seguro que quieres borralo?</label>
				<input  class="botologin" type="submit" name="borrar" value="borrar"/>
				<input class="botologin" type="button" name="cancelar" value="Cancelar" onclick="history.back()">
			</form><br>
			
			<p class="volver" onclick="history.back();">Atrás</p>
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>
