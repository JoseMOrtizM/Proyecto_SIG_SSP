<!------------------------------------ CARRUSEL 01 -------------------------->
<?php
	require("php_require/conexion.php");
	if(!isset($ruta_actual)){
		$consulta="SELECT * FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `ID`"; 
	}else{
		if($ruta_actual=="zona_principal.php"){
			$consulta="SELECT * FROM `portada` WHERE `TIPO`='SERVICIO' ORDER BY `ID`"; 
		}else{
			$consulta="SELECT * FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `ID`"; 
		}
	}
	$resultados=mysqli_query($conexion,$consulta); 
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['FOTO_CARRUSEL'][$i]=$fila['FOTO_CARRUSEL'];
		$i=$i+1;
	}
	$slides=$i;
	mysqli_close($conexion);
?>
<div id="myCarousel" class="my-1 carousel slide img-fluid" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<?php 
			$i=1;
			while($i<$slides){
				echo "<li data-target='#myCarousel' data-slide-to='$i'></li>";
				$i=$i+1;
			}
		?>
	</ol>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<div class="marco-ajustado hidden" width="100%">
				<img class="first-slide imgFit" src="img/<?php echo $datos['FOTO_CARRUSEL'][0]; ?>" alt="<?php echo $datos['NOMBRE'][0]; ?>" width="100%">
			</div>
			<div class="bg-dark">
				<h3 class="text-center text-white pb-4"><?php echo $datos['NOMBRE'][0]; ?></h3>
			</div>
		</div>
		<?php 
			$i=1;
			while(isset($datos['NOMBRE'][$i])){
		?>
		<div class="carousel-item">
			<div class="marco-ajustado hidden" width="100%">
				<img class="second-slide imgFit" src="img/<?php echo $datos['FOTO_CARRUSEL'][$i]; ?>" alt="<?php echo $datos['NOMBRE'][$i]; ?>" width="100%">
			</div>
			<div class="bg-dark">
				<h3 class="text-center text-white pb-4"><?php echo $datos['NOMBRE'][$i]; ?></h3>
			</div>
		</div>
		<?php
				$i=$i+1;
			}
		?>
	</div>
	<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	</a>
	<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
	</a>
</div>
