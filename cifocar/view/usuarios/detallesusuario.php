<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta charset="UTF-8">
		<title>Detalle de los usuarios</title>
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
		
		 
		    <figure id="imagenjuego" style="float:right">
		    	<img class="caratula" src="<?php echo $us->imagen;?>">
		    	<figcaption style="color:green;text-align:center"><?php echo $us->user?></figcaption>
		    </figure>           
			<h2>Detalles del usuario <?php echo $us->user; ?> </h2>
			
			<div class="contenedor">
				<article class="texto">
			
			<h3>Usuario</h3>
            <p> <?php echo $us->user;?> </p>
            
            <h3>Nombre</h3>
            <p><?php echo $us->nombre;?></p>
            
            <h3>Email</h3>
            <p><?php echo $us->email;?></p>
            
            <h3>Admin</h3>
            <p><?php echo $us->admin;?></p>
            
            <h3>Privilegio</h3>
            <p><?php echo $us->privilegio;?></p>
            
            <h3>Fecha alta</h3>
            <p><?php  echo $us->fecha;?></p>
            
            </article>
           </div>
           <p class="volver" onclick="history.back();">Atrás</p>
            
	   </section>
		
		<?php Template::footer();?>
    </body>
</html>


