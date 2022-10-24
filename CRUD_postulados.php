<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$apellido=mysqli_real_escape_string($conexion, $_POST['apellido']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
			$fecha_nacimiento=mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
			$cargo_que_aspira=mysqli_real_escape_string($conexion, $_POST['cargo_que_aspira']);
			$salario_que_aspira=mysqli_real_escape_string($conexion, $_POST['salario_que_aspira']);
			$experiencia_previa=mysqli_real_escape_string($conexion, $_POST['experiencia_previa']);
			$nacionalidad=mysqli_real_escape_string($conexion, $_POST['nacionalidad']);
			$sexo=mysqli_real_escape_string($conexion, $_POST['sexo']);
			$direccion=mysqli_real_escape_string($conexion, $_POST['direccion']);
			$ingles=mysqli_real_escape_string($conexion, $_POST['ingles']);
			$profesion=mysqli_real_escape_string($conexion, $_POST['profesion']);
			$anos_experiencia=mysqli_real_escape_string($conexion, $_POST['anos_experiencia']);
			$fecha_envio=date("Y-m-d");
			$consulta="INSERT INTO `postulaciones` (`NOMBRE`, `APELLIDO`, `CORREO`, `TELEFONO`, `FECHA_NACIMIENTO`, `CARGO_QUE_ASPIRA`, `SALARIO_QUE_ASPIRA`, `EXPERIENCIA_PREVIA`, `NACIONALIDAD`, `SEXO`, `DIRECCION`, `INGLES`, `PROFESION`, `ANOS_EXPERIENCIA`, `FECHA_ENVIO`) VALUES ('$nombre','$apellido','$correo','$telefono','$fecha_nacimiento', '$cargo_que_aspira','$salario_que_aspira','$experiencia_previa', '$nacionalidad','$sexo','$direccion','$ingles','$profesion', '$anos_experiencia','$fecha_envio')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$apellido=mysqli_real_escape_string($conexion, $_POST['apellido']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
			$fecha_nacimiento=mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
			$cargo_que_aspira=mysqli_real_escape_string($conexion, $_POST['cargo_que_aspira']);
			$salario_que_aspira=mysqli_real_escape_string($conexion, $_POST['salario_que_aspira']);
			$experiencia_previa=mysqli_real_escape_string($conexion, $_POST['experiencia_previa']);
			$nacionalidad=mysqli_real_escape_string($conexion, $_POST['nacionalidad']);
			$sexo=mysqli_real_escape_string($conexion, $_POST['sexo']);
			$direccion=mysqli_real_escape_string($conexion, $_POST['direccion']);
			$ingles=mysqli_real_escape_string($conexion, $_POST['ingles']);
			$profesion=mysqli_real_escape_string($conexion, $_POST['profesion']);
			$anos_experiencia=mysqli_real_escape_string($conexion, $_POST['anos_experiencia']);
			$fecha_envio=date("Y-m-d");
			$consulta="UPDATE `postulaciones` SET 
			`NOMBRE`='$nombre',
			`APELLIDO`='$apellido',
			`CORREO`='$correo',
			`TELEFONO`='$telefono',
			`FECHA_NACIMIENTO`='$fecha_nacimiento',
			`CARGO_QUE_ASPIRA`='$cargo_que_aspira',
			`SALARIO_QUE_ASPIRA`='$salario_que_aspira',
			`EXPERIENCIA_PREVIA`='$experiencia_previa',
			`NACIONALIDAD`='$nacionalidad',
			`SEXO`='$sexo',
			`DIRECCION`='$direccion',
			`INGLES`='$ingles',
			`PROFESION`='$profesion',
			`ANOS_EXPERIENCIA`='$anos_experiencia',
			`FECHA_ENVIO`='$fecha_envio'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `postulaciones` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `postulaciones` ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];//********
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CORREO'][$i]=$fila['CORREO'];//********
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['CARGO_QUE_ASPIRA'][$i]=$fila['CARGO_QUE_ASPIRA'];
		$datos['SALARIO_QUE_ASPIRA'][$i]=$fila['SALARIO_QUE_ASPIRA'];
		$datos['EXPERIENCIA_PREVIA'][$i]=$fila['EXPERIENCIA_PREVIA'];
		$datos['NACIONALIDAD'][$i]=$fila['NACIONALIDAD'];
		$datos['SEXO'][$i]=$fila['SEXO'];//********
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['INGLES'][$i]=$fila['INGLES'];
		$datos['PROFESION'][$i]=$fila['PROFESION'];//********
		$datos['ANOS_EXPERIENCIA'][$i]=$fila['ANOS_EXPERIENCIA'];
		$datos['FECHA_ENVIO'][$i]=$fila['FECHA_ENVIO'];//********
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Postulados</title>
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
						<h3 class="text-center text-md-left" title="Insertar nueva Postulación para trabajar en la Empresa"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Postulación:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_postulados.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_postulados.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="introduzca el nombre del nuevo Aspirante" required autocomplete="off" title="introduzca el nombre del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Apellido:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="apellido" id="apellido" placeholder="introduzca el apellido del nuevo Aspirante" required autocomplete="off" title="introduzca el apellido del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="introduzca el correo electrónico del nuevo Aspirante" required autocomplete="off" title="introduzca el correo electrónico del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Teléfono:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="telefono" id="telefono" placeholder="introduzca el teléfono del nuevo Aspirante" required autocomplete="off" title="introduzca el teléfono del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nacionalidad:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nacionalidad" id="nacionalidad" placeholder="introduzca la nacionalidad del nuevo Aspirante" required autocomplete="off" title="introduzca la nacionalidad del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Sexo:</span>
						</div>
						<select name="sexo" id="sexo" class="form-control mb-2 text-center" required title="Elija el sexo del nuevo Postulado" autocomplete="off">
							<option></option>
							<option>Masculino</option>
							<option>Femenino</option>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Dirección:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="direccion" id="direccion" placeholder="introduzca la dirección del nuevo Aspirante" required autocomplete="off" title="introduzca la dirección del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Ingles:</span>
						</div>
						<select name="ingles" id="ingles" class="form-control mb-2 text-center" required title="Elija el nivel de ingles del nuevo Postulado" autocomplete="off">
							<option></option>
							<option>Bajo</option>
							<option>Medio</option>
							<option>Alto</option>
							<option>Experto</option>
							<option>Nativo</option>
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
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Profesión:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="profesion" id="profesion" placeholder="introduzca la profesión del nuevo Aspirante" required autocomplete="off" title="introduzca la profesión del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Dirección:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="direccion" id="direccion" placeholder="introduzca la dirección del nuevo Aspirante" required autocomplete="off" title="introduzca la dirección del nuevo Aspirante">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Años Experiencia:</span>
						</div>
						<input type="number" class="form-control col mb-2" name="anos_experiencia" id="anos_experiencia" placeholder="introduzca los años de experiencia del nuevo Aspirante" required autocomplete="off" title="introduzca los años de experiencia del nuevo Aspirante" min="0" max="50">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Aspira A:</span>
						</div>
						<select name="cargo_que_aspira" id="cargo_que_aspira" class="form-control mb-2 text-center" required title="Elija el cargo al que aspira el nuevo Postulado" autocomplete="off">
							<option></option>
							<?php
								$consulta="SELECT `CARGO` FROM `descripcion_de_cargos` GROUP BY `CARGO`";
								$resultados=mysqli_query($conexion,$consulta);
								$i=0;
								while(($fila=mysqli_fetch_array($resultados))==true){
									$cargo_i=$fila['CARGO'];
									echo "<option>$cargo_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Salario:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="salario_que_aspira" id="salario_que_aspira" placeholder="introduzca el salario al que aspira el nuevo Postulado" required autocomplete="off" title="introduzca el salario al que aspira el nuevo Postulado">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Experiencia Previa:</span>
						<textarea class="form-control col mb-2" name="experiencia_previa" id="experiencia_previa" required></textarea>
						<script>
							$(document).ready(function() {
								$('#experiencia_previa').summernote({
									placeholder: 'introduzca la experiencia previa del nuevo Postulado',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="m-auto">
						<a href="CRUD_postulados.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `postulaciones` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['NOMBRE']=$fila['NOMBRE'];
					$datos_a_actualizar['APELLIDO']=$fila['APELLIDO'];
					$datos_a_actualizar['CORREO']=$fila['CORREO'];
					$datos_a_actualizar['TELEFONO']=$fila['TELEFONO'];
					$datos_a_actualizar['FECHA_NACIMIENTO']=$fila['FECHA_NACIMIENTO'];
					$datos_a_actualizar['CARGO_QUE_ASPIRA']=$fila['CARGO_QUE_ASPIRA'];
					$datos_a_actualizar['SALARIO_QUE_ASPIRA']=$fila['SALARIO_QUE_ASPIRA'];
					$datos_a_actualizar['EXPERIENCIA_PREVIA']=$fila['EXPERIENCIA_PREVIA'];
					$datos_a_actualizar['NACIONALIDAD']=$fila['NACIONALIDAD'];
					$datos_a_actualizar['SEXO']=$fila['SEXO'];
					$datos_a_actualizar['DIRECCION']=$fila['DIRECCION'];
					$datos_a_actualizar['INGLES']=$fila['INGLES'];
					$datos_a_actualizar['PROFESION']=$fila['PROFESION'];
					$datos_a_actualizar['ANOS_EXPERIENCIA']=$fila['ANOS_EXPERIENCIA'];
					$datos_a_actualizar['FECHA_ENVIO']=$fila['FECHA_ENVIO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar Postulación para trabajar en la Empresa"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Postulación:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_postulados.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_postulados.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="Modifique el nombre del nuevo Aspirante" required autocomplete="off" title="Modifique el nombre del nuevo Aspirante" value="<?php echo $datos_a_actualizar['NOMBRE']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Apellido:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="apellido" id="apellido" placeholder="Modifique el apellido del nuevo Aspirante" required autocomplete="off" title="Modifique el apellido del nuevo Aspirante" value="<?php echo $datos_a_actualizar['APELLIDO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="Modifique el correo electrónico del nuevo Aspirante" required autocomplete="off" title="Modifique el correo electrónico del nuevo Aspirante" value="<?php echo $datos_a_actualizar['CORREO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Teléfono:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="telefono" id="telefono" placeholder="Modifique el teléfono del nuevo Aspirante" required autocomplete="off" title="Modifique el teléfono del nuevo Aspirante" value="<?php echo $datos_a_actualizar['TELEFONO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nacionalidad:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nacionalidad" id="nacionalidad" placeholder="Modifique la nacionalidad del nuevo Aspirante" required autocomplete="off" title="Modifique la nacionalidad del nuevo Aspirante" value="<?php echo $datos_a_actualizar['NACIONALIDAD']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Sexo:</span>
						</div>
						<select name="sexo" id="sexo" class="form-control mb-2 text-center" required title="Elija el sexo del nuevo Postulado" autocomplete="off">
							<option><?php echo $datos_a_actualizar['SEXO']; ?></option>
							<option>Masculino</option>
							<option>Femenino</option>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Dirección:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="direccion" id="direccion" placeholder="Modifique la dirección del nuevo Aspirante" required autocomplete="off" title="Modifique la dirección del nuevo Aspirante" value="<?php echo $datos_a_actualizar['DIRECCION']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Ingles:</span>
						</div>
						<select name="ingles" id="ingles" class="form-control mb-2 text-center" required title="Elija el nivel de ingles del nuevo Postulado" autocomplete="off">
							<option><?php echo $datos_a_actualizar['INGLES']; ?></option>
							<option>Bajo</option>
							<option>Medio</option>
							<option>Alto</option>
							<option>Experto</option>
							<option>Nativo</option>
						</select>
					</div>
					<div id="click02" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Nacimiento</span>
						</div>
						<input id="datepicker02" type='text' class="form-control text-center" name="fecha_nacimiento" placeholder="Fecha de Nacimiento (Y-m-d)" required autocomplete="off" title="Modifique su Fecha de Nacimiento (Y-m-d)" value="<?php echo $datos_a_actualizar['FECHA_NACIMIENTO']; ?>">
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
							<span class="input-group-text w-100">Profesión:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="profesion" id="profesion" placeholder="Modifique la Profesión del nuevo Aspirante" required autocomplete="off" title="Modifique la profesión del nuevo Aspirante" value="<?php echo $datos_a_actualizar['PROFESION']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Dirección:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="direccion" id="direccion" placeholder="Modifique la dirección del nuevo Aspirante" required autocomplete="off" title="Modifique la dirección del nuevo Aspirante" value="<?php echo $datos_a_actualizar['DIRECCION']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Años Experiencia:</span>
						</div>
						<input type="number" class="form-control col mb-2" name="anos_experiencia" id="anos_experiencia" placeholder="Modifique los años de experiencia del nuevo Aspirante" required autocomplete="off" title="Modifique los años de experiencia del nuevo Aspirante" min="0" max="50" value="<?php echo $datos_a_actualizar['ANOS_EXPERIENCIA']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Aspira A:</span>
						</div>
						<select name="cargo_que_aspira" id="cargo_que_aspira" class="form-control mb-2 text-center" required title="Elija el cargo al que aspira el nuevo Postulado" autocomplete="off">
							<option><?php echo $datos_a_actualizar['CARGO_QUE_ASPIRA']; ?></option>
							<?php
								$consulta="SELECT `CARGO` FROM `descripcion_de_cargos` GROUP BY `CARGO`";
								$resultados=mysqli_query($conexion,$consulta);
								$i=0;
								while(($fila=mysqli_fetch_array($resultados))==true){
									$cargo_i=$fila['CARGO'];
									echo "<option>$cargo_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Salario:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="salario_que_aspira" id="salario_que_aspira" placeholder="Modifique el salario al que aspira el nuevo Postulado" required autocomplete="off" title="Modifique el salario al que aspira el nuevo Postulado" value="<?php echo $datos_a_actualizar['SALARIO_QUE_ASPIRA']; ?>">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Experiencia Previa:</span>
						<textarea class="form-control col mb-2" name="experiencia_previa" id="experiencia_previa" required><?php echo $datos_a_actualizar['EXPERIENCIA_PREVIA']; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#experiencia_previa').summernote({
									placeholder: 'introduzca la experiencia previa del nuevo Postulado',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="m-auto">
						<a href="CRUD_postulados.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_postulados.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Postulados existentes en el sitio:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Correo Electrónico del Postulado">Correo</b></th>
								<th class="align-middle"><b title="Sexo o Género del Postulado">Sexo</b></th>
								<th class="align-middle"><b title="Profesión del Postulado">Profesión</b></th>
								<th class="align-middle"><b title="Fecha de Postulación">Fecha <br>envío</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_postulados.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['CORREO'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['SEXO'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['PROFESION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['FECHA_ENVIO'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_postulados.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_postulados.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_postulados?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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