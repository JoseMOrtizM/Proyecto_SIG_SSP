<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$categoria=mysqli_real_escape_string($conexion, $_POST['categoria']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$fecha_carga=date('Y-m-d');
			$correo_responsable=$usuario_correo;
			$consulta="INSERT INTO `inv_categorias` (`CATEGORIA`, `DESCRIPCION`, `FECHA_CARGA`, `CORREO_RESPONSABLE`) VALUES ('$categoria', '$descripcion', '$fecha_carga', '$correo_responsable')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$categoria=mysqli_real_escape_string($conexion, $_POST['categoria']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$fecha_carga=date('Y-m-d');
			$correo_responsable=$usuario_correo;
			$consulta="UPDATE `inv_categorias` SET 
			`CATEGORIA`='$categoria', 
			`DESCRIPCION`='$descripcion', 
			`FECHA_CARGA`='$fecha_carga', 
			`CORREO_RESPONSABLE`='$correo_responsable' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `inv_categorias` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `inv_categorias`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['CATEGORIA'][$i]=$fila['CATEGORIA'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['FECHA_CARGA'][$i]=$fila['FECHA_CARGA'];
		$datos['CORREO_RESPONSABLE'][$i]=$fila['CORREO_RESPONSABLE'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Inv-Categorias</title>
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
						<h3 class="text-center text-md-left" title="Insertar nueva Categoría al Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Categoría:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_categorias.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_categorias.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Categoría:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="categoria" id="categoria" placeholder="Nueva categoría" required autocomplete="off" title="introduzca el nombre de la nueva categoría">
					</div>
					<span class="input-group-text w-100">Descripción de la Categoría:</span>
					<textarea rows="7" name="descripcion" id="descripcion" class="form-control mb-2" required></textarea>
					<script>
						$(document).ready(function() {
							$('#descripcion').summernote({
								placeholder: 'introduzca la descripción de la nueva categoría',
								tabsize: 1,
								height: 200								
							});
						});
					</script>
					<div class="m-auto">
						<a href="CRUD_inv_categorias.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `inv_categorias` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['CATEGORIA']=$fila['CATEGORIA'];
					$datos_a_actualizar['DESCRIPCION']=$fila['DESCRIPCION'];
					$datos_a_actualizar['FECHA_CARGA']=$fila['FECHA_CARGA'];
					$datos_a_actualizar['CORREO_RESPONSABLE']=$fila['CORREO_RESPONSABLE'];
					$i=$i+1;
				}
		?>
			<div class="col-md-10 col-lg-7 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar una Categoría en el Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Categoría:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_categorias.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_categorias.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Categoría:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="categoria" id="categoria" placeholder="Nueva categoría" required autocomplete="off" title="introduzca el nombre de la nueva categoría" value="<?php echo $datos_a_actualizar['CATEGORIA']; ?>">
					</div>
					<span class="input-group-text w-100">Descripción de la Categoría:</span>
					<textarea rows="7" name="descripcion" id="descripcion" class="form-control mb-2" required><?php echo $datos_a_actualizar['DESCRIPCION']; ?></textarea>
					<script>
						$(document).ready(function() {
							$('#descripcion').summernote({
								placeholder: 'introduzca la descripción de la nueva categoría',
								tabsize: 1,
								height: 200								
							});
						});
					</script>
					<div class="m-auto">
						<a href="CRUD_inv_categorias.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_inv_categorias.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Categorías Existentes en el Inventario:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Nombre de la Categoría">Categría</b></th>
								<th class="align-middle"><b title="Descripción de la Categoría">Descripción:</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_inv_categorias.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-center"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['CATEGORIA'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['DESCRIPCION'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_inv_categorias.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_inv_categorias.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_inv_categorias?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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