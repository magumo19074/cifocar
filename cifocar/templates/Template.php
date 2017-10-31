<?php
	class Template{	
		
		//PONE EL HEADER DE LA PAGINA
		public static function header(){	?>
			<header>
				<figure>
					<a href="index.php">
						<img alt="car logo" src="images/logos/coche.png" /></a>
				</figure>
				<hgroup>
					<h1 class="color">CIFOCAR VALLES</h1>
				
				</hgroup>
			</header>
		<?php }
		
		
		//PONE EL FORMULARIO DE LOGIN
	    public static function login(){?>
	    
	    <div class="formlog" style="text-align: center;margin-right:20px">
	    	
	    	<form method="post" id="logino" autocomplete="off">
				<label>User:</label><input type="text" name="user" required="required" /><br/>
				<label>Password:</label><input type="password" name="password" required="required"/><br/>
				<input class="botologin" type="submit" name="login" value="Login" />
				
			</form>
	    
	    </div>
			
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
		
			
			
			<a class="menuinici" href="index.php">Inicio</a>
			<section > 
				<?php 
				//pone el menú del administrador
				    if($usuario && $usuario->admin){	?>
					<a  class="menuinici" href="index.php?controlador=Vehiculo&operacion=listar">Listado de vehiculos</a>
					<a  class="menuinici" href="index.php?controlador=Usuario&operacion=registro">Nuevo usuario</a>
					<a  class="menuinici" href="index.php?controlador=Usuario&operacion=listar">Listado de usuarios</a>
			</section>		
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
				
			
			</footer>
		<?php }
	}
?>