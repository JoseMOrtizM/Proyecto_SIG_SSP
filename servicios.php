<!doctype html>
<html lang="es">
	<head>
		<?php require("php_require/seo_meta.php") ?>
		<?php require("php_require/head.php") ?>
		<title>SSP-
			<?php 
				require("php_require/conexion.php"); 
				if(isset($_GET['nombre'])){
					echo $_GET['nombre'];
				}else{
					$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `NOMBRE`"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados);
					echo $fila['NOMBRE'];
				}
				mysqli_close($conexion);
			?>
		</title>
	</head>
	<body>
		<?php require("php_require/nav_index.php") ?>
		<section class="container px-5 pt-4 mt-5 mb-4">
			<div class="container text-justify">
				<h2 class="text-center text-body border-bottom mb-3 pb-3">
					<?php 
						require("php_require/conexion.php"); 
						if(isset($_GET['nombre'])){
							echo $_GET['nombre'];
						}else{
							$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `NOMBRE`"; 
							$resultados=mysqli_query($conexion,$consulta); 
							$fila=mysqli_fetch_array($resultados);
							echo $fila['NOMBRE'];
						}
						mysqli_close($conexion);
					?>
				</h2>
				<div class="container-fluid">
					<?php 
						require("php_require/conexion.php"); 
						if(isset($_GET['nombre'])){
							$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' AND `NOMBRE`='" . $_GET['nombre'] . "' ORDER BY `NOMBRE`"; 
							$resultados=mysqli_query($conexion,$consulta); 
							$fila=mysqli_fetch_array($resultados);
							echo $fila['DESCRIPCION'];
						}else{
							$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `NOMBRE`"; 
							$resultados=mysqli_query($conexion,$consulta); 
							$fila=mysqli_fetch_array($resultados);
							echo $fila['DESCRIPCION'];
						}
						mysqli_close($conexion);
					?>
				</div>
			</div>
			<div class="container text-center mt-4">
				<?php
					if($lang=="Ruso"){
						echo "<a class='btn btn-danger fa fa-home' href='index.php?lang=Ruso' title='Inicio'> Дома &raquo;</a>";
					}else if($lang=="Ingles"){
						echo "<a class='btn btn-danger fa fa-home' href='index.php?lang=Ingles' title='Inicio'> Home &raquo;</a>";
					}else{
						echo "<a class='btn btn-danger fa fa-home' href='index.php?lang=Español' title='Inicio'> Página de Inicio &raquo;</a>";
					}
				?>
			</div>
		</section>
		<?php require("php_require/footer.php") ?>
	</body>
</html>