<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$nombre_completo=mysqli_real_escape_string($conexion, $_POST['nombre_completo']);
			$direccion=mysqli_real_escape_string($conexion, $_POST['direccion']);
			$telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$tipo=mysqli_real_escape_string($conexion, $_POST['tipo']);
			$consulta="INSERT INTO `inv_cliente_proveedor` (`NOMBRE_COMPLETO`, `DIRECCION`, `TELEFONO`, `CORREO`, `TIPO`) VALUES ('$nombre_completo', '$direccion', '$telefono', '$correo', '$tipo')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$nombre_completo=mysqli_real_escape_string($conexion, $_POST['nombre_completo']);
			$direccion=mysqli_real_escape_string($conexion, $_POST['direccion']);
			$telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
			$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
			$tipo=mysqli_real_escape_string($conexion, $_POST['tipo']);
			$consulta="UPDATE `inv_cliente_proveedor` SET 
			`NOMBRE_COMPLETO`='$nombre_completo', 
			`DIRECCION`='$direccion', 
			`TELEFONO`='$telefono', 
			`CORREO`='$correo', 
			`TIPO`='$tipo' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `inv_cliente_proveedor` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `inv_cliente_proveedor`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['NOMBRE_COMPLETO'][$i]=$fila['NOMBRE_COMPLETO'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['TIPO'][$i]=$fila['TIPO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Inv-Clt/Prov</title>
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
						<h3 class="text-center text-md-left" title="Insertar nuevo Cliente/Proveedor al Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Proveedor:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_clientes.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_clientes.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre_completo" id="nombre_completo" placeholder="Nombre del Cliente o Proveedor" required autocomplete="off" title="introduzca el nombre completo del Cliente o Proveedor Externo a la Empresa">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Dirección:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="direccion" id="direccion" placeholder="Dirección del Cliente o Proveedor" required autocomplete="off" title="introduzca la direccion del Cliente o Proveedor Externo a la Empresa">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="Correo del Cliente o Proveedor" required autocomplete="off" title="introduzca el correo del Cliente o Proveedor Externo a la Empresa">
					</div>
					<div class="row">
						<div class="col-6">
								<span class="input-group-text w-100 rounded-0">Teléfono:</span>
								<input type="tel" class="form-control col mb-2 rounded-0" name="telefono" id="telefono" placeholder="Teléfono del Cliente o Proveedor" required autocomplete="off" title="introduzca el teléfono del Cliente o Proveedor">
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Tipo:</span>
								<select class="form-control col mb-2 rounded-0" name="tipo" id="tipo" placeholder="Indique si es Cliente o Proveedor" required autocomplete="off" title="Indique si es Cliente o Proveedor">
									<option></option>
									<option>CLIENTE</option>
									<option>PROVEEDOR</option>
								</select>
							</div>
						</div>
					</div>
					<div class="m-auto">
						<a href="CRUD_inv_clientes.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
				<br><br><br><br><br>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `inv_cliente_proveedor` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['NOMBRE_COMPLETO']=$fila['NOMBRE_COMPLETO'];
					$datos_a_actualizar['DIRECCION']=$fila['DIRECCION'];
					$datos_a_actualizar['TELEFONO']=$fila['TELEFONO'];
					$datos_a_actualizar['CORREO']=$fila['CORREO'];
					$datos_a_actualizar['TIPO']=$fila['TIPO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-10 col-lg-7 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar un Cliente/Proveedor en el Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Proveedor:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_clientes.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_clientes.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre_completo" id="nombre_completo" placeholder="Nombre del Cliente o Proveedor" required autocomplete="off" title="Modifique el nombre completo del Cliente o Proveedor Externo a la Empresa" value="<?php echo $datos_a_actualizar['NOMBRE_COMPLETO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Dirección:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="direccion" id="direccion" placeholder="Dirección del Cliente o Proveedor" required autocomplete="off" title="Modifique la direccion del Cliente o Proveedor Externo a la Empresa" value="<?php echo $datos_a_actualizar['DIRECCION']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Correo:</span>
						</div>
						<input type="email" class="form-control col mb-2" name="correo" id="correo" placeholder="Correo del Cliente o Proveedor" required autocomplete="off" title="Modifique el correo del Cliente o Proveedor Externo a la Empresa" value="<?php echo $datos_a_actualizar['CORREO']; ?>">
					</div>
					<div class="row">
						<div class="col-6">
								<span class="input-group-text w-100 rounded-0">Teléfono:</span>
								<input type="tel" class="form-control col mb-2 rounded-0" name="telefono" id="telefono" placeholder="Teléfono del Cliente o Proveedor" required autocomplete="off" title="Modifiue el teléfono del Cliente o Proveedor" value="<?php echo $datos_a_actualizar['TELEFONO']; ?>">
						</div>
						<div class="col-6">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Tipo:</span>
								<select class="form-control col mb-2 rounded-0" name="tipo" id="tipo" placeholder="Indique si es Cliente o Proveedor" required autocomplete="off" title="Indique si es Cliente o Proveedor">
									<option><?php echo $datos_a_actualizar['TIPO']; ?></option>
									<option>CLIENTE</option>
									<option>PROVEEDOR</option>
								</select>
							</div>
						</div>
					</div>
					<div class="m-auto">
						<a href="CRUD_inv_clientes.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
				<br><br><br><br><br>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_inv_clientes.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Clientes y Proveedores Existentes en el Sitio:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Cliente / Proveedor">Tipo</b></th>
								<th class="align-middle"><b title="Nombre del Cliente o Proveedor">Nombre</b></th>
								<th class="align-middle"><b title="Teléfono del Cliente o Proveedor">Teléfono</b></th>
								<th class="align-middle"><b title="Correo electrónico del Cliente o Proveedor">Correo</b></th>
								<th class="align-middle"><b title="Dirección del Cliente o Proveedor">Dirección</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_inv_clientes.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['TIPO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['NOMBRE_COMPLETO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['CORREO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['TELEFONO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['DIRECCION'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_inv_clientes.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_inv_clientes.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_inv_clientes?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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