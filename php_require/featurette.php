<!---------------------------------- FEATURETTE ------------------------------------>
<hr class="featurette-divider">
<div class="row featurette">
	<div class="col-md-9">
		<?php 
			//TITULO
			require("php_require/conexion.php"); 
			$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='MISION' AND `IDIOMA`='$lang'"; 
			$resultados=mysqli_query($conexion,$consulta); 
			$fila=mysqli_fetch_array($resultados); 
			echo $fila['NOMBRE']; 
			mysqli_close($conexion);
		?>
		<?php 
			//DESCRIPCION
			require("php_require/conexion.php"); 
			$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='MISION' AND `IDIOMA`='$lang'"; 
			$resultados=mysqli_query($conexion,$consulta); 
			$fila=mysqli_fetch_array($resultados); 
			echo $fila['DESCRIPCION']; 
			mysqli_close($conexion);
		?>
	</div>
	<div class="col-md-3">
		<img class="featurette-image img-fluid rounded w-100" src="img/<?php require("php_require/conexion.php"); $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='MISION' AND `IDIOMA`='$lang'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; mysqli_close($conexion); ?>" alt="Misión">
	</div>
</div>
<hr class="featurette-divider">
<div class="row featurette">
	<div class="col-md-9 order-md-2">
		<?php 
			//TITULO
			require("php_require/conexion.php"); 
			$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='VISION' AND `IDIOMA`='$lang'"; 
			$resultados=mysqli_query($conexion,$consulta); 
			$fila=mysqli_fetch_array($resultados); 
			echo $fila['NOMBRE']; 
			mysqli_close($conexion);
		?>
		<?php 
			//DESCRIPCION
			require("php_require/conexion.php"); 
			$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='VISION' AND `IDIOMA`='$lang'"; 
			$resultados=mysqli_query($conexion,$consulta); 
			$fila=mysqli_fetch_array($resultados); 
			echo $fila['DESCRIPCION']; 
			mysqli_close($conexion);
		?>
	</div>
	<div class="col-md-3 order-md-1">
		<img class="featurette-image img-fluid rounded w-100" src="img/<?php require("php_require/conexion.php"); $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='VISION' AND `IDIOMA`='$lang'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; mysqli_close($conexion); ?>" alt="Visión">
	</div>
</div>
<hr class="featurette-divider">
<div class="row featurette">
	<div class="col-md-9">
		<?php 
			//TITULO
			require("php_require/conexion.php"); 
			$consulta="SELECT `NOMBRE` FROM `portada` WHERE `TIPO`='VALORES' AND `IDIOMA`='$lang'"; 
			$resultados=mysqli_query($conexion,$consulta); 
			$fila=mysqli_fetch_array($resultados); 
			echo $fila['NOMBRE']; 
			mysqli_close($conexion);
		?>
		<?php 
			//DESCRIPCION
			require("php_require/conexion.php"); 
			$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='VALORES' AND `IDIOMA`='$lang'"; 
			$resultados=mysqli_query($conexion,$consulta); 
			$fila=mysqli_fetch_array($resultados); 
			echo $fila['DESCRIPCION']; 
			mysqli_close($conexion);
		?>
	</div>
	<div class="col-md-3">
		<img class="featurette-image img-fluid rounded w-100" src="img/<?php require("php_require/conexion.php"); $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='VALORES' AND `IDIOMA`='$lang'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; mysqli_close($conexion); ?>" alt="Valores">
	</div>
</div>
<hr class="featurette-divider">
