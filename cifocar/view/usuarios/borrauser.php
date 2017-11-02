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
		
		<figure id="imagenjuego" style="float:right">
		    	<img class="caratula" src="<?php echo $usuarioM->imagen;?>">
		    	<figcaption style="color:green;text-align:center"><?php echo $usuarioM->user?></figcaption>
		 </figure>
			<h2>Borrar un usuario</h2>
			
		       <h3>Usuario a eliminar de la base de datos</h3>
            
            <div class="contenedor">
				<article class="texto">
			
			<h3>Usuario</h3>
            <p> <?php echo $usuarioM->user;?> </p>
            
            <h3>Nombre</h3>
            <p><?php echo $usuarioM->nombre;?></p>
            
            <h3>Email</h3>
            <p><?php echo $usuarioM->email;?></p>
            
            <h3>Admin</h3>
            <p>  <?php if($usuarioM->admin==1)
                        echo '<p>Adminstrador</p>';
                      ?>
                     <?php if($usuarioM->admin==0)
                          echo '<p>No administrador</p>';
                       ?>
            
           <?php echo '<h3>Privilegio</h3>';
                  switch($usuarioM->privilegio){
			        case 0: echo 'Administrador'; break;
			        case 1: echo 'Responsable de compras'; break;
			        case 2: echo 'Vendedor'; break;
			             
			             }?>
           
            
            <h3>Fecha alta</h3>
            <p><?php  echo $usuarioM->fecha;?></p>
            
            </article>
           </div>
           <form method="post">
				<label>¿Seguro que quieres borrarlo?</label>
				<input  class="botonok2" type="submit" name="borrar" value="borrar"/>
				<input class="botonok" type="button" name="cancelar" value="Cancelar" onclick="history.back()">
			</form><br>
			
			<p class="volver" onclick="history.back();">Atrás</p>
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>
