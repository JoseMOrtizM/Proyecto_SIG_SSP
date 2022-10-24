<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$unidad=mysqli_real_escape_string($conexion, $_POST['unidad']);
			$cantidad=mysqli_real_escape_string($conexion, $_POST['cantidad']);
			$fecha_actividad=mysqli_real_escape_string($conexion, $_POST['fecha_actividad']);
			$cargado_el=date('Y-m-d');
			$correo_responsable=$usuario_correo;
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
			$aprobado=mysqli_real_escape_string($conexion, $_POST['aprobado']);
			$consulta="INSERT INTO `reales_adicional` (`DESCRIPCION`, `CARGO`, `UNIDAD`, `CANTIDAD`, `FECHA_ACTIVIDAD`, `CARGADO_EL`, `CORREO_RESPONSABLE`, `DETALLE_01`, `DETALLE_02`, `DETALLE_03`, `APROBADO`) VALUES ('$descripcion','$cargo','$unidad','$cantidad','$fecha_actividad','$cargado_el','$correo_responsable','$detalle_01','$detalle_02','$detalle_03','$aprobado')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$unidad=mysqli_real_escape_string($conexion, $_POST['unidad']);
			$cantidad=mysqli_real_escape_string($conexion, $_POST['cantidad']);
			$fecha_actividad=mysqli_real_escape_string($conexion, $_POST['fecha_actividad']);
			$cargado_el=date('Y-m-d');
			$correo_responsable=$usuario_correo;
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
			$aprobado=mysqli_real_escape_string($conexion, $_POST['aprobado']);
			if(isset($_POST['comentario_rechaso'])){
				$comentario_rechasado=mysqli_real_escape_string($conexion, $_POST['comentario_rechaso']);
			}else{
				$comentario_rechasado="";
			}
			$consulta="UPDATE `reales_adicional` SET 
			`DESCRIPCION`='$descripcion',
			`CARGO`='$cargo',
			`UNIDAD`='$unidad',
			`CANTIDAD`='$cantidad',
			`FECHA_ACTIVIDAD`='$fecha_actividad',
			`CARGADO_EL`='$cargado_el',
			`CORREO_RESPONSABLE`='$correo_responsable',
			`DETALLE_01`='$detalle_01',
			`DETALLE_02`='$detalle_02',
			`DETALLE_03`='$detalle_03',
			`APROBADO`='$aprobado', 
			`COMENTARIO_RECHASADO`='' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `reales_adicional` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT *	FROM `reales_adicional` WHERE `CARGO`='$usuario_cargo' ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos['CARGO'][$i]=$fila['CARGO'];//********
		$datos['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos['CANTIDAD'][$i]=$fila['CANTIDAD'];//********
		$datos['FECHA_ACTIVIDAD'][$i]=$fila['FECHA_ACTIVIDAD'];//********
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
	<title>SIG-SSP: Adic-<?php echo $usuario_nombre;?></title>
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
						<h3 class="text-center text-md-left" title="Insertar nuevo renglon real adicional al Plan"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Real-Adicional:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="usuario_real_adic.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="usuario_real_adic.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2 text-center" required title="Elija el cargo asociado a la Actividad" autocomplete="off">
							<option><?php echo $usuario_cargo; ?></option>
						</select>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Descripción de la Actividad:</span>
						<textarea class="form-control col mb-2" name="descripcion" id="descripcion" required></textarea>
						<script>
							$(document).ready(function() {
								$('#descripcion').summernote({
									placeholder: 'Describa esta actividad',
									tabsize: 1,
									height: 60								
								});
							});
						</script>
					</div>
					<div class="row">
						<div class="col-6">
								<span class="input-group-text w-100 rounded-0">Unidad:</span>
								<input type="text" class="form-control col mb-2 rounded-0" name="unidad" id="unidad" placeholder="Unidad Real" required autocomplete="off" title="introduzca la Unidad asociadaa esta actividad">
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Cantidad:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="cantidad" id="cantidad" placeholder="Año del ejercicio" required autocomplete="off" title="introduzca la cantidad de Unidades reales que desea reportar" min="1">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<div id="click01" class="input-group date pickers mb-2">
								<span class="input-group-text fa fa-calendar w-100 text-left rounded-0"> Fecha de Culminación</span>
								<input id="datepicker01" type='text' class="form-control text-center rounded-0" name="fecha_actividad" placeholder="Culminado el (Y-m-d)" required autocomplete="off" title="introduzca la Fecha de Culminación de la Actividad (Y-m-d)">
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
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0 fa">¿Aprobado?</span>
								<select class="form-control col mb-2 rounded-0 text-center" name="aprobado" id="aprobado" placeholder="Indique si la actividad está aprobada" required autocomplete="off" title="Indique si la meta esta aprobada">
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
						<a href="usuario_real_adic.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `reales_adicional` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['DESCRIPCION']=$fila['DESCRIPCION'];
					$datos_a_actualizar['CARGO']=$fila['CARGO'];
					$datos_a_actualizar['UNIDAD']=$fila['UNIDAD'];
					$datos_a_actualizar['CANTIDAD']=$fila['CANTIDAD'];
					$datos_a_actualizar['FECHA_ACTIVIDAD']=$fila['FECHA_ACTIVIDAD'];
					$datos_a_actualizar['DETALLE_01']=$fila['DETALLE_01'];
					$datos_a_actualizar['DETALLE_02']=$fila['DETALLE_02'];
					$datos_a_actualizar['DETALLE_03']=$fila['DETALLE_03'];
					$datos_a_actualizar['APROBADO']=$fila['APROBADO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar renglon real adicional al Plan"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Real-Adicional:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="usuario_real_adic.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="usuario_real_adic.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<select name="cargo" id="cargo" class="form-control mb-2 text-center" required title="Elija el cargo asociado a la Actividad" autocomplete="off">
							<option><?php echo $usuario_cargo; ?></option>
						</select>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Descripción de la Actividad:</span>
						<textarea class="form-control col mb-2" name="descripcion" id="descripcion" required><?php echo $datos_a_actualizar["DESCRIPCION"]; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#descripcion').summernote({
									placeholder: 'Describa esta actividad',
									tabsize: 1,
									height: 60								
								});
							});
						</script>
					</div>
					<div class="row">
						<div class="col-6">
								<span class="input-group-text w-100 rounded-0">Unidad:</span>
								<input type="text" class="form-control col mb-2 rounded-0" name="unidad" id="unidad" placeholder="Unidad Real" required autocomplete="off" title="MOdifique la Unidad asociadaa esta actividad" value="<?php echo $datos_a_actualizar["UNIDAD"]; ?>">
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Cantidad:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="cantidad" id="cantidad" placeholder="Año del ejercicio" required autocomplete="off" title="Modifique la cantidad de Unidades reales que desea reportar" min="1" value="<?php echo $datos_a_actualizar["CANTIDAD"]; ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<div id="click02" class="input-group date pickers mb-2">
								<span class="input-group-text fa fa-calendar w-100 text-left rounded-0"> Fecha de Culminación</span>
								<input id="datepicker02" type='text' class="form-control text-center rounded-0" name="fecha_actividad" placeholder="Culminado el (Y-m-d)" required autocomplete="off" title="Modifique la Fecha de Culminación de la Actividad (Y-m-d)" value="<?php echo $datos_a_actualizar["FECHA_ACTIVIDAD"]; ?>">
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
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0 fa text-left">¿Aprobado?</span>
								<select class="form-control col mb-2 rounded-0 text-center" name="aprobado" id="aprobado" placeholder="Indique si la actividad está aprobada" required autocomplete="off" title="Indique si la meta esta aprobada">
									<option>NO</option>
								</select>
							</div>
						</div>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Detalle_01 (Requerido):</span>
						<textarea class="form-control col mb-2" name="detalle_01" id="detalle_01" required><?php echo $datos_a_actualizar["DETALLE_01"]; ?></textarea>
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
						<textarea class="form-control col mb-2" name="detalle_02" id="detalle_02"><?php echo $datos_a_actualizar["DETALLE_02"]; ?></textarea>
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
						<textarea class="form-control col mb-2" name="detalle_03" id="detalle_03"><?php echo $datos_a_actualizar["DETALLE_03"]; ?></textarea>
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
						<a href="usuario_real_adic.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=usuario_real_adic.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Actividades Adicionales para su Cargo Actual:</h3>
			</div>
			<?php
				$consulta="SELECT `ID` FROM `reales_adicional` 
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
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Adicionales Rechasadas</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Filtra por ¿Aprobado? &laquo;NO&raquo; para corregir/eliminar. El sistema sólo considera actividades aprobadas</p>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Fecha en la que culminó la actividad">Fecha</b></th>
								<th class="align-middle"><b title="Cargo del trabajador que realizó la actividad">Cargo</b></th>
								<th class="align-middle"><b title="Descripción de la actividad">Descripción</b></th>
								<th class="align-middle"><b title="Unidad de medida de la actividad">Unidad</b></th>
								<th class="align-middle"><b title="Cantidad de unidades a reportar">Cantidad</b></th>
								<th class="align-middle"><b title="Si el dato está aprobado por el Supervisor del proceso (SI/NO)">¿Aprobado?</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="usuario_real_adic.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-center"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['FECHA_ACTIVIDAD'][$i]; ?></td>
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
								<td class="text-center h5"><a title="Modificar" href="usuario_real_adic.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="usuario_real_adic.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('usuario_real_adic?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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