<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$unidad=mysqli_real_escape_string($conexion, $_POST['unidad']);
			$correo_carg=$usuario_correo;
			$cargado_fecha=date('Y-m-d');
			$ano_i=mysqli_real_escape_string($conexion, $_POST['ano_i']);
			$ene=mysqli_real_escape_string($conexion, $_POST['ene']);
			$feb=mysqli_real_escape_string($conexion, $_POST['feb']);
			$mar=mysqli_real_escape_string($conexion, $_POST['mar']);
			$abr=mysqli_real_escape_string($conexion, $_POST['abr']);
			$may=mysqli_real_escape_string($conexion, $_POST['may']);
			$jun=mysqli_real_escape_string($conexion, $_POST['jun']);
			$jul=mysqli_real_escape_string($conexion, $_POST['jul']);
			$ago=mysqli_real_escape_string($conexion, $_POST['ago']);
			$sep=mysqli_real_escape_string($conexion, $_POST['sep']);
			$oct=mysqli_real_escape_string($conexion, $_POST['oct']);
			$nov=mysqli_real_escape_string($conexion, $_POST['nov']);
			$dic=mysqli_real_escape_string($conexion, $_POST['dic']);
			$aprobado=mysqli_real_escape_string($conexion, $_POST['aprobado']);
			$consulta="INSERT INTO `planes` (`CARGO`, `DESCRIPCION`, `UNIDAD`, `CORREO_RESPONSABLE`, `CARGADO_FECHA`, `ANO`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `APROBADO`) VALUES ('$cargo','$descripcion','$unidad','$correo_carg','$cargado_fecha','$ano_i','$ene','$feb','$mar','$abr','$may','$jun','$jul','$ago','$sep','$oct','$nov','$dic','$aprobado')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$unidad=mysqli_real_escape_string($conexion, $_POST['unidad']);
			$correo_carg=$usuario_correo;
			$cargado_fecha=date('Y-m-d');
			$ano_i=mysqli_real_escape_string($conexion, $_POST['ano_i']);
			$ene=mysqli_real_escape_string($conexion, $_POST['ene']);
			$feb=mysqli_real_escape_string($conexion, $_POST['feb']);
			$mar=mysqli_real_escape_string($conexion, $_POST['mar']);
			$abr=mysqli_real_escape_string($conexion, $_POST['abr']);
			$may=mysqli_real_escape_string($conexion, $_POST['may']);
			$jun=mysqli_real_escape_string($conexion, $_POST['jun']);
			$jul=mysqli_real_escape_string($conexion, $_POST['jul']);
			$ago=mysqli_real_escape_string($conexion, $_POST['ago']);
			$sep=mysqli_real_escape_string($conexion, $_POST['sep']);
			$oct=mysqli_real_escape_string($conexion, $_POST['oct']);
			$nov=mysqli_real_escape_string($conexion, $_POST['nov']);
			$dic=mysqli_real_escape_string($conexion, $_POST['dic']);
			$aprobado=mysqli_real_escape_string($conexion, $_POST['aprobado']);
			$consulta="UPDATE `planes` SET 
			`CARGO`='$cargo',
			`DESCRIPCION`='$descripcion',
			`UNIDAD`='$unidad',
			`CORREO_RESPONSABLE`='$correo_carg',
			`CARGADO_FECHA`='$cargado_fecha',
			`ANO`='$ano_i',
			`1`='$ene',
			`2`='$feb',
			`3`='$mar',
			`4`='$abr',
			`5`='$may',
			`6`='$jun',
			`7`='$jul',
			`8`='$ago',
			`9`='$sep',
			`10`='$oct',
			`11`='$nov',
			`12`='$dic', 
			`APROBADO`='$aprobado', 
			`COMENTARIO_RECHASADO`='' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `planes` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `planes` WHERE `planes`.`CARGO`='$usuario_cargo' ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];//********
		$datos['CARGO'][$i]=$fila['CARGO'];//********
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos['ANO'][$i]=$fila['ANO'];
		$datos['ACUMULADO'][$i]= $fila['1']+$fila['2']+$fila['3']+$fila['4']+$fila['5']+$fila['6']+$fila['7']+$fila['8']+$fila['9']+$fila['10']+$fila['11']+$fila['12'];//********ACUMULADO
		$datos['APROBADO'][$i]=$fila['APROBADO'];//***************
		$datos['COMENTARIO_RECHASADO'][$i]=$fila['COMENTARIO_RECHASADO'];//***************
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Plan-<?php echo $usuario_nombre;?></title>
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
						<h3 class="text-center text-md-left" title="Insertar nuevo renglon o meta al Plan"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Renglón-Plan:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="usuario_plan.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="usuario_plan.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2 text-center" required title="Elija el cargo de la meta" autocomplete="off">
							<option><?php echo $usuario_cargo; ?></option>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Descripción:</span>
						</div>
						<textarea class="form-control col mb-2" name="descripcion" id="descripcion" placeholder="introduzca la descripción de la nueva meta" required autocomplete="off" title="introduzca la descripción de la nueva meta"></textarea>
					</div>
					<div class="row">
						<div class="col-4">
							<span class="input-group-text w-100 rounded-0">Unidad:</span>
							<input type="text" class="form-control col mb-2 rounded-0" name="unidad" id="unidad" placeholder="Unidad de medida" required autocomplete="off" title="introduzca la unidad de medida para la nueva meta">
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Año:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="ano_i" id="ano_i" placeholder="Año del ejercicio" required autocomplete="off" title="introduzca el año del ejercicio para la nueva meta" min="0">
							</div>
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">¿Aprobado?</span>
								<select class="form-control col mb-2 rounded-0" name="aprobado" id="aprobado" placeholder="Indique si la meta está aprobada" required autocomplete="off" title="Indique si la meta esta aprobada">
									<option>NO</option>
								</select>
							</div>
						</div>
					</div>
					<div class="input-group">
						<table class="mb-2">
							<tr>
								<th class="bg-light text-dark border border-dark rounded">ene</th>
								<th class="bg-light text-dark border border-dark rounded">feb</th>
								<th class="bg-light text-dark border border-dark rounded">mar</th>
								<th class="bg-light text-dark border border-dark rounded">abr</th>
								<th class="bg-light text-dark border border-dark rounded">may</th>
								<th class="bg-light text-dark border border-dark rounded">jun</th>
								<th class="bg-light text-dark border border-dark rounded">jul</th>
								<th class="bg-light text-dark border border-dark rounded">ago</th>
								<th class="bg-light text-dark border border-dark rounded">sep</th>
								<th class="bg-light text-dark border border-dark rounded">oct</th>
								<th class="bg-light text-dark border border-dark rounded">nov</th>
								<th class="bg-light text-dark border border-dark rounded">dic</th>
							</tr>
							<tr>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="ene" id="ene" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value=""></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="feb" id="feb" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="mar" id="mar" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="abr" id="abr" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="may" id="may" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="jun" id="jun" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="jul" id="jul" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="ago" id="ago" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="sep" id="sep" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="oct" id="oct" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="nov" id="nov" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="dic" id="dic" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0"></td>
							</tr>
						</table>
					</div>
					<div class="m-auto">
						<a href="usuario_plan.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `planes` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['CARGO']=$fila['CARGO'];
					$datos_a_actualizar['DESCRIPCION']=$fila['DESCRIPCION'];
					$datos_a_actualizar['UNIDAD']=$fila['UNIDAD'];
					$datos_a_actualizar['ANO']=$fila['ANO'];
					$datos_a_actualizar['1']=$fila['1'];
					$datos_a_actualizar['2']=$fila['2'];
					$datos_a_actualizar['3']=$fila['3'];
					$datos_a_actualizar['4']=$fila['4'];
					$datos_a_actualizar['5']=$fila['5'];
					$datos_a_actualizar['6']=$fila['6'];
					$datos_a_actualizar['7']=$fila['7'];
					$datos_a_actualizar['8']=$fila['8'];
					$datos_a_actualizar['9']=$fila['9'];
					$datos_a_actualizar['10']=$fila['10'];
					$datos_a_actualizar['11']=$fila['11'];
					$datos_a_actualizar['12']=$fila['12'];
					$datos_a_actualizar['APROBADO']=$fila['APROBADO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Insertar nuevo renglon o meta al Plan"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Renglón-Plan:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="usuario_plan.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="usuario_plan.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2 text-center" required title="Elija el cargo de la meta" autocomplete="off">
							<option><?php echo $usuario_cargo; ?></option>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Descripción:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="descripcion" id="descripcion" placeholder="Modifique la descripción de la nueva meta" required autocomplete="off" title="Modifique la descripción de la nueva meta" value="<?php echo $datos_a_actualizar['DESCRIPCION'];?>">
					</div>
					<div class="row">
						<div class="col-4">
								<span class="input-group-text w-100 rounded-0">Unidad:</span>
								<input type="text" class="form-control col mb-2 rounded-0" name="unidad" id="unidad" placeholder="Unidad de medida" required autocomplete="off" title="Modifique la unidad de medida para la nueva meta" value="<?php echo $datos_a_actualizar['UNIDAD'];?>">
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Año:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="ano_i" id="ano_i" placeholder="Año del ejercicio" required autocomplete="off" title="Modifique el año del ejercicio para la nueva meta" value="<?php echo $datos_a_actualizar['ANO'];?>" min="0">
							</div>
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">¿Aprobado?</span>
								<select class="form-control col mb-2 rounded-0" name="aprobado" id="aprobado" placeholder="Indique si la meta está aprobada" required autocomplete="off" title="Indique si la meta esta aprobada">
									<option>NO</option>
								</select>
							</div>
						</div>
					</div>
					<div class="input-group">
						<table class="mb-2">
							<tr>
								<th class="bg-light text-dark border border-dark rounded">ene</th>
								<th class="bg-light text-dark border border-dark rounded">feb</th>
								<th class="bg-light text-dark border border-dark rounded">mar</th>
								<th class="bg-light text-dark border border-dark rounded">abr</th>
								<th class="bg-light text-dark border border-dark rounded">may</th>
								<th class="bg-light text-dark border border-dark rounded">jun</th>
								<th class="bg-light text-dark border border-dark rounded">jul</th>
								<th class="bg-light text-dark border border-dark rounded">ago</th>
								<th class="bg-light text-dark border border-dark rounded">sep</th>
								<th class="bg-light text-dark border border-dark rounded">oct</th>
								<th class="bg-light text-dark border border-dark rounded">nov</th>
								<th class="bg-light text-dark border border-dark rounded">dic</th>
							</tr>
							<tr>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="ene" id="ene" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['1'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="feb" id="feb" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['2'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="mar" id="mar" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['3'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="abr" id="abr" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['4'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="may" id="may" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['5'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="jun" id="jun" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['6'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="jul" id="jul" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['7'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="ago" id="ago" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['8'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="sep" id="sep" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['9'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="oct" id="oct" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['10'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="nov" id="nov" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['11'];?>"></td>
								<td><input type="number" class="form-control p-0 m-0 text-center" name="dic" id="dic" required autocomplete="off" title="introduzca la cantidad Puntual de la meta para este mes" min="0" value="<?php echo $datos_a_actualizar['12'];?>"></td>
							</tr>
						</table>
					</div>
					<div class="m-auto">
						<a href="usuario_plan.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=usuario_plan.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Planes existentes para tu Cargo Actual:</h3>
			</div>
			<?php
				$consulta="SELECT `ID` FROM `planes` 
					WHERE `CARGO`='$usuario_cargo' 
					AND `APROBADO`='NO' 
					AND `COMENTARIO_RECHASADO`<>'' 
					ORDER BY `ID`";
				$resultados=mysqli_query($conexion,$consulta);
				$verf=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					$verf=$verf+1;
				}
				if($verf>0){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Planificadas Rechasadas</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Filtra por ¿Aprobado? &laquo;NO&raquo; para corregir/eliminar. El sistema sólo considera actividades aprobadas</p>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Año al que corresponde el meta">Año</b></th>
								<th class="align-middle"><b title="Cargo al que corresponde el meta">Cargo</b></th>
								<th class="align-middle"><b title="Descripción de la meta">Descripción</b></th>
								<th class="align-middle"><b title="Unidad de medida de la meta">Unidad</b></th>
								<th class="align-middle"><b title="Cantidad Acumulada para el año">Cantidad</b></th>
								<th class="align-middle"><b title="¿Meta Aprobada? (SI/NO)">¿Aprobado?</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="usuario_plan.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['ANO'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['CARGO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['UNIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['ACUMULADO'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos['APROBADO'][$i];
										//ASIGNANDO MODAL PARA VER MOIVO DE RECHASADO EN CASO DE APROBADO="NO"
										if($datos['APROBADO'][$i]=="NO" and $datos['COMENTARIO_RECHASADO'][$i]<>""){
											//Button trigger modal
											echo "<br><b class='text-danger'><a href='' class='text-danger mx-2' aria-hidden='true' title='Ver motivo por el cual no se aprobó esta información' data-toggle='modal' data-target='#modal_$i'>¿Por qué?</a></b>";
											//Modal
											echo "<div class='modal fade bd-example-modal-lg' id='modal_$i' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle_$i' aria-hidden='true'>";
											echo "<div class='modal-dialog modal-lg' role='document'>
													<div class='modal-content text-justify px-4 py-1'>
														<div class='modal-header'>
															<h4 class='modal-title text-danger' id='exampleModalLongTitle_$i'>Motivo de Rechaso de la información</h4>
															<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																<span aria-hidden='true'>&times;</span>
															</button>
														</div>
														<div class='modal-body'>
															<p>" . $datos['COMENTARIO_RECHASADO'][$i] . "</p>
														</div>
														<div class='modal-footer'>
															<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
														</div>
													</div>
												</div>";
											echo "</div>";
										}else if($datos['APROBADO'][$i]=="NO" and $datos['COMENTARIO_RECHASADO'][$i]==""){
											echo "<br><b class='text-danger'>(por Aprobar)</b>";
										}
									?>
								</td>
								<td class="text-center h5"><a title="Modificar" href="usuario_plan.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="usuario_plan.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('usuario_plan?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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