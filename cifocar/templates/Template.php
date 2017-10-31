<?php
	class Template{	
		
		//PONE EL HEADER DE LA PAGINA
		public static function header(){	?>
			<header>
				<figure>
					<a href="index.php">
						<img alt="Robs Micro Framework logo" src="images/logos/logo2.png" />
					</a>
				</figure>
				<hgroup>
					<h1>CIFOCAR VALLES</h1>
					<h2>Tu concesionario se segunda mano del Valles</h2>
				</hgroup>
			</header>
		<?php }
		
		
		//PONE EL FORMULARIO DE LOGIN
	    public static function login(){?>
			<form method="post" id="login" autocomplete="off">
				<label>User:</label><input type="text" name="user" required="required" />
				<label>Password:</label><input type="password" name="password" required="required"/>
				<input class="botologin" type="submit" name="login" value="Login" />
				
			</form>
		<?php }
		
		
		//PONE LA INFO DEL USUARIO IDENTIFICADO Y EL FORMULARIOD E LOGOUT
		public static function logout($usuario){	?>
			<div id="logout">
				<span>
					Hola 
					<a href="index.php?controlador=Usuario&operacion=modificacion" title="modificar datos">
						<?php echo $usuario->nombre;?></a>
					<span class="mini">
						<?php echo ' ('.$usuario->email.')';?>
					</span>
					<?php if($usuario->admin) echo ', eres administrador';?>
				</span>
								
				<form method="post">
					<input class="botologin" type="submit" name="logout" value="Logout" />
				</form>
				
				<div class="clear"></div>
			</div>
		<?php }
		
		
		//PONE EL MENU DE LA PAGINA
		public static function menu($usuario){ ?>
			<body  >
			
		<section class="menuadmin">
		
			<div style="text-align: center">
			
			<a class="menuinici" href="index.php">Inicio</a>
			<!-- <ul class="menu"> -->
				<?php 
				//pone el menú del administrador
				    if($usuario && $usuario->admin){	?>
					<a  class="menuinici" href="index.php?controlador=Vehiculo&operacion=listar">Listado de vehiculos</a>
					<a  class="menuinici" href="index.php?controlador=Usuario&operacion=registro">Nuevo usuario</a>
					<a  class="menuinici" href="index.php?controlador=Usuario&operacion=listar">Listado de usuarios</a>
				<!-- </ul> -->		
				<?php }	?>
				
				
				<?php
				//pone el menu del comprador
				if($usuario && $usuario->privilegio==1){?>
				<a  class="menuinici" href="index.php?controlador=Vehiculo&operacion=listar">Listado de vehiculos</a>
				<a  class="menuinici" href="index.php?controlador=Marca&operacion=listar">Listado de marcas</a>
				<a class="menuinici" href="index.php?controlador=Marca&operacion=nuevo">Nueva marca</a>
				<a class="menuinici" href="index.php?controlador=Vehiculo&operacion=nuevo">Nuevo vehiculo</a>
				
				
				<?php } ?>
				
				
				<?php
				//pone el menu del vendedor
				if($usuario && $usuario->privilegio==2){?>
				><a class="menuinici"  href="index.php?controlador=Vehiculo&operacion=listar">Listado de vehiculos</a>
				>
				<?php } ?>
				
				</div>
				
				</section>
				
			</body>
		<?php }
		
		
		
		//PONE EL PIE DE PAGINA
		public static function footer(){	?>
			<footer>
				
			<p> 
				<img class="logo" alt="logo web" src="images/logos/logo2.png" />
				<a href="mailto:magumo19074@gmail.com">Contacto</a>. 
         		</p>
			</footer>
		<?php }
	}
?>