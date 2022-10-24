<?php
	//CONECTANDO
	require("php_require/conexion.php");
	//RESCATANDO DESCRIPCIONES DE CARGO
	$consulta="SELECT 
	`descripcion_de_cargos`.`CARGO` AS CARGO, 
	`descripcion_de_cargos`.`JEFE` AS JEFE, 
	`descripcion_de_cargos`.`SUPERVISADO` AS SUPERVISADO, 
	`descripcion_de_cargos`.`FORMACION` AS FORMACION, 
	`descripcion_de_cargos`.`EXPERIENCIA` AS EXPERIENCIA, 
	`descripcion_de_cargos`.`IDIOMA` AS IDIOMA, 
	`descripcion_de_cargos`.`OBJETIVOS` AS OBJETIVOS, 
	`descripcion_de_cargos`.`COMPETENCIAS` AS COMPETENCIAS, 
	`descripcion_de_cargos`.`HABILIDADES` AS HABILIDADES, 
	`descripcion_de_cargos`.`FUNCIONES_PRINCIPALES` AS FUNCIONES_PRINCIPALES, 
	`descripcion_de_cargos`.`FUNCIONES_ADICIONALES` AS FUNCIONES_ADICIONALES, 
	`usuarios`.`ACTIVO` AS ACTIVO 
	FROM `descripcion_de_cargos` 
	LEFT JOIN `usuarios` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	GROUP BY `descripcion_de_cargos`.`CARGO` ORDER BY `descripcion_de_cargos`.`CARGO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$e=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		if($fila['ACTIVO']=='SI'){
			//NO MOSTRAR
		}else{
			$cargo[$e]=$fila['CARGO'];
			$jefe[$e]=$fila['JEFE'];
			$supervisado[$e]=$fila['SUPERVISADO'];
			$formacion[$e]=$fila['FORMACION'];
			$experiencia[$e]=$fila['EXPERIENCIA'];
			$idioma[$e]=$fila['IDIOMA'];
			$objetivos[$e]=$fila['OBJETIVOS'];
			$competencias[$e]=$fila['COMPETENCIAS'];
			$habilidades[$e]=$fila['HABILIDADES'];
			$funciones_principales[$e]=$fila['FUNCIONES_PRINCIPALES'];
			$funciones_adicionales[$e]=$fila['FUNCIONES_ADICIONALES'];
			$e=$e+1;
		}
		$i=$i+1;
	}
	//RECUPERANDO DATOS DEL FORM PARA VERIFICAR E INSERTAR EN LA BASE DE DATOS
	if(
		isset($_POST["nombre"]) and 
		isset($_POST["apellido"]) and 
		isset($_POST["email"]) and 
		isset($_POST["fecha_nac"]) and 
		isset($_POST["cargo"]) and 
		isset($_POST["salario"]) and 
		isset($_POST["nacionalidad"]) and 
		isset($_POST["sexo"]) and 
		isset($_POST["direccion"]) and 
		isset($_POST["ingles"]) and 
		isset($_POST["profesion"]) and 
		isset($_POST["anos_de_experiencia"]) and 
		isset($_POST["experiencia"])){
		$nombre_aspirante=mysqli_real_escape_string($conexion,$_POST['nombre']);
		$apellido_aspirante=mysqli_real_escape_string($conexion,$_POST['apellido']);
		$telf_aspirante=mysqli_real_escape_string($conexion,$_POST['telefono']);
		$email_aspirante=mysqli_real_escape_string($conexion,$_POST['email']);
		$fecha_nac_aspirante=mysqli_real_escape_string($conexion,$_POST['fecha_nac']);
		$cargo_que_aspira=mysqli_real_escape_string($conexion,$_POST['cargo']);
		$salario_que_aspira=mysqli_real_escape_string($conexion,$_POST['salario']);
		$nacionalidad_aspirante=mysqli_real_escape_string($conexion,$_POST['nacionalidad']);
		$sexo_aspirante=mysqli_real_escape_string($conexion,$_POST['sexo']);
		$direccion_aspirante=mysqli_real_escape_string($conexion,$_POST['direccion']);
		$ingles_aspirante=mysqli_real_escape_string($conexion,$_POST['ingles']);
		$profesion_aspirante=mysqli_real_escape_string($conexion,$_POST['profesion']);
		$anos_de_experiencia_aspirante=mysqli_real_escape_string($conexion,$_POST['anos_de_experiencia']);
		$experiencia_aspirante=mysqli_real_escape_string($conexion, $_POST['experiencia']);
		$cv_name=$_FILES['curriculum']['name'];
		$cv_type=$_FILES['curriculum']['type'];
		$cv_size=$_FILES['curriculum']['size'];
		$ruta_temporal=$_FILES['curriculum']['tmp_name'];
		$ruta_destino=$url_sitio . 'curriculum/' . $cv_name;
		//VERIFICANDO SI EXISTE EN LA BD EL CORREO INTRODUCIDO
		$consulta="SELECT `ID` FROM `POSTULACIONES` WHERE `CORREO`='$email_aspirante'";
		$resultado=mysqli_query($conexion,$consulta);
		$cta_correo=0;
		while(($fila=mysqli_fetch_array($resultado))==true){
			$cta_correo=$cta_correo+1;
		}
		if($cta_correo>0){$verf_correo="existe";}else{$verf_correo="nuevo";}
		//VERIFICANDO TAMAÑO DEL CURRICULUM
		if($cv_size>2000000){$verf_cv_size="error";}else{$verf_cv_size="ok";}
		//VERIFICANDO FORMATO DEL CURRICULUM
		if(strpos($cv_type,"pdf")){$verf_cv_type="ok";}else{$verf_cv_type="error";}
		//CARGANDO CURRICULUM EN BASE DE DATOS
		if($verf_cv_size=='ok' and $verf_cv_type=='ok'){
			//VERIFICANDO CORREO DUPLICADO PARA REEMPLAZARLO EN LA BD
			$dia_ahora=date("Y-m-d");
			if($verf_correo=="existe"){
				//REEMPLAZAR
				$consulta="UPDATE `POSTULACIONES` SET 
					`NOMBRE`='$nombre_aspirante',
					`APELLIDO`='$apellido_aspirante',
					`FECHA_NACIMIENTO`='$fecha_nac_aspirante',
					`TELEFONO`='$telf_aspirante',
					`CARGO_QUE_ASPIRA`='$cargo_que_aspira',
					`SALARIO_QUE_ASPIRA`='$salario_que_aspira',
					`NACIONALIDAD`='$nacionalidad_aspirante',
					`SEXO`='$sexo_aspirante',
					`DIRECCION`='$direccion_aspirante',
					`INGLES`='$ingles_aspirante',
					`PROFESION`='$profesion_aspirante',
					`ANOS_EXPERIENCIA`='$anos_de_experiencia_aspirante',
					`EXPERIENCIA_PREVIA`='$experiencia_aspirante',
					`FECHA_ENVIO`='$dia_ahora',
					`CURRICULUM`='$cv_name' 
					WHERE `CORREO`='$email_aspirante'";
				$resultado=mysqli_query($conexion,$consulta);
			}else{
				//INSERTAR
				$consulta="INSERT INTO `POSTULACIONES` (`NOMBRE`, `APELLIDO`, `CORREO`, `TELEFONO`, `FECHA_NACIMIENTO`, `CARGO_QUE_ASPIRA`, `SALARIO_QUE_ASPIRA`, `EXPERIENCIA_PREVIA`, `CURRICULUM`, `FECHA_ENVIO`, `NACIONALIDAD`, `SEXO`, `DIRECCION`, `INGLES`, `PROFESION`, `ANOS_EXPERIENCIA`) VALUES ('$nombre_aspirante','$apellido_aspirante','$email_aspirante','$telf_aspirante','$fecha_nac_aspirante','$cargo_que_aspira','$salario_que_aspira','$experiencia_aspirante','$cv_name','$dia_ahora','$nacionalidad_aspirante','$sexo_aspirante','$direccion_aspirante','$ingles_aspirante','$profesion_aspirante','$anos_de_experiencia_aspirante')";
				$resultado=mysqli_query($conexion,$consulta);
			}
			//VERIFICANDO DUPLICADO Y ELIMINANDO
			if(file_exists($ruta_destino)){
				unlink($ruta_destino);
			}
			//MOVIENDO IMAGEN A LA CARPETA DE IMAGENES DEL PROYECTO
			move_uploaded_file($ruta_temporal,$ruta_destino);
		}
	}
?>
<!doctype html>
<html lang="es">
	<head>
		<?php require("php_require/seo_meta.php") ?>
		<?php require("php_require/head.php") ?>
		<title>SSP-Empleo</title>
	</head>
	<body>
		<?php require("php_require/nav_index.php") ?>
		<section class="container px-5 pt-4 mt-5 mb-4">
			<?php
				if(isset($_POST["nombre"]) and 
					isset($_POST["apellido"]) and 
					isset($_POST["email"]) and 
					isset($_POST["fecha_nac"]) and 
					isset($_POST["cargo"]) and 
					isset($_POST["salario"]) and 
					isset($_POST["nacionalidad"]) and 
					isset($_POST["sexo"]) and 
					isset($_POST["direccion"]) and 
					isset($_POST["ingles"]) and 
					isset($_POST["profesion"]) and 
					isset($_POST["anos_de_experiencia"]) and 
					isset($_POST["experiencia"])){
					if($verf_cv_size=='ok' and $verf_cv_type=='ok' and $verf_correo=="nuevo"){
						echo "<div><h5 class='bg-success text-center my-3 p-2 rounded'>Sus datos fueron cargados con Éxito</h5></div>";
					}else if($verf_cv_size=='ok' and $verf_cv_type=='ok' and $verf_correo=="existe"){
						echo "<div><h5 class='bg-warning text-center my-3 p-2 rounded'>Sus datos fueron Actualizados con Éxito</h5></div>";
					}else if($verf_cv_size=='error' or $verf_cv_type=='error'){
						echo "<div><h5 class='bg-danger text-center my-3 p-2 rounded'>El Archivo adjunto no es válido</h5></div>";
					}
				}
			?>
			<h3 class="text-center mb-3"><span class="text-danger fa fa-cog fa-spin"></span> Actualmente buscamos candidatos para:</h3>
			<?php
				$i=0;
		 		$o=1;
				while(isset($cargo[$i])){
			?>
			<div class="container mx-auto">
				<a data-toggle="collapse" data-target="#Example<?php echo $i; ?>" aria-controls="Example<?php echo $i; ?>" aria-expanded="false" aria-label="Toggle navigation" class="text-danger h4 d-block mb-3" href="">
					<?php echo "$o) $cargo[$i]"; ?>
				</a>
				<div class="collapse navbar-collapse" id="Example<?php echo $i; ?>">
					<table class="table table-hover text-justify m-auto table-bordered">
						<tr>
							<td class="text-left"><strong>Jefe directo:</strong></td>
							<td><?php echo $jefe[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Supervision a ejercer:</strong></td>
							<td><?php echo $supervisado[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Formación académica:</strong></td>
							<td><?php echo $formacion[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Años de experiencia:</strong></td>
							<td><?php echo $experiencia[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Idiomas:</strong></td>
							<td><?php echo $idioma[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Objetivos:</strong></td>
							<td><?php echo $objetivos[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Competencias obligatorias:</strong></td>
							<td><?php echo $competencias[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Habiidades deseables:</strong></td>
							<td><?php echo $habilidades[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Funciones principales:</strong></td>
							<td><?php echo $funciones_principales[$i]; ?></td>
						</tr>
						<tr>
							<td class="text-left"><strong>Funciones adicionales:</strong></td>
							<td><?php echo $funciones_adicionales[$i]; ?></td>
						</tr>
					</table>
				</div>
			</div>
			<?php
					$i=$i+1;
					$o=$o+1;
				}
			?>
			<div class="col-md-11 col-lg-8 mx-auto">
				<h3 class="mt-4"><span class="text-danger fa fa-cog fa-spin"></span> POSTÚLATE <i class="text-muted h5">Todos los campos son requeridos</i></h3>
				<form action="form_empleo.php#confirmacion" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control" name="nombre" id="nombre" placeholder="introduzca su Nombre" required title="introduzca su Nombre" autocomplete="off" <?php if(isset($nombre_aspirante)){echo "value=$nombre_aspirante";} ?>>
						</div>
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control" name="apellido" id="apellido" placeholder="introduzca su Apellido" required title="introduzca su Apellido" autocomplete="off" <?php if(isset($apellido_aspirante)){echo "value=$apellido_aspirante";} ?>>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-2">
							<input type="tel" class="form-control" name="telefono" id="telefono" placeholder="introduzca su Teléfono" required title="introduzca su Teléfono" autocomplete="off" <?php if(isset($telf_aspirante)){echo "value=$telf_aspirante";} ?>>
						</div>
						<div class="col-md-6 mb-2">
							<input type="email" class="form-control" name="email" id="email" placeholder="introduzca su Correo" required title="introduzca su Correo" autocomplete="off" <?php if(isset($email_aspirante)){echo "value=$email_aspirante";} ?>>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control" name="nacionalidad" id="nacionalidad" placeholder="introduzca su Nacionalidad" required title="introduzca su Nacionalidad" autocomplete="off" <?php if(isset($nacionalidad_aspirante)){echo "value=$nacionalidad_aspirante";} ?>>
						</div>
						<div class="col-md-6 input-group">
							<div class="input-group-prepend mb-2">
								<span class="input-group-text">&nbsp;Sexo&nbsp;</span>
							</div>
							<select name="sexo" id="sexo" class="form-control mb-2" required title="introduzca su Sexo" autocomplete="off">
								<option><?php if(isset($sexo_aspirante)){echo $sexo_aspirante;} ?></option>
								<option>Masculino</option>
								<option>Femenino</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control" name="direccion" id="direccion" placeholder="introduzca su Dirección" required title="introduzca su Dirección de Habitación" autocomplete="off" <?php if(isset($direccion_aspirante)){echo "value=$direccion_aspirante";} ?>>
						</div>
						<div class="col-md-6 input-group">
							<div class="input-group-prepend mb-2">
								<span class="input-group-text">Inglés</span>
							</div>
							<select name="ingles" id="ingles" class="form-control mb-2" required title="introduzca su Nivel de Inglés" autocomplete="off">
								<option><?php if(isset($ingles_aspirante)){echo $ingles_aspirante;} ?></option>
								<option>Bajo</option>
								<option>Medio</option>
								<option>Alto</option>
								<option>Experto</option>
								<option>Nativo</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control" name="profesion" id="profesion" placeholder="introduzca su Profesión" required title="introduzca su Profesión" autocomplete="off" <?php if(isset($profesion_aspirante)){echo "value=$profesion_aspirante";} ?>>
						</div>
						<div class="col-md-6 mb-2">
							<input type="number" nim="0" max="50" class="form-control" name="anos_de_experiencia" id="anos_de_experiencia" placeholder="Años de Experiencia" required title="introduzca los años de Experiencia en su Profesión" autocomplete="off" <?php if(isset($ano_de_experiencia_aspirante)){echo "value=$ano_de_experiencia_aspirante";} ?>>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control" name="salario" id="salario" placeholder="Indique su espectativa salarial" required title="introduzca el salario que aspira obtener" autocomplete="off" <?php if(isset($salario_que_aspira)){echo "value=$salario_que_aspira";} ?>>
						</div>
						<div class="col-md-6 mb-2">
							<div id="click03" class="input-group date pickers">
								<input id="datepicker03" type='text' class="form-control" name="fecha_nac" placeholder="Fecha de Nacimiento (Y-m-d)" required autocomplete="off" title="introduzca su Fecha de Nacimiento (Y-m-d)" <?php if(isset($fecha_nac_aspirante)){echo "value=$fecha_nac_aspirante";} ?>>
								<div class="input-group-append">
									<span class="input-group-text fa fa-calendar"></span>
								</div>
							</div>
							<script type="text/javascript">
								$('#datepicker03').click(function(){
									Calendar.setup({
										inputField     :    "datepicker03",     // id of the input field
										ifFormat       :    "%Y-%m-%d",      // format of the input field
										button         :    "click03",  // trigger for the calendar (button ID)
										align          :    "Tl",           // alignment (defaults to "Bl")
										singleClick    :    true
									});
								});
							</script>
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Me Postulo a</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2" required title="introduzca el cargo para el que desea postularse" autocomplete="off">
							<option><?php if(isset($cargo_que_aspira)){echo $cargo_que_aspira;} ?></option>
							<?php
								$i=0;
								while(isset($cargo[$i])){
									echo "<option>$cargo[$i]</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<textarea rows="4" name="experiencia" id="experiencia" placeholder="Indique su experiencia previa..." class="form-control mb-2" required title="introduzca su Experiencia Previa" autocomplete="off"><?php if(isset($experiencia_aspirante)){echo $experiencia_aspirante;} ?></textarea>
					<div class="text-center bg">
						<span class="input-group-text mb-1">Adjunte su Resumen Curricular (en formato pdf y máximo 2 MegaBytes)</span>
					</div>
					<input type='file' name='curriculum' id='curriculum' class="mb-2 w-100 bg-light text-dark p-2 rounded" required title="Agregue su resumen curricular (pdf - tamaño maximo 2 megas)">
					<div class="container align-content-center">
						<input type="submit" value="Enviar &raquo;" class="btn btn-danger">
					</div>
				</form>
				<p class="pt-2"><strong>NOTA:</strong> Puede Actualizar sus datos ingresándolos nuevamente...</p>
				<?php
					if(isset($_POST["nombre"]) and 
						isset($_POST["apellido"]) and 
						isset($_POST["email"]) and 
						isset($_POST["fecha_nac"]) and 
						isset($_POST["cargo"]) and 
						isset($_POST["salario"]) and 
						isset($_POST["nacionalidad"]) and 
						isset($_POST["sexo"]) and 
						isset($_POST["direccion"]) and 
						isset($_POST["ingles"]) and 
						isset($_POST["profesion"]) and 
						isset($_POST["anos_de_experiencia"]) and 
						isset($_POST["experiencia"])){
						if($verf_cv_size=='ok' and $verf_cv_type=='ok' and $verf_correo=="nuevo"){
							echo "<div><h5 class='bg-success text-center my-3 p-2 rounded' id='confirmacion'>Sus datos fueron cargados con Éxito</h5></div>";
						}else if($verf_cv_size=='ok' and $verf_cv_type=='ok' and $verf_correo=="existe"){
							echo "<div><h5 class='bg-warning text-center my-3 p-2 rounded' id='confirmacion'>Sus datos fueron Actualizados con Éxito</h5></div>";
						}else if($verf_cv_size=='error' or $verf_cv_type=='error'){
							echo "<div><h5 class='bg-danger text-center my-3 p-2 rounded' id='confirmacion'>El Archivo adjunto no es válido</h5></div>";
						}
					}
				?>
			</div>
		</section>
		<?php require("php_require/footer.php") ?>
	</body>
</html>