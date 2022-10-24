<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$cedula=mysqli_real_escape_string($conexion, $_POST['cedula']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$apellido=mysqli_real_escape_string($conexion, $_POST['apellido']);
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$oficina=mysqli_real_escape_string($conexion, $_POST['oficina']);
			$telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
			$activo=mysqli_real_escape_string($conexion, $_POST['activo']);
			$fecha_nacimiento=mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
			$fecha_ingreso=mysqli_real_escape_string($conexion, $_POST['fecha_ingreso']);
			$numero_de_empleado=mysqli_real_escape_string($conexion, $_POST['numero_de_empleado']);
			//PROCESAMIENTO DE IMAGEN
			$foto_type=$_FILES['foto']['type'];
			$foto_size=$_FILES['foto']['size'];
			$ruta_temporal=$_FILES['foto']['tmp_name'];
			$ruta_destino=$url_sitio . 'fotos_del_personal/' . $correo . ".png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size>2000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type,"png")){$verf_foto_type="ok";}else{$verf_foto_type="error";}
			//CARGANDO CURRICULUM EN BASE DE DATOS
			if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
				//INSERTANDO
				$consulta="INSERT INTO `usuarios` (`CEDULA`, `CORREO`, `NOMBRE`, `APELLIDO`, `CARGO`, `OFICINA`, `TELEFONO`, `ACTIVO`, `FECHA_NACIMIENTO`, `FECHA_INGRESO`, `NUMERO_DE_EMPLEADO`) VALUES ('$cedula','$correo','$nombre','$apellido','$cargo','$oficina','$telefono','$activo','$fecha_nacimiento','$fecha_ingreso','$numero_de_empleado')";
				$resultados=mysqli_query($conexion,$consulta);
				//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
				move_uploaded_file($ruta_temporal,$ruta_destino);
			}
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$cedula=mysqli_real_escape_string($conexion, $_POST['cedula']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$apellido=mysqli_real_escape_string($conexion, $_POST['apellido']);
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$oficina=mysqli_real_escape_string($conexion, $_POST['oficina']);
			$telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
			$activo=mysqli_real_escape_string($conexion, $_POST['activo']);
			$fecha_nacimiento=mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
			$fecha_ingreso=mysqli_real_escape_string($conexion, $_POST['fecha_ingreso']);
			$numero_de_empleado=mysqli_real_escape_string($conexion, $_POST['numero_de_empleado']);
			//PROCESAMIENTO DE IMAGEN
			$verf_foto_size='ok';
			$verf_foto_type='ok';
			if(isset($_FILES['foto']['type'])){
				$foto_type=$_FILES['foto']['type'];
				$foto_size=$_FILES['foto']['size'];
				$ruta_temporal=$_FILES['foto']['tmp_name'];
				$ruta_destino=$url_sitio . 'fotos_del_personal/' . $correo . ".png";
				//VERIFICANDO TAMAÑO DE LA IMAGEN
				if($foto_size>2000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
				//VERIFICANDO FORMATO DE LA IMAGEN
				if(strpos($foto_type,"png")){ $verf_foto_type="ok";}else{$verf_foto_type="error";}
			}
			if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
				//CARGANDO USUARIO EN BASE DE DATOS ACTUALIZANDO
				$consulta="UPDATE `usuarios` SET 
				`CEDULA`='$cedula',
				`CORREO`='$correo',
				`NOMBRE`='$nombre',
				`APELLIDO`='$apellido',
				`CARGO`='$cargo',
				`OFICINA`='$oficina',
				`TELEFONO`='$telefono',
				`ACTIVO`='$activo',
				`FECHA_NACIMIENTO`='$fecha_nacimiento',
				`FECHA_INGRESO`='$fecha_ingreso',
				`NUMERO_DE_EMPLEADO`='$numero_de_empleado'
				WHERE `ID`='$crud_id'";
				$resultados=mysqli_query($conexion,$consulta);
				//VERIFICANDO DUPLICADO Y ELIMINANDO
				//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
				$imp=move_uploaded_file($ruta_temporal,$ruta_destino);
			}
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `usuarios` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `usuarios` ORDER BY `CEDULA`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];//********
		$datos['CEDULA'][$i]=$fila['CEDULA'];//********
		$datos['CORREO'][$i]=$fila['CORREO'];//********
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];//********
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];//********
		$datos['CARGO'][$i]=$fila['CARGO'];
		$datos['OFICINA'][$i]=$fila['OFICINA'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['ACTIVO'][$i]=$fila['ACTIVO'];//********
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['FECHA_INGRESO'][$i]=$fila['FECHA_INGRESO'];
		$datos['NUMERO_DE_EMPLEADO'][$i]=$fila['NUMERO_DE_EMPLEADO'];
		//COLOCAR LA FOTO Y EL CORREO
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Usuarios</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<?php
		//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if(isset($_GET["NA_Accion"])){
			if($_GET["NA_Accion"]=="insertar"){
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Insertar nuevo Usuario"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Usuario:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_usuarios.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_usuarios.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cédula:</span>
						</div>
						<input type="number" class="form-control col mb-2" name="cedula" id="cedula" placeholder="introduzca la Cédula de Identidad del nuevo Usuario" required autocomplete="off" title="introduzca la Cédula de Identidad del nuevo Usuario" min="0">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="introduzca el Correo del nuevo Usuario" required autocomplete="off" title="introduzca el Correo del nuevo Usuario">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="introduzca el Nombre del nuevo Usuario" required autocomplete="off" title="introduzca el Nombre del nuevo Usuario">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Apellido:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="apellido" id="apellido" placeholder="introduzca el Apellido del nuevo Usuario" required autocomplete="off" title="introduzca el Apellido del nuevo Usuario">
					</div>
					<div class="text-center bg">
						<span class="input-group-text mb-1">Adjunte su Foto (en formato png y máximo 2 MegaBytes)</span>
					</div>
					<input type='file' name='foto' id='foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" required title="Adjunte su Foto (en formato png y máximo 2 MegaBytes)">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2" required title="Elija el cargo del nuevo Usuario" autocomplete="off">
							<option></option>
							<?php
								$consulta="SELECT `CARGO` FROM `descripcion_de_cargos` GROUP BY `CARGO` ORDER BY `CARGO`";
								$resultados=mysqli_query($conexion,$consulta);
								$i=0;
								while(($fila=mysqli_fetch_array($resultados))==true){
									$cargo_i[$i]=$fila['CARGO'];
									$i=$i+1;
								}
								$i=0;
								while(isset($cargo_i[$i])){
									echo "<option>$cargo_i[$i]</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Oficina:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="oficina" id="oficina" placeholder="introduzca la Dirección de Oficina del nuevo Usuario" required autocomplete="off" title="introduzca la Dirección de Oficina del nuevo Usuario">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Teléfono:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="telefono" id="telefono" placeholder="introduzca el Teléfono del nuevo Usuario" required autocomplete="off" title="introduzca el Teléfono del nuevo Usuario">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">¿Activo?</span>
						</div>
						<select name="activo" id="activo" class="form-control mb-2 text-center" required title="Elija el estado de la cuenta del nuevo Usuario" autocomplete="off">
							<option></option>
							<option>SI</option>
							<option>NO</option>
						</select>
					</div>
					<div id="click01" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Nacimiento</span>
						</div>
						<input id="datepicker01" type='text' class="form-control text-center" name="fecha_nacimiento" placeholder="Fecha de Nacimiento (Y-m-d)" required autocomplete="off" title="introduzca su Fecha de Nacimiento (Y-m-d)">
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField     :    "datepicker01",     // id of the input field
								ifFormat       :    "%Y-%m-%d",      // format of the input field
								button         :    "click01",  // trigger for the calendar (button ID)
								align          :    "Tl",           // alignment (defaults to "Bl")
								singleClick    :    true
							});
						});
					</script>
					<div id="click02" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Ingreso</span>
						</div>
						<input id="datepicker02" type='text' class="form-control text-center" name="fecha_ingreso" placeholder="Fecha de Ingreso (Y-m-d)" required autocomplete="off" title="introduzca su Fecha de Ingreso (Y-m-d)">
					</div>
					<script type="text/javascript">
						$('#datepicker02').click(function(){
							Calendar.setup({
								inputField     :    "datepicker02",     // id of the input field
								ifFormat       :    "%Y-%m-%d",      // format of the input field
								button         :    "click02",  // trigger for the calendar (button ID)
								align          :    "Tl",           // alignment (defaults to "Bl")
								singleClick    :    true
							});
						});
					</script>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">N° Empleado:</span>
						</div>
						<input disabled id="numero_de_empleado_falso" type='number' class="form-control text-center" name="numero_de_empleado_falso" placeholder="introduzca el número de empleado del nuevo Usuario" required autocomplete="off" title="introduzca el número de empleado del nuevo Usuario" value="<?php
							$consulta="SELECT MAX(`NUMERO_DE_EMPLEADO`) AS MAX FROM `usuarios`";
							$resultados=mysqli_query($conexion,$consulta);
							$i=0;
							while(($fila=mysqli_fetch_array($resultados))==true){
								$maximo=$fila['MAX'];
								$i=$i+1;
							}
							$maximo=$maximo+1;
							echo $maximo;
						?>">
						<input id="numero_de_empleado" type='hidden' name="numero_de_empleado" value="<?php echo $maximo; ?>">
					</div>
					<div class="m-auto">
						<a href="CRUD_usuarios.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `usuarios` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['CEDULA']=$fila['CEDULA'];
					$datos_a_actualizar['CORREO']=$fila['CORREO'];
					$datos_a_actualizar['NOMBRE']=$fila['NOMBRE'];
					$datos_a_actualizar['APELLIDO']=$fila['APELLIDO'];
					$datos_a_actualizar['CARGO']=$fila['CARGO'];
					$datos_a_actualizar['OFICINA']=$fila['OFICINA'];
					$datos_a_actualizar['TELEFONO']=$fila['TELEFONO'];
					$datos_a_actualizar['ACTIVO']=$fila['ACTIVO'];
					$datos_a_actualizar['FECHA_NACIMIENTO']=$fila['FECHA_NACIMIENTO'];
					$datos_a_actualizar['FECHA_INGRESO']=$fila['FECHA_INGRESO'];
					$datos_a_actualizar['NUMERO_DE_EMPLEADO']=$fila['NUMERO_DE_EMPLEADO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar Usuario"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Usuario:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_usuarios.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_usuarios.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cédula:</span>
						</div>
						<input type="number" class="form-control col mb-2" name="cedula" id="cedula" placeholder="Modificar la Cédula de Identidad del Usuario" required autocomplete="off" title="Modificar la Cédula de Identidad del Usuario" min="0" value="<?php echo $datos_a_actualizar['CEDULA']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="Modificar el Correo del Usuario" required autocomplete="off" title="Modificar el Correo del Usuario" value="<?php echo $datos_a_actualizar['CORREO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="Modificar el Nombre del Usuario" required autocomplete="off" title="Modificar el Nombre del Usuario" value="<?php echo $datos_a_actualizar['NOMBRE']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Apellido:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="apellido" id="apellido" placeholder="Modificar el Apellido del Usuario" required autocomplete="off" title="Modificar el Apellido del Usuario" value="<?php echo $datos_a_actualizar['APELLIDO']; ?>">
					</div>
					
					<div class="row">
						<div class="col-md-2">
							<img src="fotos_del_personal/<?php echo $datos_a_actualizar['CORREO'] ?>.png" class="rounded border border-light" style="height: 82px; width: 95px;">
						</div>
						<div class="col-md-10">
							<div class="text-center bg">
								<span class="input-group-text mb-1">Actualize su Foto (en formato png y máximo 2 MegaBytes)</span>
							</div>
							<input type='file' name='foto' id='foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte su Foto (en formato png y máximo 2 MegaBytes)">
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2" required title="Elija el cargo del Usuario" autocomplete="off">
							<option><?php echo $datos_a_actualizar['CARGO']; ?></option>
							<?php
								$consulta="SELECT `CARGO` FROM `descripcion_de_cargos` GROUP BY `CARGO` ORDER BY `CARGO`";
								$resultados=mysqli_query($conexion,$consulta);
								$i=0;
								while(($fila=mysqli_fetch_array($resultados))==true){
									$cargo_i[$i]=$fila['CARGO'];
									$i=$i+1;
								}
								$i=0;
								while(isset($cargo_i[$i])){
									echo "<option>$cargo_i[$i]</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Oficina:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="oficina" id="oficina" placeholder="Modificar la Dirección de Oficina del Usuario" required autocomplete="off" title="Modificar la Dirección de Oficina del Usuario" value="<?php echo $datos_a_actualizar['OFICINA']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Teléfono:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="telefono" id="telefono" placeholder="Modificar el Teléfono del Usuario" required autocomplete="off" title="Modificar el Teléfono del Usuario" value="<?php echo $datos_a_actualizar['TELEFONO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">¿Activo?</span>
						</div>
						<select name="activo" id="activo" class="form-control mb-2 text-center" required title="Elija el estado de la cuenta del Usuario" autocomplete="off">
							<option><?php echo $datos_a_actualizar['ACTIVO']; ?></option>
							<option>SI</option>
							<option>NO</option>
						</select>
					</div>
					<div id="click01" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Nacimiento</span>
						</div>
						<input id="datepicker01" type='text' class="form-control text-center" name="fecha_nacimiento" placeholder="Fecha de Nacimiento (Y-m-d)" required autocomplete="off" title="Modificar su Fecha de Nacimiento (Y-m-d)" value="<?php echo $datos_a_actualizar['FECHA_NACIMIENTO']; ?>">
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField     :    "datepicker01",     // id of the input field
								ifFormat       :    "%Y-%m-%d",      // format of the input field
								button         :    "click01",  // trigger for the calendar (button ID)
								align          :    "Tl",           // alignment (defaults to "Bl")
								singleClick    :    true
							});
						});
					</script>
					<div id="click02" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Ingreso</span>
						</div>
						<input id="datepicker02" type='text' class="form-control text-center" name="fecha_ingreso" placeholder="Fecha de Ingreso (Y-m-d)" required autocomplete="off" title="Modificar su Fecha de Ingreso (Y-m-d)" value="<?php echo $datos_a_actualizar['FECHA_INGRESO']; ?>">
					</div>
					<script type="text/javascript">
						$('#datepicker02').click(function(){
							Calendar.setup({
								inputField     :    "datepicker02",     // id of the input field
								ifFormat       :    "%Y-%m-%d",      // format of the input field
								button         :    "click02",  // trigger for the calendar (button ID)
								align          :    "Tl",           // alignment (defaults to "Bl")
								singleClick    :    true
							});
						});
					</script>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">N° Empleado:</span>
						</div>
						<input disabled id="numero_de_empleado_falso" type='text' class="form-control text-center" name="numero_de_empleado_falso" placeholder="Modificar el número de empleado del Usuario" required autocomplete="off" title="Modificar el número de empleado del Usuario" value="<?php echo $datos_a_actualizar['NUMERO_DE_EMPLEADO']; ?>">
						<input id="numero_de_empleado" type='hidden' class="form-control text-center" name="numero_de_empleado" placeholder="Modificar el número de empleado del Usuario" required autocomplete="off" title="Modificar el número de empleado del Usuario" value="<?php echo $datos_a_actualizar['NUMERO_DE_EMPLEADO']; ?>">
					</div>
					<div class="m-auto">
						<a href="CRUD_usuarios.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_usuarios.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Usuarios existentes en el sitio:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Cédula de Identidad">Foto</b></th>
								<th class="align-middle"><b title="Cédula de Identidad">Cédula</b></th>
								<th class="align-middle"><b title="Correo Electrónico">Correo</b></th>
								<th class="align-middle"><b title="Nombre de Usuario">Nombre</b></th>
								<th class="align-middle"><b title="¿Cuenta Activa?">¿Activo?</b></th>
								<th class="align-middle"><b title="Cargo Asignado">Cargo</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_usuarios.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><img src="fotos_del_personal/<?php echo $datos['CORREO'][$i]; ?>.png" width="60px" height="55px" class="rounded" title="<?php echo $datos['CARGO'][$i]; ?>"></td>
								<td class="text-left"><?php echo $datos['CEDULA'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['CORREO'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['APELLIDO'][$i] . ", " . $datos['NOMBRE'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['ACTIVO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['CARGO'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_usuarios.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_usuarios.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_usuarios?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
								<script>
									function confirmar<?php echo $i; ?>(url){
										if(confirm('¿Seguro que desea Borrar este Renglón?')){
											window.location=url;
										}else{
											return false;
										}	
									}
								</script>
							</tr>
							<?php
									$i=$i+1;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br><br><br><br><br>
		<?php
		}
		?>
	</section>
	<?php require("php_require/footer2.php"); ?>
</body>
</html>
<!-- ENLACES Y FUNCIÓN PARA LLAMAR AL PAGINADO Y BUSCADOR DE LA  DATATABLE -->
<script src="js/jquery.dataTables.js"></script>
<script src="js/dataTables.bootstrap4.js"></script>
<script>
	// LLAMANDO A LA FUNCIÓN DateTable() DE jquery.dataTables.js
	$(document).ready(function() {
	  $('#dataTable01').DataTable();
	});
</script>
<?php
mysqli_close($conexion);
?>