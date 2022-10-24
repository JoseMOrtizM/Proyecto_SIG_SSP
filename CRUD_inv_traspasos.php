<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	$mensaje_error="";//ALERTA DE NO INVENTARIO
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$nombre_articulo=mysqli_real_escape_string($conexion, $_POST['nombre_articulo']);
			$correo_desde=mysqli_real_escape_string($conexion, $_POST['correo_desde']);
			$correo_hacia=mysqli_real_escape_string($conexion, $_POST['correo_hacia']);
			$cantidad=mysqli_real_escape_string($conexion, $_POST['cantidad']);
			$fecha_envio=mysqli_real_escape_string($conexion, $_POST['fecha_envio']);
			$fecha_recibido=mysqli_real_escape_string($conexion, $_POST['fecha_recibido']);
			$consulta="SELECT `CORREO` FROM `inv_cliente_proveedor` GROUP BY `CORREO`";
			$resultados=mysqli_query($conexion,$consulta);
			$e=0;
			$verf_proveedor=0;
			while(($fila=mysqli_fetch_array($resultados))==true){
				$correos_clientes[$e]=$fila['CORREO'];
				if($correos_clientes[$e]==$correo_desde){
					$verf_proveedor=1;
				}
				$e=$e+1;
			}
			if($verf_proveedor>0){
				$consulta="INSERT INTO `inv_operacion`(`NOMBRE_ARTICULO`, `CORREO_DESDE`, `CORREO_HACIA`, `CANTIDAD`, `FECHA_ENVIO`, `FECHA_RECIBIDO`) VALUES ('$nombre_articulo', '$correo_desde', '$correo_hacia', '$cantidad', '$fecha_envio', '$fecha_recibido')";
				$resultados=mysqli_query($conexion,$consulta);
			}else{
				//VERIFICANDO EXISTENCIA DE INVENTARIO
				$consulta="SELECT `NOMBRE_ARTICULO`, SUM(`CANTIDAD`) AS CANTIDAD FROM `inv_operacion` WHERE `NOMBRE_ARTICULO`='$nombre_articulo' AND `CORREO_HACIA`='$correo_desde' AND `FECHA_RECIBIDO`<>'0000-00-00' AND `FECHA_RECIBIDO`<'$fecha_recibido'";
				$resultados=mysqli_query($conexion,$consulta);
				$fila=mysqli_fetch_array($resultados);
				$cantidad_recibida=$fila['CANTIDAD'];
				$consulta="SELECT `NOMBRE_ARTICULO`, SUM(`CANTIDAD`) AS CANTIDAD FROM `inv_operacion` WHERE `NOMBRE_ARTICULO`='$nombre_articulo' AND `CORREO_DESDE`='$correo_desde' AND `FECHA_RECIBIDO`<>'0000-00-00' AND `FECHA_RECIBIDO`<'$fecha_recibido'";
				$resultados=mysqli_query($conexion,$consulta);
				$fila=mysqli_fetch_array($resultados);
				$cantidad_enviada=$fila['CANTIDAD'];
				$cantidad_disponible=$cantidad_recibida-$cantidad_enviada;
				if($cantidad>$cantidad_disponible){
					$mensaje_error="<h6 class='bg-warning text-justify p-2 my-1'>No se dispone de suficiente inventario para realizar esta operación (al $fecha_recibido, hay $cantidad_disponible $nombre_articulo disponible para $correo_desde y se pretende enviar $cantidad)</h6>";
				}else{
					$consulta="INSERT INTO `inv_operacion`(`NOMBRE_ARTICULO`, `CORREO_DESDE`, `CORREO_HACIA`, `CANTIDAD`, `FECHA_ENVIO`, `FECHA_RECIBIDO`) VALUES ('$nombre_articulo', '$correo_desde', '$correo_hacia', '$cantidad', '$fecha_envio', '$fecha_recibido')";
					$resultados=mysqli_query($conexion,$consulta);
				}
			}
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$nombre_articulo=mysqli_real_escape_string($conexion, $_POST['nombre_articulo']);
			$correo_desde=mysqli_real_escape_string($conexion, $_POST['correo_desde']);
			$correo_hacia=mysqli_real_escape_string($conexion, $_POST['correo_hacia']);
			$cantidad=mysqli_real_escape_string($conexion, $_POST['cantidad']);
			$fecha_envio=mysqli_real_escape_string($conexion, $_POST['fecha_envio']);
			$fecha_recibido=mysqli_real_escape_string($conexion, $_POST['fecha_recibido']);
			$consulta="SELECT `CORREO` FROM `inv_cliente_proveedor` GROUP BY `CORREO`";
			$resultados=mysqli_query($conexion,$consulta);
			$e=0;
			$verf_proveedor=0;
			while(($fila=mysqli_fetch_array($resultados))==true){
				$correos_clientes[$e]=$fila['CORREO'];
				if($correos_clientes[$e]==$correo_desde){
					$verf_proveedor=1;
				}
				$e=$e+1;
			}
			if($verf_proveedor>0){
				$consulta="UPDATE `inv_operacion` SET 
				`NOMBRE_ARTICULO`='$nombre_articulo', 
				`CORREO_DESDE`='$correo_desde', 
				`CORREO_HACIA`='$correo_hacia', 
				`CANTIDAD`='$cantidad', 
				`FECHA_ENVIO`='$fecha_envio', 
				`FECHA_RECIBIDO`='$fecha_recibido' 
				WHERE `ID`='$crud_id'";
				$resultados=mysqli_query($conexion,$consulta);
			}else{
				//VERIFICANDO EXISTENCIA DE INVENTARIO
				$consulta="SELECT `NOMBRE_ARTICULO`, SUM(`CANTIDAD`) AS CANTIDAD FROM `inv_operacion` WHERE `NOMBRE_ARTICULO`='$nombre_articulo' AND `CORREO_HACIA`='$correo_desde' AND `FECHA_RECIBIDO`<>'0000-00-00' AND `FECHA_RECIBIDO`<'$fecha_recibido'";
				$resultados=mysqli_query($conexion,$consulta);
				$fila=mysqli_fetch_array($resultados);
				$cantidad_recibida=$fila['CANTIDAD'];
				$consulta="SELECT `NOMBRE_ARTICULO`, SUM(`CANTIDAD`) AS CANTIDAD FROM `inv_operacion` WHERE `NOMBRE_ARTICULO`='$nombre_articulo' AND `CORREO_DESDE`='$correo_desde' AND `FECHA_RECIBIDO`<>'0000-00-00' AND `FECHA_RECIBIDO`<'$fecha_recibido'";
				$resultados=mysqli_query($conexion,$consulta);
				$fila=mysqli_fetch_array($resultados);
				$cantidad_enviada=$fila['CANTIDAD'];
				$cantidad_disponible=$cantidad_recibida-$cantidad_enviada;
				if($cantidad>$cantidad_disponible){
					$mensaje_error="<h6 class='bg-warning text-justify p-2 my-1'>No se dispone de suficiente inventario para realizar esta operación (al $fecha_recibido, hay $cantidad_disponible $nombre_articulo disponible para $correo_desde y se pretende enviar $cantidad)</h6>";
				}else{
					$consulta="UPDATE `inv_operacion` SET 
					`NOMBRE_ARTICULO`='$nombre_articulo', 
					`CORREO_DESDE`='$correo_desde', 
					`CORREO_HACIA`='$correo_hacia', 
					`CANTIDAD`='$cantidad', 
					`FECHA_ENVIO`='$fecha_envio', 
					`FECHA_RECIBIDO`='$fecha_recibido' 
					WHERE `ID`='$crud_id'";
					$resultados=mysqli_query($conexion,$consulta);
				}
			}
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `inv_operacion` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `inv_operacion`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['NOMBRE_ARTICULO'][$i]=$fila['NOMBRE_ARTICULO'];
		$datos['CORREO_DESDE'][$i]=$fila['CORREO_DESDE'];
		$datos['CORREO_HACIA'][$i]=$fila['CORREO_HACIA'];
		$datos['CANTIDAD'][$i]=$fila['CANTIDAD'];
		$datos['FECHA_ENVIO'][$i]=$fila['FECHA_ENVIO'];
		$datos['FECHA_RECIBIDO'][$i]=$fila['FECHA_RECIBIDO'];
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
						<h3 class="text-center text-md-left" title="Insertar nueva Transferencia de Material al Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Traspaso:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_traspasos.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_traspasos.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Artículo:</span>
						</div>
						<select name="nombre_articulo" id="nombre_articulo" class="form-control mb-2 text-center" required title="Elija un Artículo" autocomplete="off">
							<option></option>
							<?php
								$consulta_i="SELECT `NOMBRE_ART` FROM `inv_articulos` GROUP BY `NOMBRE_ART` ORDER BY `NOMBRE_ART`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['NOMBRE_ART'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="row">
						<div class="col-6">
							<span class="input-group-text w-100 rounded-0">Desde:</span>
							<select name="correo_desde" id="correo_desde" class="form-control mb-2 text-center rounded-0" required title="Elija un Correo de Usuario, Cliente o Proveedor que entrega" autocomplete="off">
								<option></option>
								<?php
									$consulta_i="SELECT `CORREO`, `NOMBRE`, `APELLIDO` FROM `usuarios` GROUP BY `CORREO`, `NOMBRE`, `APELLIDO` ORDER BY `NOMBRE`, `APELLIDO`, `CORREO`";
									$resultados_i=mysqli_query($conexion,$consulta_i);
									$i=0;
									while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
										$datos_ii[$i]['NOMBRE']=$fila_i['NOMBRE'];
										$datos_ii[$i]['APELLIDO']=$fila_i['APELLIDO'];
										$datos_ii[$i]['CORREO']=$fila_i['CORREO'];
										echo "<option value='" . $datos_ii[$i]['CORREO'] . "'>" . $datos_ii[$i]['NOMBRE'] . " " . $datos_ii[$i]['APELLIDO'] . "</option>";
										$i=$i+1;
									}
									$consulta_i="SELECT `CORREO`, `NOMBRE_COMPLETO`, `TIPO` FROM `inv_cliente_proveedor` GROUP BY `CORREO`, `NOMBRE_COMPLETO`, `TIPO` ORDER BY `CORREO`, `NOMBRE_COMPLETO`, `TIPO`";
									$resultados_i=mysqli_query($conexion,$consulta_i);
									while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
										$datos_ii[$i]['NOMBRE']=$fila_i['NOMBRE_COMPLETO'];
										$datos_ii[$i]['APELLIDO']=$fila_i['TIPO'];
										$datos_ii[$i]['CORREO']=$fila_i['CORREO'];
										echo "<option value='" . $datos_ii[$i]['CORREO'] . "'>" . $datos_ii[$i]['NOMBRE'] . " " . $datos_ii[$i]['APELLIDO'] . "</option>";
										$i=$i+1;
									}
								?>
							</select>
						</div>
						<div class="col-6">
							<span class="input-group-text w-100 rounded-0">Hacia:</span>
							<select name="correo_hacia" id="correo_hacia" class="form-control mb-2 text-center rounded-0" required title="Elija un Correo de Usuario, Cliente o Proveedor que recibe" autocomplete="off">
								<option></option>
								<?php
									$i=0;
									while(isset($datos_ii[$i]['NOMBRE'])){
										echo "<option value='" . $datos_ii[$i]['CORREO'] . "'>" . $datos_ii[$i]['NOMBRE'] . " " . $datos_ii[$i]['APELLIDO'] . "</option>";
										$i=$i+1;
									}
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<span class="input-group-text fa w-100 text-left rounded-0">Cantidad:</span>
							<input type="number" class="form-control col mb-2 rounded-0 text-center" name="cantidad" id="cantidad" placeholder="Ctd traspasada" required autocomplete="off" title="introduzca la cantidad de unidades transferidas" min="0">
						</div>
						<div class="col-4">
							<div id="click01" class="input-group date pickers mb-2">
								<span class="input-group-text fa fa-calendar w-100 text-left rounded-0"> Enviado</span>
								<input id="datepicker01" type='text' class="form-control text-center rounded-0" name="fecha_envio" placeholder="(Y-m-d)" required autocomplete="off" title="introduzca la Fecha de Envio del artículo (Y-m-d)">
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
						<div class="col-4">
							<div id="click02" class="input-group date pickers mb-2">
								<span class="input-group-text fa fa-calendar w-100 text-left rounded-0"> Recibido</span>
								<input id="datepicker02" type='text' class="form-control text-center rounded-0" name="fecha_recibido" placeholder="(Y-m-d)" required autocomplete="off" title="introduzca la Fecha de recibido del artículo (Y-m-d)">
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
					</div>
					<div class="m-auto">
						<a href="CRUD_inv_traspasos.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
				<br><br><br><br><br><br>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `inv_operacion` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['NOMBRE_ARTICULO']=$fila['NOMBRE_ARTICULO'];
					$datos_a_actualizar['CORREO_DESDE']=$fila['CORREO_DESDE'];
					$datos_a_actualizar['CORREO_HACIA']=$fila['CORREO_HACIA'];
					$datos_a_actualizar['CANTIDAD']=$fila['CANTIDAD'];
					$datos_a_actualizar['FECHA_ENVIO']=$fila['FECHA_ENVIO'];
					$datos_a_actualizar['FECHA_RECIBIDO']=$fila['FECHA_RECIBIDO'];
					$i=$i+1;
				}
		?>
			<div class="col-md-10 col-lg-7 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar una Transferencia de Material en el Sistema de Inventario"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Traspaso:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_inv_traspasos.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_inv_traspasos.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Artículo:</span>
						</div>
						<select name="nombre_articulo" id="nombre_articulo" class="form-control mb-2 text-center" required title="Elija un Artículo" autocomplete="off">
							<option><?php echo $datos_a_actualizar['NOMBRE_ARTICULO']; ?></option>
							<?php
								$consulta_i="SELECT `NOMBRE_ART` FROM `inv_articulos` GROUP BY `NOMBRE_ART` ORDER BY `NOMBRE_ART`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['NOMBRE_ART'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="row">
						<div class="col-6">
							<span class="input-group-text w-100 rounded-0">Desde:</span>
							<select name="correo_desde" id="correo_desde" class="form-control mb-2 text-center" required title="Elija un Correo de Usuario, Cliente o Proveedor que entrega" autocomplete="off">
								<option value="<?php echo $datos_a_actualizar['CORREO_DESDE']; ?>"><?php echo $datos_a_actualizar['CORREO_DESDE']; ?></option>
								<?php
									$consulta_i="SELECT `CORREO`, `NOMBRE`, `APELLIDO` FROM `usuarios` GROUP BY `CORREO`, `NOMBRE`, `APELLIDO` ORDER BY `NOMBRE`, `APELLIDO`, `CORREO`";
									$resultados_i=mysqli_query($conexion,$consulta_i);
									$i=0;
									while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
										$datos_ii[$i]['NOMBRE']=$fila_i['NOMBRE'];
										$datos_ii[$i]['APELLIDO']=$fila_i['APELLIDO'];
										$datos_ii[$i]['CORREO']=$fila_i['CORREO'];
										echo "<option value='" . $datos_ii[$i]['CORREO'] . "'>" . $datos_ii[$i]['NOMBRE'] . " " . $datos_ii[$i]['APELLIDO'] . "</option>";
										$i=$i+1;
									}
									$consulta_i="SELECT `CORREO`, `NOMBRE_COMPLETO`, `TIPO` FROM `inv_cliente_proveedor` GROUP BY `CORREO`, `NOMBRE_COMPLETO`, `TIPO` ORDER BY `CORREO`, `NOMBRE_COMPLETO`, `TIPO`";
									$resultados_i=mysqli_query($conexion,$consulta_i);
									while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
										$datos_ii[$i]['NOMBRE']=$fila_i['NOMBRE_COMPLETO'];
										$datos_ii[$i]['APELLIDO']=$fila_i['TIPO'];
										$datos_ii[$i]['CORREO']=$fila_i['CORREO'];
										echo "<option value='" . $datos_ii[$i]['CORREO'] . "'>" . $datos_ii[$i]['NOMBRE'] . " " . $datos_ii[$i]['APELLIDO'] . "</option>";
										$i=$i+1;
									}
								?>
							</select>
						</div>
						<div class="col-6">
							<span class="input-group-text w-100 rounded-0">Hacia:</span>
							<select name="correo_hacia" id="correo_hacia" class="form-control mb-2 text-center" required title="Elija un Correo de Usuario, Cliente o Proveedor que recibe" autocomplete="off">
								<option value="<?php echo $datos_a_actualizar['CORREO_HACIA']; ?>"><?php echo $datos_a_actualizar['CORREO_HACIA']; ?></option>
								<?php
									$i=0;
									while(isset($datos_ii[$i]['NOMBRE'])){
										echo "<option value='" . $datos_ii[$i]['CORREO'] . "'>" . $datos_ii[$i]['NOMBRE'] . " " . $datos_ii[$i]['APELLIDO'] . "</option>";
										$i=$i+1;
									}
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<span class="input-group-text fa w-100 text-left rounded-0">Cantidad:</span>
							<input type="number" class="form-control col mb-2 rounded-0 text-center" name="cantidad" id="cantidad" placeholder="Ctd traspasada" required autocomplete="off" title="introduzca la cantidad de unidades transferidas" min="0" value="<?php echo $datos_a_actualizar['CANTIDAD']; ?>">
						</div>
						<div class="col-4">
							<div id="click01" class="input-group date pickers mb-2">
								<span class="input-group-text fa fa-calendar w-100 text-left rounded-0"> Enviado</span>
								<input id="datepicker01" type='text' class="form-control text-center rounded-0" name="fecha_envio" placeholder="(Y-m-d)" required autocomplete="off" title="introduzca la Fecha de Envio del artículo (Y-m-d)" value="<?php echo $datos_a_actualizar['FECHA_ENVIO']; ?>">
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
						<div class="col-4">
							<div id="click02" class="input-group date pickers mb-2">
								<span class="input-group-text fa fa-calendar w-100 text-left rounded-0"> Recibido</span>
								<input id="datepicker02" type='text' class="form-control text-center rounded-0" name="fecha_recibido" placeholder="(Y-m-d)" required autocomplete="off" title="introduzca la Fecha de recibido del artículo (Y-m-d)" value="<?php echo $datos_a_actualizar['FECHA_RECIBIDO']; ?>">
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
					</div>
					<div class="m-auto">
						<a href="CRUD_inv_traspasos.php" class="btn btn-danger text-light mt-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger mt-2">
					</div>
				</form>
				<br><br><br><br><br><br>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_inv_traspasos.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<?php echo $mensaje_error; ?>
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Traspasos Existentes en el Inventario:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Nombre del Artículo">Artículo</b></th>
								<th class="align-middle"><b title="Correo de quien lo entrega">Desde</b></th>
								<th class="align-middle"><b title="Correo de quien lo recibe">Hacia</b></th>
								<th class="align-middle"><b title="Cantidad de Unidades transferidas de este artículo">Cantidad</b></th>
								<th class="align-middle"><b title="Fecha de Envio del artículo">Fecha<br>Envio</b></th>
								<th class="align-middle"><b title="Fecha de Recibido del artículo">Fecha<br>Recibido</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_inv_traspasos.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['NOMBRE_ARTICULO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['CORREO_DESDE'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['CORREO_HACIA'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['CANTIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['FECHA_ENVIO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['FECHA_RECIBIDO'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_inv_traspasos.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_inv_traspasos.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_inv_traspasos?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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