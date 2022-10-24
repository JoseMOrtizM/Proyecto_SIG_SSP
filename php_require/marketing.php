<!------------------------------------ MARKETING ---------------------------------->
<div class="marketing">
	<?php
		require("php_require/conexion.php");
		$consulta="SELECT * FROM `portada` WHERE `TIPO`='SERVICIO' AND `IDIOMA`='$lang' ORDER BY `ID`"; 
		$resultados=mysqli_query($conexion,$consulta); 
		$i=0;
		while(($fila=mysqli_fetch_array($resultados))==true){
			$datos['NOMBRE'][$i]=$fila['NOMBRE'];
			$datos['DESCRIPCION_CORTA'][$i]=$fila['DESCRIPCION_CORTA'];
			$datos['FOTO'][$i]=$fila['FOTO'];
			$i=$i+1;
		}
		$i=0;
		while(isset($datos['NOMBRE'][$i])){
			echo "
			<div class='row mt-4 border-top pt-2'>
				<div class='col-lg-4'>
					<a href='servicios.php?lang=" . $lang . "&nombre=" . $datos['NOMBRE'][$i] . "'><img class='rounded-circle mb-2' src='img/" . $datos['FOTO'][$i] . "' alt='" . $datos['NOMBRE'][$i] . "' width='160px' height='140px'></a>
					<h3>" . $datos['NOMBRE'][$i] . "</h3>
					<p class='text-justify'>" . $datos['DESCRIPCION_CORTA'][$i] . "</p>
					<p class='text-center'><a class='btn btn-danger border border-dark' href='servicios.php?lang=" . $lang . "&nombre=" . $datos['NOMBRE'][$i] . "' role='button'><span class='fa fa-long-arrow-right'></span></a></p>
				</div>
				<div class='col-lg-4'>
			";
			if(isset($datos['NOMBRE'][$i+1])){
				echo "
					<a href='servicios.php?lang=" . $lang . "&nombre=" . $datos['NOMBRE'][$i+1] . "'><img class='rounded-circle mb-2' src='img/" . $datos['FOTO'][$i+1] . "' alt='" . $datos['NOMBRE'][$i+1] . "' width='160px' height='140px'></a>
					<h3>" . $datos['NOMBRE'][$i+1] . "</h3>
					<p class='text-justify'>" . $datos['DESCRIPCION_CORTA'][$i+1] . "</p>
					<p class='text-center'><a class='btn btn-danger border border-dark' href='servicios.php?lang=" . $lang . "&nombre=" . $datos['NOMBRE'][$i+1] . "' role='button'><span class='fa fa-long-arrow-right'></span></a></p>
				";
			}
			echo "
				</div>
				<div class='col-lg-4'>
				";
			if(isset($datos['NOMBRE'][$i+2])){
				echo "
					<a href='servicios.php?lang=" . $lang . "&nombre=" . $datos['NOMBRE'][$i+2] . "'><img class='rounded-circle mb-2' src='img/" . $datos['FOTO'][$i+2] . "' alt='" . $datos['NOMBRE'][$i+2] . "' width='160px' height='140px'></a>
					<h3>" . $datos['NOMBRE'][$i+2] . "</h3>
					<p class='text-justify'>" . $datos['DESCRIPCION_CORTA'][$i+2] . "</p>
					<p class='text-center'><a class='btn btn-danger border border-dark' href='servicios.php?lang=" . $lang . "&nombre=" . $datos['NOMBRE'][$i+2] . "' role='button'><span class='fa fa-long-arrow-right'></span></a></p>
				";
			}
			echo "
				</div>
			</div>
				";
			$i=$i+3;
		}
		mysqli_close($conexion);
	?>
</div>