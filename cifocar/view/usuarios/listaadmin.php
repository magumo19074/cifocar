<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta charset="UTF-8">
		<title>Listado usuarios administrador</title>
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
			<h2>Listado de usuarios</h2>
			<p>Hay <?php echo sizeof($usuarios);?> usuarios en la lista </p>
			
			
			<table>
				<tr>
					<th>Imagen</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Email</th>
					<th>Privilegio</th>
					<th>Admin</th>
					<th colspan="3">Operaciones</th>
					
				</tr>
			<?php 
			 foreach ($usuarios as $usuario){
			     echo "<tr>";
			     echo "<td style='text-align:center'><img class='imagen' src='$usuario->imagen'/></td>";
			     echo "<td style='text-align:center'>$usuario->user</td>";
			    
			     echo "<td style='text-align:center'>$usuario->nombre</td>";
			     echo "<td style='text-align:right'>".$usuario->email."</td>";
			     echo "<td style='text-align:center'>$usuario->privilegio</td>";
			     echo "<td style='text-align:center'>$usuario->admin</td>";
			     
			    
			     echo "<td><a href='index.php?controlador=Usuario&operacion=verusuario&parametro=$usuario->user'><img class='boton' src='images/buttons/lupa2.png' alt='ver detalles' title='ver detalles'/></a></td>";
			     echo "<td><a href='index.php?controlador=Usuario&operacion=modificacionadmin&parametro=$usuario->user'><img class='boton' src='images/buttons/modif.png' alt='ver actualizar' title='ver actualizar'/></a></td>";
			     echo "<td><a name='borrar' href='index.php?controlador=Usuario&operacion=borraruser&parametro=$usuario->user'><img class='boton' src='images/buttons/basura.png' alt='ver borrar' title='ver borrar'/></a></td>";
			     
			     echo "</tr>";
			     
			 }
			?>	
			</table>
			<p>Viendo la página <?php echo $paginaActual.' de '.$paginas; ?> páginas de resultados</p>
            <ul class="paginacion">
                <?php
                    //poner enlace a la página anterior
                    if($paginaActual>1){
                        echo "<li><a href='index.php?controlador=Juego&operacion=listar&parametro=1'>Primera&nbsp;</a></li>";
                    }
                
                    //poner enlace a la página anterior
                    if($paginaActual>2){
                        echo "<li><a href='index.php?controlador=Juego&operacion=listar&parametro=".($paginaActual-1)."'> Anterior&nbsp; </a></li>";
                    }
                    //poner enlace a la página siguiente
                    if($paginaActual<$paginas-1){
                        echo "<li><a href='index.php?controlador=Juego&operacion=listar&parametro=".($paginaActual+1)."'> Siguiente &nbsp;</a></li>";
                    }
                    
                    //Poner enlace a la última página
                    if($paginas>1 && $paginaActual<$paginas){
                        echo "<li><a href='index.php?controlador=Juego&operacion=listar&parametro=$paginas'> Ultima&nbsp; </a></li>";
                    }
                ?>
            </ul>
            
			
			
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>


