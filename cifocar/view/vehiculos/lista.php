<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Listado de vehiculos</title>
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
			<h2>Listado de vehiculos</h2>
			
			<p class="infolista">Hay <?php echo $totalRegistros; ?> registros<?php echo $filtro? ' para el filtro indicado':'';?>, 
			mostrando del <?php echo ($paginaActual-1)*$regPorPagina+1;?> al <?php echo ($paginaActual-1)*$regPorPagina+sizeof($vehiculos);?>.</p>
			
			<?php if(!$filtro){?>
			<form method="post" class="filtro" action="index.php?controlador=Vehiculo&operacion=listar&parametro=1">
				<label>Filtro:</label>
				<input type="text" name="texto" placeholder="buscar..."/>
				<select name="campo">
					<option value="marca">marca</option>
					<option value="modelo">modelo</option>
					<option value="matricula">matricula</option>
					<option value="estado">estado</option>
					<option value="color">color</option>
				</select>
				<label>Orden:</label>
				<select name="campoOrden">
					<option value="any_matriculacion">año matriculación</option>
					<option value="caballos">caballos</option>
					<option value="kms">kms</option>
					<option value="precio_venta">precio de venta</option>
				</select>
				<select name="sentidoOrden">
					<option value="ASC">ascendente</option>
					<option value="DESC">descendente</option>
				</select>
				<input type="submit" name="filtrar" value="Filtrar"/>
			</form>
			<?php }else{ ?>
			    <form method="post" class="filtro" action="index.php?controlador=Vehiculo&operacion=listar&parametro=1">
			    	<label>Quitar filtro (<?php echo $filtro->campo.": '".$filtro->texto."', ordenado: ".$filtro->campoOrden." ".$filtro->sentidoOrden;?>)</label>
			    	<input type="submit" name="quitarFiltro" value="Quitar" />
			    </form>
			<?php }?>
			
			<table>
				<tr>
					<th>Imagen</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Matricula</th>
					<th>Año</th>
					<th>Caballos</th>
					<th>Kms</th>
					<th>Estado</th>
					<th>Color</th>
					<th>Precio de Venta</th>
					<th colspan="2">Operaciones</th>
				</tr>
				<?php 
				foreach($vehiculos as $vehiculo){
				    echo "<tr>";
				        echo "<td class='foto'><img class='miniatura' src='$vehiculo->imagen' alt='Imagen de $vehiculo->matricula' title='Imagen de $vehiculo->matricula'/></td>";
				        echo "<td>$vehiculo->marca</td>";			      
				        echo "<td>$vehiculo->modelo</td>";
				        echo "<td>$vehiculo->matricula</td>";
				        echo "<td>$vehiculo->any_matriculacion</td>";
				        echo "<td>$vehiculo->caballos</td>";
				        echo "<td>$vehiculo->kms</td>";
				        echo "<td>";
			             switch($vehiculo->estado){
			             case 0: echo 'en venta=0'; break;
			             case 1: echo 'reservado'; break;
			             case 2: echo 'vendido'; break;
			             case 3: echo 'devolucion'; break;
			             case 4: echo 'baja'; break;
			             }
				         echo "</td>";
				        echo "<td>$vehiculo->color</td>";
				        echo "<td>$vehiculo->precio_venta</td>";
				        
				        echo "<td class='foto'><a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'>
                        <img class='boton' src='images/buttons/view.png' alt='ver detalles' title='ver detalles'/></a></td>";
				    
				        //lo que ve elcomprador				        
				        if(Login::getUsuario() && Login::getUsuario()->privilegio==1){
				            echo "<td class='foto'><a href='index.php?controlador=Vehiculo&operacion=editar&parametro=$vehiculo->id'>
                            <img class='boton' src='images/buttons/edit.png' alt='editar' title='editar'/></a></td>";
				        }				        
				        //lo que el vendedor
				        if(Login::getUsuario() && Login::getUsuario()->privilegio==2){
				        echo "<td class='foto'><a href='index.php?controlador=Vehiculo&operacion=editarestado&parametro=$vehiculo->id'>
                            <img class='boton' src='images/buttons/edit.png' alt='editar' title='editar'/></a></td>";
				        }
				        //lo que ve el administrador
				        if(Login::isAdmin()){
				            echo "<td class='foto'><a href='index.php?controlador=Vehiculo&operacion=borrar&parametro=$vehiculo->id'><img class='boton' src='images/buttons/delete.png' alt='borrar' title='borrar'/></a></td>";
				        }
				        echo "</tr>";
				}
				?>
			</table>
			<ul class="paginacion">
				<?php
    				//poner enlace a la página anterior
    				if($paginaActual>1){
    				    echo "<li><a href='index.php?controlador=Vehiculo&operacion=listar&parametro=1'>Primera</a></li>";
    				}
				
				    //poner enlace a la página anterior
    				if($paginaActual>2){
    				    echo "<li><a href='index.php?controlador=Vehiculo&operacion=listar&parametro=".($paginaActual-1)."'>Anterior</a></li>";
    				}
				    //poner enlace a la página siguiente
    				if($paginaActual<$paginas-1){
    				    echo "<li><a href='index.php?controlador=Vehiculo&operacion=listar&parametro=".($paginaActual+1)."'>Siguiente</a></li>";
    				}
    				
				    //Poner enlace a la última página
				    if($paginas>1 && $paginaActual<$paginas){
				        echo "<li><a href='index.php?controlador=Vehiculo&operacion=listar&parametro=$paginas'>Ultima</a></li>";
				    }
				?>
			</ul>
			<p class="infolista">Viendo la página <?php echo $paginaActual.' de '.$paginas; ?> páginas de resultados</p>
			
			
			<p class="volver" onclick="history.back();">Atrás</p>
		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>