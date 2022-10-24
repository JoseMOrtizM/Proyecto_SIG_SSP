<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$id_plan=mysqli_real_escape_string($conexion, $_POST['id_plan']);
			$correo_responsable=$usuario_correo;
			$mes_real=mysqli_real_escape_string($conexion, $_POST['mes_real']);
			$cantidad=mysqli_real_escape_string($conexion, $_POST['cantidad']);
			$detalle_01=mysqli_real_escape_string($conexion, $_POST['detalle_01']);
			if(isset($_POST['detalle_02'])){
				$detalle_02=mysqli_real_escape_string($conexion, $_POST['detalle_02']);
			}else{
				$detalle_02="";
			}
			if(isset($_POST['detalle_03'])){
				$detalle_03=mysqli_real_escape_string($conexion, $_POST['detalle_03']);
			}else{
				$detalle_03="";
			}
			$cargado_el=date('Y-m-d');
			$aprobado=mysqli_real_escape_string($conexion, $_POST['aprobado']);
			$consulta="INSERT INTO `reales` (`ID_PLAN`, `CORREO_RESPONSABLE`, `MES_REAL`, `CANTIDAD`, `DETALLE_01`, `DETALLE_02`, `DETALLE_03`, `CARGADO_EL`, `APROBADO`) VALUES ('$id_plan','$correo_responsable','$mes_real','$cantidad','$detalle_01','$detalle_02','$detalle_03','$cargado_el','$aprobado')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$id_plan=mysqli_real_escape_string($conexion, $_POST['id_plan']);
			$correo_responsable=$usuario_correo;
			$mes_real=mysqli_real_escape_string($conexion, $_POST['mes_real']);
			$cantidad=mysqli_real_escape_string($conexion, $_POST['cantidad']);
			$detalle_01=mysqli_real_escape_string($conexion, $_POST['detalle_01']);
			if(isset($_POST['detalle_02'])){
				$detalle_02=mysqli_real_escape_string($conexion, $_POST['detalle_02']);
			}else{
				$detalle_02="";
			}
			if(isset($_POST['detalle_03'])){
				$detalle_03=mysqli_real_escape_string($conexion, $_POST['detalle_03']);
			}else{
				$detalle_03="";
			}
			$cargado_el=date('Y-m-d');
			$aprobado=mysqli_real_escape_string($conexion, $_POST['aprobado']);
			if(isset($_POST['comentario_rechaso'])){
				$comentario_rechasado=mysqli_real_escape_string($conexion, $_POST['comentario_rechaso']);
			}else{
				$comentario_rechasado="";
			}
			$consulta="UPDATE `reales` SET 
			`ID_PLAN`='$id_plan',
			`CORREO_RESPONSABLE`='$correo_responsable',
			`MES_REAL`='$mes_real',
			`CANTIDAD`='$cantidad',
			`DETALLE_01`='$detalle_01',
			`DETALLE_02`='$detalle_02',
			`DETALLE_03`='$detalle_03',
			`CARGADO_EL`='$cargado_el',
			`APROBADO`='$aprobado',
			`COMENTARIO_RECHASADO`='$comentario_rechasado'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `reales` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT
	`reales`.`ID` AS ID,
	`planes`.`ID` AS ID_PLAN,
	`planes`.`CARGO` AS CARGO,
	`planes`.`DESCRIPCION` AS DESCRIPCION,
	`planes`.`ANO` AS ANO,
	`planes`.`UNIDAD` AS UNIDAD,
	`reales`.`MES_REAL` AS MES_REAL,
	`reales`.`CANTIDAD` AS CANTIDAD,
	`reales`.`DETALLE_01` AS DETALLE_01,
	`reales`.`DETALLE_02` AS DETALLE_02,
	`reales`.`DETALLE_03` AS DETALLE_03,
	`reales`.`COMENTARIO_RECHASADO` AS COMENTARIO_RECHASADO,
	`reales`.`APROBADO` AS APROBADO
	FROM `reales` INNER JOIN `planes` ON `reales`.`ID_PLAN`=`planes`.`ID` ORDER BY ID";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['ID_PLAN'][$i]=$fila['ID_PLAN'];
		$datos['CARGO'][$i]=$fila['CARGO'];//********
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos['ANO'][$i]=$fila['ANO'];//********
		$datos['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos['MES_REAL'][$i]=$fila['MES_REAL'];//********
		$datos['CANTIDAD'][$i]=$fila['CANTIDAD'];//********
		$datos['DETALLE_01'][$i]=$fila['DETALLE_01'];
		$datos['DETALLE_02'][$i]=$fila['DETALLE_02'];
		$datos['DETALLE_03'][$i]=$fila['DETALLE_03'];
		$datos['APROBADO'][$i]=$fila['APROBADO'];//********
		$datos['COMENTARIO_RECHASADO'][$i]=$fila['COMENTARIO_RECHASADO'];//********
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Reales</title>
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
						<h3 class="text-center text-md-left" title="Insertar nuevo renglón de actividad realizada dentro del Plan"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Renglón-Real:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_reales.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_reales.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<span class="input-group-text w-100 rounded-0">Descripción de la meta:</span>
						<select name="id_plan" id="id_plan" class="form-control mb-2 text-left rounded-0" required title="Elija el Año-Cargo-Descripción_Unidad asociada a la actividad que desea reportar" autocomplete="off">
							<option></option>
							<?php
								$consulta_i="SELECT `ID`, `CARGO`, `DESCRIPCION`, `ANO`, `UNIDAD` FROM `planes` ORDER BY `ANO`, `CARGO`, `DESCRIPCION`, `UNIDAD`, `ID`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_iplan[$i]['ID']=$fila_i['ID'];
									$datos_iplan[$i]['CARGO']=$fila_i['CARGO'];
									$datos_iplan[$i]['DESCRIPCION']=$fila_i['DESCRIPCION'];
									$datos_iplan[$i]['ANO']=$fila_i['ANO'];
									$datos_iplan[$i]['UNIDAD']=$fila_i['UNIDAD'];
									echo "<option value='" . $datos_iplan[$i]['ID'] ."'>" . $datos_iplan[$i]['ANO'] . "-" . $datos_iplan[$i]['CARGO'] . "-" . $datos_iplan[$i]['DESCRIPCION'] . "-" . $datos_iplan[$i]['UNIDAD'] . "</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="row">
						<div class="col-4">
								<span class="input-group-text w-100 rounded-0">Mes:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="mes_real" id="mes_real" placeholder="Mes Real" required autocomplete="off" title="introduzca el mes en el que se realizó la actividad" min="0" max="12">
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Cantidad:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="cantidad" id="cantidad" placeholder="Año del ejercicio" required autocomplete="off" title="introduzca la cantidad de Unidades reales que desea reportar" min="0">
							</div>
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">¿Aprobado?</span>
								<select class="form-control col mb-2 rounded-0" name="aprobado" id="aprobado" placeholder="Indique si la actividad está aprobada" required autocomplete="off" title="Indique si la meta esta aprobada">
									<option></option>
									<option>SI</option>
									<option>NO</option>
								</select>
							</div>
						</div>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_01 (Requerido):</span>
						<textarea class="form-control col mb-2" name="detalle_01" id="detalle_01" required></textarea>
						<script>
							$(document).ready(function() {
								$('#detalle_01').summernote({
									placeholder: 'Indique los detalles de la actividad',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_02 (Opcional):</span>
						<textarea class="form-control col mb-2" name="detalle_02" id="detalle_02"></textarea>
						<script>
							$(document).ready(function() {
								$('#detalle_02').summernote({
									placeholder: 'Indique detalles adicionales sobre la actividad',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_03 (Opcional):</span>
						<textarea class="form-control col mb-2" name="detalle_03" id="detalle_03"></textarea>
						<script>
							$(document).ready(function() {
								$('#detalle_03').summernote({
									placeholder: 'Indique algún otro detalle adicional sobre esta actividad',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="m-auto">
						<a href="CRUD_reales.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `reales` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['ID_PLAN']=$fila['ID_PLAN'];
					$datos_a_actualizar['MES_REAL']=$fila['MES_REAL'];
					$datos_a_actualizar['CANTIDAD']=$fila['CANTIDAD'];
					$datos_a_actualizar['DETALLE_01']=$fila['DETALLE_01'];
					$datos_a_actualizar['DETALLE_02']=$fila['DETALLE_02'];
					$datos_a_actualizar['DETALLE_03']=$fila['DETALLE_03'];
					$datos_a_actualizar['APROBADO']=$fila['APROBADO'];
					$datos_a_actualizar['COMENTARIO_RECHASADO']=$fila['COMENTARIO_RECHASADO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar un renglón de actividad realizada dentro del Plan"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Renglón-Real:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_reales.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_reales.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<span class="input-group-text w-100 rounded-0">Descripción de la meta:</span>
						<select name="id_plan" id="id_plan" class="form-control mb-2 text-left rounded-0" required title="Elija el Año-Cargo-Descripción_Unidad asociada a la actividad que desea reportar" autocomplete="off">
							<?php
								//OPCION DE SELECCIÓN ACTUAL DE LA ENTRADA
								$consulta_i="SELECT `planes`.`ID` AS ID, `planes`.`CARGO` AS CARGO, `planes`.`DESCRIPCION` AS DESCRIPCION, `planes`.`ANO` AS ANO, `planes`.`UNIDAD` AS UNIDAD FROM `planes` INNER JOIN `reales` ON `planes`.`ID`=`reales`.`ID_PLAN` WHERE `reales`.`ID`='" . $datos_a_actualizar["ID"] . "'";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$fila_i=mysqli_fetch_array($resultados_i);
								$datos_iiplan[$i]['ID']=$fila_i['ID'];
								$datos_iiplan[$i]['CARGO']=$fila_i['CARGO'];
								$datos_iiplan[$i]['DESCRIPCION']=$fila_i['DESCRIPCION'];
								$datos_iiplan[$i]['ANO']=$fila_i['ANO'];
								$datos_iiplan[$i]['UNIDAD']=$fila_i['UNIDAD'];
								echo "<option value='" . $datos_iiplan[$i]['ID'] ."'>" . $datos_iiplan[$i]['ANO'] . "-" . $datos_iiplan[$i]['CARGO'] . "-" . $datos_iiplan[$i]['DESCRIPCION'] . "-" . $datos_iiplan[$i]['UNIDAD'] . "</option>";
								//OPCIONES DE SELECCIÓN DE LA ENTRADA
								$i=0;
								while(isset($datos_iplan[$i]['ID'])){
									$datos_iplan[$i]['ID']=$fila_i['ID'];
									$datos_iplan[$i]['CARGO']=$fila_i['CARGO'];
									$datos_iplan[$i]['DESCRIPCION']=$fila_i['DESCRIPCION'];
									$datos_iplan[$i]['ANO']=$fila_i['ANO'];
									$datos_iplan[$i]['UNIDAD']=$fila_i['UNIDAD'];
									echo "<option value='" . $datos_iplan[$i]['ID'] ."'>" . $datos_iplan[$i]['ANO'] . "-" . $datos_iplan[$i]['CARGO'] . "-" . $datos_iplan[$i]['DESCRIPCION'] . "-" . $datos_iplan[$i]['UNIDAD'] . "</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="row">
						<div class="col-4">
								<span class="input-group-text w-100 rounded-0">Mes:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="mes_real" id="mes_real" placeholder="Mes Real" required autocomplete="off" title="introduzca el mes en el que se realizó la actividad" min="0" max="12" value="<?php echo $datos_a_actualizar['MES_REAL'] ?>">
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Cantidad:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="cantidad" id="cantidad" placeholder="Año del ejercicio" required autocomplete="off" title="introduzca la cantidad de Unidades reales que desea reportar" min="0" value="<?php echo $datos_a_actualizar['CANTIDAD'] ?>">
							</div>
						</div>
						<div class="col-4">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">¿Aprobado?</span>
								<select class="form-control col mb-2 rounded-0" name="aprobado" id="aprobado" placeholder="Indique si la actividad está aprobada" required autocomplete="off" title="Indique si la meta esta aprobada">
									<option><?php echo $datos_a_actualizar['APROBADO'] ?></option>
									<option>SI</option>
									<option>NO</option>
								</select>
							</div>
						</div>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_01 (Requerido):</span>
						<textarea class="form-control col mb-2" name="detalle_01" id="detalle_01" required><?php echo $datos_a_actualizar['DETALLE_01'] ?></textarea>
						<script>
							$(document).ready(function() {
								$('#detalle_01').summernote({
									placeholder: 'Indique los detalles de la actividad',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_02 (Opcional):</span>
						<textarea class="form-control col mb-2" name="detalle_02" id="detalle_02"><?php echo $datos_a_actualizar['DETALLE_02'] ?></textarea>
						<script>
							$(document).ready(function() {
								$('#detalle_02').summernote({
									placeholder: 'Indique detalles adicionales sobre la actividad',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_03 (Opcional):</span>
						<textarea class="form-control col mb-2" name="detalle_03" id="detalle_03"><?php echo $datos_a_actualizar['DETALLE_03'] ?></textarea>
						<script>
							$(document).ready(function() {
								$('#detalle_03').summernote({
									placeholder: 'Indique algún otro detalle adicional sobre esta actividad',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Comentario de Rechaso (Opcional):</span>
						<textarea class="form-control col mb-2" name="comentario_rechaso" id="comentario_rechaso"><?php echo $datos_a_actualizar['COMENTARIO_RECHASADO'] ?></textarea>
						<script>
							$(document).ready(function() {
								$('#comentario_rechaso').summernote({
									placeholder: 'Indique el motivo por el cual no se aprobó esta información',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="m-auto">
						<a href="CRUD_reales.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_reales.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Actividades Reales existentes en el sitio:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Año al que corresponde el renglón">Año</b></th>
								<th class="align-middle"><b title="Mes de la actividad">Mes</b></th>
								<th class="align-middle"><b title="Cargo al que corresponde la actividad">Cargo</b></th>
								<th class="align-middle"><b title="Descripción de la actividad">Descripción</b></th>
								<th class="align-middle"><b title="Unidad de medida del Renglón">Unidad</b></th>
								<th class="align-middle"><b title="Cantidad de la actividad">Cantidad</b></th>
								<th class="align-middle"><b title="Si el dato está aprobado por el Supervisor del proceso (SI/NO)">¿Aprobado?</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_reales.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-center"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['ANO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['MES_REAL'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['DESCRIPCION'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['UNIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['CANTIDAD'][$i]; ?></td>
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
								<td class="text-center h5"><a title="Modificar" href="CRUD_reales.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_reales.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_reales?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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