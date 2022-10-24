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
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$fecha_recibido=mysqli_real_escape_string($conexion, $_POST['fecha_recibido']);
			$comentario=mysqli_real_escape_string($conexion, $_POST['comentario']);
			$consulta="INSERT INTO `contactanos` (`NOMBRE`, `CORREO`, `FECHA_RECIBIDO`, `COMENTARIO`) VALUES ('$nombre', '$correo', '$fecha_recibido', '$comentario')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$fecha_recibido=mysqli_real_escape_string($conexion, $_POST['fecha_recibido']);
			$comentario=mysqli_real_escape_string($conexion, $_POST['comentario']);
			$consulta="UPDATE `contactanos` SET 
			`NOMBRE`='$nombre', 
			`CORREO`='$correo', 
			`FECHA_RECIBIDO`='$fecha_recibido', 
			`COMENTARIO`='$comentario' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `contactanos` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `contactanos`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['FECHA_RECIBIDO'][$i]=$fila['FECHA_RECIBIDO'];
		$datos['COMENTARIO'][$i]=$fila['COMENTARIO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Comentarios</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<?php
		//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if(isset($_GET["NA_Accion"])){
			if($_GET["NA_Accion"]=="insertar"){
		?>
			<div class="col-md-10 col-lg-7 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Insertar nuevo Mensaje de Contacto"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Mensaje:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_comentarios.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_comentarios.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="introduzca el correo de quien hace el nuevo comentario de contacto" required autocomplete="off" title="introduzca el correo de quien hace el nuevo comentario de contacto">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="introduzca el nombre de quien hace el nuevo comentario de contacto" required autocomplete="off" title="introduzca el nombre de quien hace el nuevo comentario de contacto">
					</div>
					<div id="click01" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Recibido</span>
						</div>
						<input id="datepicker01" type='text' class="form-control text-center" name="fecha_recibido" placeholder="Fecha Recibido (Y-m-d)" required autocomplete="off" title="introduzca la Fecha en la que se hizo el comentario de contacto (Y-m-d)">
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField:"datepicker01",// id of the input field
								ifFormat:"%Y-%m-%d",// format of the input field
								button: "click01",// trigger for the calendar (button ID)
								align:"Tl",// alignment (defaults to "Bl")
								singleClick:true
							});
						});
					</script>
					<span class="input-group-text w-100">Comentario de Contacto:</span>
					<textarea rows="7" name="comentario" id="comentario" class="form-control mb-2" required></textarea>
					<script>
						$(document).ready(function() {
							$('#comentario').summernote({
								placeholder: 'introduzca nuevo comentario de contacto',
								tabsize: 1,
								height: 200								
							});
						});
					</script>
					<a href="CRUD_comentarios.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger mt-2">
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `contactanos` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['NOMBRE']=$fila['NOMBRE'];
					$datos_a_actualizar['CORREO']=$fila['CORREO'];
					$datos_a_actualizar['FECHA_RECIBIDO']=$fila['FECHA_RECIBIDO'];
					$datos_a_actualizar['COMENTARIO']=$fila['COMENTARIO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-10 col-lg-7 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar un Mensaje de Contacto existente"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Mensaje:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_comentarios.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_comentarios.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="Modifique el correo de quien hace el nuevo comentario de contacto" required autocomplete="off" title="Modifique el correo de quien hace el nuevo comentario de contacto" value="<?php echo $datos_a_actualizar['CORREO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="Modifique el nombre de quien hace el nuevo comentario de contacto" required autocomplete="off" title="Modifique el nombre de quien hace el nuevo comentario de contacto" value="<?php echo $datos_a_actualizar['NOMBRE']; ?>">
					</div>
					<div id="click01" class="input-group date pickers mb-2">
						<div class="input-group-append w-25">
							<span class="input-group-text fa fa-calendar w-100 text-left"> Recibido</span>
						</div>
						<input id="datepicker01" type='text' class="form-control text-center" name="fecha_recibido" placeholder="Fecha Recibido (Y-m-d)" required autocomplete="off" title="Modifique la Fecha en la que se hizo el comentario de contacto (Y-m-d)" value="<?php echo $datos_a_actualizar['FECHA_RECIBIDO']; ?>">
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField:"datepicker01",// id of the input field
								ifFormat:"%Y-%m-%d",// format of the input field
								button: "click01",// trigger for the calendar (button ID)
								align:"Tl",// alignment (defaults to "Bl")
								singleClick:true
							});
						});
					</script>
					<span class="input-group-text w-100">Comentario de Contacto:</span>
					<textarea rows="7" name="comentario" id="comentario" class="form-control mb-2" required><?php echo $datos_a_actualizar['COMENTARIO']; ?></textarea>
					<script>
						$(document).ready(function() {
							$('#comentario').summernote({
								placeholder: 'Modifique nuevo comentario de contacto',
								tabsize: 1,
								height: 200								
							});
						});
					</script>
					<a href="CRUD_comentarios.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger mt-2">
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_comentarios.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Comentario de contactos recibidos:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Correo Electrónico de la persona que hizo el contacto">Correo</b></th>
								<th class="align-middle"><b title="Nombre y Comentario de la persona que hizo el contacto">Nombre: Comentario</b></th>
								<th class="align-middle"><b title="Fecha en la que se recibió el contacto">Fecha<br>Recibido</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_comentarios.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-center"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['CORREO'][$i]; ?></td>
								<td class="text-justify"><?php echo "<b class='float-left pr-2'>" . $datos['NOMBRE'][$i] . ":</b>" . $datos['COMENTARIO'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['FECHA_RECIBIDO'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_comentarios.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_comentarios.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline"onclick="return confirmar<?php echo $i; ?>('CCRUD_comentariosphp?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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