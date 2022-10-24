<!doctype html>
<html lang="es">
	<head>
		<?php require("php_require/seo_meta.php") ?>
		<?php require("php_require/head.php") ?>
		<title>SSP-Quiénes Somos</title>
	</head>
	<body>
		<?php require("php_require/nav_index.php") ?>
		<section class="container px-5 pt-4 mt-5 mb-4">
			<div class="container text-justify">
				<?php 
					require("php_require/conexion.php"); 
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='NOSOTROS' AND `IDIOMA`='$lang'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
					mysqli_close($conexion);
					
				?>
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