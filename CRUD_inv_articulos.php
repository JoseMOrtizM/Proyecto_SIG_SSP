<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$nombre_art=mysqli_real_escape_string($conexion, $_POST['nombre_art']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$inventario_minimo=mysqli_real_escape_string($conexion, $_POST['inventario_minimo']);
			$unidad=mysqli_real_escape_string($conexion, $_POST['unidad']);
			$categoria=mysqli_real_escape_string($conexion, $_POST['categoria']);
			$fecha_carga=date('Y-m-d');
			$correo_responsable=$usuario_correo;
			$consulta="INSERT INTO `inv_articulos` (`NOMBRE_ART`, `DESCRIPCION`, `INVENTARIO_MINIMO`, `UNIDAD`, `FECHA_CARGA`, `CATEGORIA`, `CORREO_RESPONSABLE`) VALUES ('$nombre_art', '$descripcion', '$inventario_minimo', '$unidad', '$fecha_carga', '$categoria', '$correo_responsable')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$nombre_art=mysqli_real_escape_string($conexion, $_POST['nombre_art']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$inventario_minimo=mysqli_real_escape_string($conexion, $_POST['inventario_minimo']);
			$unidad=mysqli_real_escape_string($conexion, $_POST['unidad']);
			$categoria=mysqli_real_escape_string($conexion, $_POST['categoria']);
			$fecha_carga=date('Y-m-d');
			$correo_responsable=$usuario_correo;
			$consulta="UPDATE `inv_articulos` SET 
			`NOMBRE_ART`='$nombre_art', 
			`DESCRIPCION`='$descripcion', 
			`INVENTARIO_MINIMO`='$inventario_minimo', 
			`UNIDAD`='$unidad', 
			`CATEGORIA`='$categoria', 
			`FECHA_CARGA`='$fecha_carga', 
			`CORREO_RESPONSABLE`='$correo_responsable' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `inv_articulos` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `inv_articulos`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['NOMBRE_ART'][$i]=$fila['NOMBRE_ART'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['INVENTARIO_MINIMO'][$i]=$fila['INVENTARIO_MINIMO'];
		$datos['UNIDAD'][$i]=$fila['UNIDAD'];
		$datos['CATEGORIA'][$i]=$fila['CATEGORIA'];
		$datos['FECHA_CARGA'][$i]=$fila['FECHA_CARGA'];
		$datos['CORREO_RESPONSABLE'][$i]=$fila['CORREO_RESPONSABLE'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Inv-Artículos</title>
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
						<h3 class="text-center text-md-left" title="Insertar nuevo Artículo al Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Artículo:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_articulos.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_articulos.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Categoría:</span>
						</div>
						<select name="categoria" id="categoria" class="form-control mb-2 text-center" required title="Elija una categoría" autocomplete="off">
							<option></option>
							<?php
								$consulta_i="SELECT `CATEGORIA` FROM `inv_categorias` GROUP BY `CATEGORIA` ORDER BY `CATEGORIA`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['CATEGORIA'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre_art" id="nombre_art" placeholder="Nombre del nuevo Artículo" required autocomplete="off" title="introduzca el nombre del nuevo Artículo">
					</div>
					<span class="input-group-text w-100">Descripción del Artículo:</span>
					<textarea rows="7" name="descripcion" id="descripcion" class="form-control mb-2" required></textarea>
					<script>
						$(document).ready(function() {
							$('#descripcion').summernote({
								placeholder: 'introduzca la descripción del nuevo Artículo',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="row">
						<div class="col-6">
								<span class="input-group-text w-100 rounded-0">Unidad:</span>
								<input type="text" class="form-control col mb-2 rounded-0" name="unidad" id="unidad" placeholder="Unidad del Artículo" required autocomplete="off" title="introduzca la unidad correspondiente al artículo">
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Cantidad Mínima:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="inventario_minimo" id="inventario_minimo" placeholder="Mínimo inventario" required autocomplete="off" title="introduzca la cantidad mínima de Unidades que se requerirán en el inventario" min="0">
							</div>
						</div>
					</div>
					<div class="m-auto">
						<a href="CRUD_inv_articulos.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `inv_articulos` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['NOMBRE_ART']=$fila['NOMBRE_ART'];
					$datos_a_actualizar['DESCRIPCION']=$fila['DESCRIPCION'];
					$datos_a_actualizar['INVENTARIO_MINIMO']=$fila['INVENTARIO_MINIMO'];
					$datos_a_actualizar['UNIDAD']=$fila['UNIDAD'];
					$datos_a_actualizar['CATEGORIA']=$fila['CATEGORIA'];
					$datos_a_actualizar['FECHA_CARGA']=$fila['FECHA_CARGA'];
					$datos_a_actualizar['CORREO_RESPONSABLE']=$fila['CORREO_RESPONSABLE'];
					$i=$i+1;
				}
		?>
			<div class="col-md-10 col-lg-7 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar un Artículo en el Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Artículo:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_articulos.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_articulos.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Categoría:</span>
						</div>
						<select name="categoria" id="categoria" class="form-control mb-2 text-center" required title="Elija una categoría" autocomplete="off">
							<option><?php echo $datos_a_actualizar['CATEGORIA']; ?></option>
							<?php
								$consulta_i="SELECT `CATEGORIA` FROM `inv_categorias` GROUP BY `CATEGORIA` ORDER BY `CATEGORIA`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['CATEGORIA'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre_art" id="nombre_art" placeholder="Nombre del Artículo" required autocomplete="off" title="Modifique el nombre del Artículo" value="<?php echo $datos_a_actualizar['NOMBRE_ART']; ?>">
					</div>
					<span class="input-group-text w-100">Descripción del Artículo:</span>
					<textarea rows="7" name="descripcion" id="descripcion" class="form-control mb-2" required><?php echo $datos_a_actualizar['DESCRIPCION']; ?></textarea>
					<script>
						$(document).ready(function() {
							$('#descripcion').summernote({
								placeholder: 'Modifique la descripción del nuevo Artículo',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="row">
						<div class="col-6">
								<span class="input-group-text w-100 rounded-0">Unidad:</span>
								<input type="text" class="form-control col mb-2 rounded-0" name="unidad" id="unidad" placeholder="Unidad del Artículo" required autocomplete="off" title="Modifique la unidad correspondiente al artículo" value="<?php echo $datos_a_actualizar['UNIDAD']; ?>">
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Cantidad Mínima:</span>
								<input type="number" class="form-control col mb-2 rounded-0" name="inventario_minimo" id="inventario_minimo" placeholder="Mínimo inventario" required autocomplete="off" title="Modifique la cantidad mínima de Unidades que se requerirán en el inventario" min="0" value="<?php echo $datos_a_actualizar['INVENTARIO_MINIMO']; ?>">
							</div>
						</div>
					</div>
					<div class="m-auto">
						<a href="CRUD_inv_articulos.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_inv_articulos.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Artículos Existentes en el Inventario:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Nombre de la Categoría asociada al Artículo">Categoría</b></th>
								<th class="align-middle"><b title="Nombre del Artículo">Artículo</b></th>
								<th class="align-middle"><b title="Descripción del Artículo">Descripción:</b></th>
								<th class="align-middle"><b title="Unidad del Artículo">Unidad:</b></th>
								<th class="align-middle"><b title="Inventario mínimo para operación óptima">Inventario<br>mínimo:</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_inv_articulos.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-justify"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['CATEGORIA'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['NOMBRE_ART'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['DESCRIPCION'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['UNIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['INVENTARIO_MINIMO'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_inv_articulos.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_inv_articulos.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_inv_articulos?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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