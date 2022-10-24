<?php
	if(isset($_GET['lang'])){
		require("php_require/conexion.php"); 
		$lang=mysqli_real_escape_string($conexion, $_GET['lang']);
		mysqli_close($conexion);
	}else{
		$lang='Español';
	}
?>
<!-------------------- NAV BAR PARA INDEX------------------------------------>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top py-0 px-5 my-0">
	<a class="navbar-text" style="width: 150px" href="index.php">
		<!-- LOGO ANIMADO COM "amazingslider"-->
		<div id="amazingslider-wrapper-1" style="max-width:140px;height: 38px; margin:0px auto 0px;border:#000 0px solid; overflow:hidden; background-color:transparent">
			<div id="amazingslider-1" style="margin:0 auto;">
				<ul class="amazingslider-slides" style="display:none;">
					<li><img src="img/<?php require("php_require/conexion.php"); $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='LOGO'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; mysqli_close($conexion); ?>"/>
					</li>
					<li><img src="img/<?php require("php_require/conexion.php"); $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='LOGO'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; mysqli_close($conexion); ?>"/>
					</li>
				</ul>
			</div>
		</div>
	</a>
	<?php
	if($lang=="Ruso"){
	?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExample04">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-light" href="" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Наши услуги">Услуги</a>
					<div class="dropdown-menu p-3 bg-dark" style="width: 300px;" aria-labelledby="dropdown04">
						<?php 
							require("php_require/conexion.php"); 
							$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `NOMBRE`"; 
							$resultados=mysqli_query($conexion,$consulta); 
							while(($fila=mysqli_fetch_array($resultados))==true){
								echo "
									<a class='d-block text-light py-2 border-danger border-bottom' href='servicios.php?lang=Ruso&nombre=" . $fila['NOMBRE'] . "'><span class='text-muted fa fa-cog fa-spin'></span> " . $fila['NOMBRE'] . "</a>
								";
							}
							mysqli_close($conexion);
						?>
					</div>
				</li>
				<li class="nav-item"><a class="nav-link text-light" href="nosotros.php?lang=Ruso" title="Наша компания">Нам</a></li>
				<li class="nav-item"><a class="nav-link text-light" href="form_contactanos.php?lang=Ruso" title="Оставьте нам свои комментарии">Свяжитесь с нами</a></li>
				<!-- COMENTADO MIENTRAS SE DEFINEN LOS CARGOS EN TODOS LOS IDIOMAS
				<li class="nav-item"><a class="nav-link text-light" href="form_empleo.php" title="Registra tu Curriculum">Empleo</a></li>
				-->
				<li class="nav-item h4"><a class="nav-link text-light fa fa-home" href="index.php?lang=Ruso" title="Дома"></a></li>
				<li class="nav-item"><b class="nav-link">
					<form method="get" id="changelang" name="changelang">
						<select class="rounded-0 px-1" onchange="document.changelang.submit()" name="lang" id="lang">
							<option value="Ruso">русский</option>
							<option value="Español">испанский</option>
							<option value="Ingles">английский</option>
						</select>
					</form>
				</b></li>
			</ul>
		</div>
	<?php
	}else if($lang=="Ingles"){
	?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExample04">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-light" href="" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Our Services">Services</a>
					<div class="dropdown-menu p-3 bg-dark" style="width: 300px;" aria-labelledby="dropdown04">
						<?php 
							require("php_require/conexion.php"); 
							$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `NOMBRE`"; 
							$resultados=mysqli_query($conexion,$consulta); 
							while(($fila=mysqli_fetch_array($resultados))==true){
								echo "
									<a class='d-block text-light py-2 border-danger border-bottom' href='servicios.php?lang=Ingles&nombre=" . $fila['NOMBRE'] . "'><span class='text-muted fa fa-cog fa-spin'></span> " . $fila['NOMBRE'] . "</a>
								";
							}
							mysqli_close($conexion);
						?>
					</div>
				</li>
				<li class="nav-item"><a class="nav-link text-light" href="nosotros.php?lang=Ingles" title="Our company">Our company</a></li>
				<li class="nav-item"><a class="nav-link text-light" href="form_contactanos.php?lang=Ingles" title="Leave us your comments">Contact us</a></li>
				<!-- COMENTADO MIENTRAS SE DEFINEN LOS CARGOS EN TODOS LOS IDIOMAS
				<li class="nav-item"><a class="nav-link text-light" href="form_empleo.php" title="Registra tu Curriculum">Empleo</a></li>
				-->
				<li class="nav-item h4"><a class="nav-link text-light fa fa-home" href="index.php?lang=Ingles" title="Home"></a></li>
				<li class="nav-item"><b class="nav-link">
					<form method="get" id="changelang" name="changelang">
						<select class="rounded-0 px-1" onchange="document.changelang.submit()" name="lang" id="lang">
							<option value="Ingles">English</option>
							<option value="Español">Spanish</option>
							<option value="Ruso">Russian</option>
						</select>
					</form>
				</b></li>
			</ul>
		</div>
	<?php
	}else{
	?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExample04">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-light" href="" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Autenticación para trabajadores">
						<?php
							if(isset($_GET['user'])==true){
								if($_GET['user']=='invalido'){ echo "<b class='text-danger mr-2'>Datos Invalidos</b>"; }
							}else{
								if(isset($_GET['inactividad'])==true){
									if($_GET['inactividad']=='si'){ echo "<b class='text-danger mr-2'>Cerrado por Inactividad</b>"; }
								}
							}
						?>
						Ingresa
					</a>
					<div class="dropdown-menu p-2 text-center bg-dark" style="width: 300px" aria-labelledby="dropdown05">
						<h5 class="m-2 mb-3 text-white">Sólo para Empleados</h5>
						<div id="contenedor_verificacion" class="text-danger"></div>
						<form id="form_comp" name="form_comp" action="comprueba_usuario.php" method="post">
							<input class="form-control mb-2" type="email" id="correo" name="correo" required placeholder="Correo Electrónico" title="introduzca su Email"/>
							<input class="form-control mb-2" type="password" id="contrasena" name="contrasena" required placeholder="Contraseña" title="introduzca su Contraseña"/>
							<input class="btn btn-danger text-center text-light p-0 m-0 px-1 mb-2" type="submit" value="Ingresar"/>
						</form>
						<a class="h6 text-center mb-2 d-block text-white" href="form_recupera_datos.php" title="Recuperar Correo y Contraseña">¿Olvidó sus datos?</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-light" href="" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Nuestros Servicios">Servicios</a>
					<div class="dropdown-menu p-3 bg-dark" style="width: 300px;" aria-labelledby="dropdown04">
						<?php 
							require("php_require/conexion.php"); 
							$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `NOMBRE`"; 
							$resultados=mysqli_query($conexion,$consulta); 
							while(($fila=mysqli_fetch_array($resultados))==true){
								echo "
									<a class='d-block text-light py-2 border-danger border-bottom' href='servicios.php?lang=Español&nombre=" . $fila['NOMBRE'] . "'><span class='text-muted fa fa-cog fa-spin'></span> " . $fila['NOMBRE'] . "</a>
								";
							}
							mysqli_close($conexion);
						?>
					</div>
				</li>
				<li class="nav-item"><a class="nav-link text-light" href="nosotros.php?lang=Español" title="Nuestra empresa">Nosotros</a></li>
				<li class="nav-item"><a class="nav-link text-light" href="form_contactanos.php?lang=Español" title="Déjanos tus comentarios">Contáctanos</a></li>
				<li class="nav-item"><a class="nav-link text-light" href="form_empleo.php?lang=Español" title="Registra tu Curriculum">Empleo</a></li>
				<li class="nav-item h4"><a class="nav-link text-light fa fa-home" href="index.php?lang=Español" title="Inicio"></a></li>
				<li class="nav-item"><b class="nav-link">
					<form method="get" id="changelang" name="changelang">
						<select class="rounded-0 px-1" onchange="document.changelang.submit()" name="lang" id="lang">
							<option value="Español">Español</option>
							<option value="Ingles">Ingles</option>
							<option value="Ruso">Ruso</option>
						</select>
					</form>
				</b></li>
			</ul>
		</div>
	<?php
	}
	?>
</nav>
