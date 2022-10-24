<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//RESCTANDO LOS DATOS DEL FORMULARIO Y ACTUALIZANDO INFORMACIÓN EN BASE DE DATOS
	$verf_cont_anterior="";
	$verf_cont_nueva="";
	if(isset($_POST["id"]) and isset($_POST["oficina"]) and isset($_POST["correo"]) and isset($_POST["telefono"])){
		$usuario_id=mysqli_real_escape_string($conexion,$_POST['id']);
		$usuario_oficina=mysqli_real_escape_string($conexion,$_POST['oficina']);
		$usuario_correo_e=mysqli_real_escape_string($conexion,$_POST['correo']);
		$usuario_telefono=mysqli_real_escape_string($conexion,$_POST['telefono']);
		//PROCESAMIENTO DE IMAGEN
		$verf_foto_size='ok';
		$verf_foto_type='ok';
		if(isset($_FILES['foto']['type'])){
			$foto_type=$_FILES['foto']['type'];
			$foto_size=$_FILES['foto']['size'];
			$ruta_temporal=$_FILES['foto']['tmp_name'];
			$ruta_destino=$url_sitio . 'fotos_del_personal/' . $usuario_correo_e . ".png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size>2000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type,"png")){ $verf_foto_type="ok";}else{$verf_foto_type="error";}
		}
		//ACTUALIZANDO DATOS SIN CONTRASEÑA
		$consulta="UPDATE `usuarios` SET `CORREO`='$usuario_correo_e', `OFICINA`='$usuario_oficina', `TELEFONO`='$usuario_telefono' WHERE `ID`='$usuario_id'";
		$resultado=mysqli_query($conexion,$consulta);
		//CARGANDO CURRICULUM EN BASE DE DATOS
		if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
			if(isset($_FILES['foto']['type'])){
				//VERIFICANDO DUPLICADO Y ELIMINANDO
				if(file_exists($ruta_destino)){
					unlink($ruta_destino);
				}
				//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
				move_uploaded_file($ruta_temporal,$ruta_destino);
			}
		}
		//VERIFICANDO Y ACTUALIZANDO CONTRASEÑA
		if(isset($_POST["contrasena_anterior"]) and $_POST["contrasena_anterior"]<>""){
			$consulta="SELECT `CONTRASENA` FROM `usuarios` WHERE `ID`='$usuario_id'";
			$resultado=mysqli_query($conexion,$consulta);
			$i=0;
			while(($fila=mysqli_fetch_array($resultado))==true){
				$contrasena_anterior_encryptada=$fila['CONTRASENA'];
				$i=$i+1;
			}
			$contrasena_anterior_usuario=mysqli_real_escape_string($conexion, $_POST['contrasena_anterior']);
			if(password_verify($contrasena_anterior_usuario,$contrasena_anterior_encryptada)){
				$verf_cont_anterior="ok";
				if(isset($_POST["nueva_contrasena"]) and $_POST["nueva_contrasena"]<>""){
					$verf_cont_nueva="ok";
					$nueva_contrasena=mysqli_real_escape_string($conexion, $_POST['nueva_contrasena']);
					$nueva_contrasena_encriptada=password_hash($nueva_contrasena, PASSWORD_DEFAULT);
					$consulta="UPDATE `usuarios` SET `CONTRASENA`='$nueva_contrasena_encriptada' WHERE `ID`='$usuario_id'";
					$resultado=mysqli_query($conexion,$consulta);
				}else{
					$verf_cont_nueva="error";
				}
			}else{
				$verf_cont_anterior="error";
			}
		}
	}
	//OBTEIENDO DATOS DE USUARIO:
	$consulta="SELECT * FROM `usuarios` WHERE `CORREO`='$usuario_correo'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos_usuarios['ID']=$fila['ID'];
		$datos_usuarios['NOMBRE']=$fila['NOMBRE'];
		$datos_usuarios['APELLIDO']=$fila['APELLIDO'];
		$datos_usuarios['CEDULA']=$fila['CEDULA'];
		$datos_usuarios['CARGO']=$fila['CARGO'];
		$datos_usuarios['CORREO']=$fila['CORREO'];
		$datos_usuarios['CONTRASENA']=$fila['CONTRASENA'];
		$datos_usuarios['OFICINA']=$fila['OFICINA'];
		$datos_usuarios['TELEFONO']=$fila['TELEFONO'];
		$datos_usuarios['ACTIVO']=$fila['ACTIVO'];
		$datos_usuarios['FECHA_NACIMIENTO']=$fila['FECHA_NACIMIENTO'];
		$datos_usuarios['FECHA_INGRESO']=$fila['FECHA_INGRESO'];
		$datos_usuarios['NUMERO_DE_EMPLEADO']=$fila['NUMERO_DE_EMPLEADO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Mi perfil</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<?php
			if($verf_cont_anterior=="error"){
				echo"<div><h5 class='bg-danger text-center my-3 p-2 rounded'>Contraseña Anterior no válida</h5></div>";
			}else if($verf_cont_nueva=="error"){
				echo "<div><h5 class='bg-warning text-center my-3 p-2 rounded'>Contraseña Nueva Vacía</h5></div>";
			}else if($verf_cont_anterior=="ok" and $verf_cont_nueva=="ok"){
				echo "<div><h5 class='bg-success text-center my-3 p-2 rounded'>Contraseña Cambiada con Éxito</h5></div>";
			}
		?>
		<h3 class="mt-1 my-2 py-2 border-bottom text-center"><span class="text-danger fa fa-cog fa-spin"></span> Perfil de Usuario (<strong><?php echo $usuario_nombre; ?></strong>):</h3>
		<p class="border-bottom pb-3">En esta sección podrás modificar datos de tu usuario como la contraseña o tu teléfono. Existe información fija en tu perfil como el <strong>Número de Empleado</strong> o la <strong>Fecha de Ingreso</strong> son manejados por el departamiento de Recursos Humanos (RRHH). Si hay algún error en estos datos comunícate con el encargado de RRHH para corregirlo. Recuerda tu <strong>Número de Empleado</strong> y tu <strong>Fecha de Ingreso</strong>, ya que son indispensables para recuperar tu contraseña.</p>
		<form action="perfil_de_usuario.php" method="post" class="text-center bg-dark p-3 rounded mb-3" enctype="multipart/form-data">
			<h3 class="text-center py-2 mt-2 mb-3 border-bottom border-top border-danger text-light">Datos Fijos (Cargados por RRHH)</h3>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">ID</span>
						</div>
						<input type="hidden" class="form-control mb-2 bg-light text-dark text-right" name="id" id="id" title="Número de Identificación" value="<?php echo $datos_usuarios['ID'] ?>">
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="id2" id="id2" title="Número de Identificación" value="<?php echo $datos_usuarios['ID'] ?>">
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Cédula</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="cedula" id="cedula" title="Cédula" value="<?php echo $datos_usuarios['CEDULA'] ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Nombre</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="nombre" id="nombre" title="Nombre" value="<?php echo $datos_usuarios['NOMBRE'] ?>">
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Apellido</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="apellido" id="apellido" title="Apellido" value="<?php echo $datos_usuarios['APELLIDO'] ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Fecha de Nacimiento</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="nombre" id="nombre" title="Nombre" value="<?php echo $datos_usuarios['FECHA_NACIMIENTO'] ?>">
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Fecha de Ingreso</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="apellido" id="apellido" title="Apellido" value="<?php echo $datos_usuarios['FECHA_INGRESO'] ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Cargo</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="cargo" id="cargo" title="Cargo" value="<?php echo $datos_usuarios['CARGO'] ?>">
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">¿Cuenta Activa?</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="activa" id="activa" title="Estado de la cuenta de usuario" value="<?php echo $datos_usuarios['ACTIVO'] ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Número de Empleado</span>
						</div>
						<input disabled type="text" class="form-control mb-2 bg-light text-dark text-right" name="empleado" id="empleado" title="Número de Empleado" value="<?php echo $datos_usuarios['NUMERO_DE_EMPLEADO'] ?>">
					</div>
				</div>
			</div>
			<h3 class="text-center py-2 mt-2 mb-3 border-bottom border-top border-danger text-light">Datos Modificables</h3>
			<div class="row">
				<div class="col mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Oficina</span>
						</div>
						<input required type="text" class="form-control mb-2 bg-light text-dark text-right" name="oficina" id="oficina" title="Dirección de Oficina" value="<?php echo $datos_usuarios['OFICINA'] ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<img src="fotos_del_personal/<?php echo $datos_usuarios['CORREO'] ?>.png" class="rounded border border-light" style="height: 82px; width: 95px;">
				</div>
				<div class="col-md-10">
					<div class="text-center bg">
						<span class="input-group-text mb-1">Actualiza tu Foto (en formato png y máximo 2 MegaBytes)</span>
					</div>
					<input type='file' name='foto' id='foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte su Foto (en formato png y máximo 2 MegaBytes)">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Correo</span>
						</div>
						<input required type="email" class="form-control mb-2 bg-light text-dark text-right" name="correo" id="correo" title="Correo electrónico" value="<?php echo $datos_usuarios['CORREO'] ?>">
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Teléfono</span>
						</div>
						<input required type="text" class="form-control mb-2 bg-light text-dark text-right" name="telefono" id="telefono" title="Número Telefónico" value="<?php echo $datos_usuarios['TELEFONO'] ?>">
					</div>
				</div>
			</div>
			<h3 class="text-center py-2 mt-2 mb-3 border-bottom border-top border-danger text-light">Cambio de Contraseña</h3>
			<div class="row">
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Ingresar Contraseña Anterior</span>
						</div>
						<input type="text" class="form-control mb-2 bg-light text-dark text-right" name="contrasena_anterior" id="contrasena_anterior" title="Contraseña Anterior" autocomplete="off">
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="input-group">
						<div class="input-group-prepend mb-2">
							<span class="input-group-text">Ingresar Nueva Contraseña</span>
						</div>
						<input type="text" class="form-control mb-2 bg-light text-dark text-right" name="nueva_contrasena" id="nueva_contrasena" title="Nueva Contraseña" autocomplete="off">
					</div>
				</div>
			</div>
			<input type="submit" value="Actualizar datos &raquo;" class="btn btn-danger">
		</form>
		<?php
			if($verf_cont_anterior=="error"){
				echo"<div><h5 class='bg-danger text-center my-3 p-2 rounded'>Contraseña Anterior no válida... Vuelva a intentarlo.</h5></div>";
			}else if($verf_cont_nueva=="error"){
				echo "<div><h5 class='bg-warning text-center my-3 p-2 rounded'>Contraseña Nueva Vacía... Vuelva a intentarlo.</h5></div>";
			}else if($verf_cont_anterior=="ok" and $verf_cont_nueva=="ok"){
				echo "<div><h5 class='bg-success text-center my-3 p-2 rounded'>Contraseña Cambiada con Éxito</h5></div>";
			}
		?>
		<h3 class="mt-1 my-2 py-2 border-bottom text-center"><span class="text-danger fa fa-cog fa-spin"></span> Descripción del Cargo (<strong><?php echo $usuario_nombre; ?></strong>):</h3>
		<?php
			//EXTRAYENDO DATOS DEL CARGO
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
				`descripcion_de_cargos`.`FUNCIONES_ADICIONALES` AS FUNCIONES_ADICIONALES 
				FROM `descripcion_de_cargos` 
				LEFT JOIN `usuarios` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO` 
				WHERE `usuarios`.`CORREO`='$usuario_correo'";
				$resultados=mysqli_query($conexion,$consulta);
				$fila=mysqli_fetch_array($resultados);
		?>
		<table class="table table-hover text-justify m-auto table-bordered">
			<tr>
				<td class="text-left"><strong>Jefe directo:</strong></td>
				<td><?php echo $fila['JEFE']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Supervision a ejercer:</strong></td>
				<td><?php echo $fila['SUPERVISADO']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Formación académica:</strong></td>
				<td><?php echo $fila['FORMACION']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Años de experiencia:</strong></td>
				<td><?php echo $fila['EXPERIENCIA']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Idiomas:</strong></td>
				<td><?php echo $fila['IDIOMA']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Objetivos:</strong></td>
				<td><?php echo $fila['OBJETIVOS']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Competencias obligatorias:</strong></td>
				<td><?php echo $fila['COMPETENCIAS']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Habiidades deseables:</strong></td>
				<td><?php echo $fila['HABILIDADES']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Funciones principales:</strong></td>
				<td><?php echo $fila['FUNCIONES_PRINCIPALES']; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>Funciones adicionales:</strong></td>
				<td><?php echo $fila['FUNCIONES_ADICIONALES']; ?></td>
			</tr>
		</table>
	</section>
	<?php require("php_require/footer2.php"); ?>
</body>
</html>
<?php
mysqli_close($conexion);
?>