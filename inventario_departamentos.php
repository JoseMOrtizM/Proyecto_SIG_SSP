<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	require("php_require/paleta_de_colores.php");
	//RESCATANDO DATOS DEL FORMULARIO
	if(isset($_POST["gerencia"])){
		if($_POST["gerencia"]=='Todas'){
			$gerencia="Todas";
			$sql_gerencia="";
		}else{
			$gerencia=$_POST["gerencia"];
			$sql_gerencia="AND `descripcion_de_cargos`.`TIPO_DEPARTAMENTO`='" . $gerencia . "'";
		}
	}else{
		$gerencia="Todas";
		$sql_gerencia="";
	}
	if(isset($_GET["gerencia"])){
		$gerencia=$_GET["gerencia"];
		$sql_gerencia="AND `descripcion_de_cargos`.`TIPO_DEPARTAMENTO`='" . $gerencia . "'";
	}

	if(isset($_POST["departamento"])){
		if($_POST["departamento"]=='Todos'){
			$departamento="Todos";
			$sql_departamento="";
		}else{
			$departamento=$_POST["departamento"];
			$sql_departamento="AND `descripcion_de_cargos`.`DEPARTAMENTO`='" . $departamento . "'";
		}
	}else{
		$departamento="Todos";
		$sql_departamento="";
	}
	if(isset($_GET["departamento"])){
		$departamento=$_GET["departamento"];
		$sql_departamento="AND `descripcion_de_cargos`.`DEPARTAMENTO`='" . $departamento . "'";
	}

	if(isset($_POST["empleado"])){
		if($_POST["empleado"]=='Todos'){
			$empleado="Todos";
			$sql_empleado="";
		}else{
			$empleado=$_POST["empleado"];
			$sql_empleado="AND `usuarios`.`CORREO`='" . $empleado . "'";
		}
	}else{
		$empleado="Todos";
		$sql_empleado="";
	}
	if(isset($_GET["empleado"])){
		$empleado=$_GET["empleado"];
		$sql_empleado="AND `usuarios`.`CORREO`='" . $empleado . "'";
	}

	if(isset($_POST["categoria"])){
		if($_POST["categoria"]=='Todas'){
			$categoria="Todas";
			$sql_categoria="";
		}else{
			$categoria=$_POST["categoria"];
			$sql_categoria="AND `inv_articulos`.`CATEGORIA`='" . $categoria . "'";
		}
	}else{
		$categoria="Todas";
		$sql_categoria="";
	}
	if(isset($_GET["categoria"])){
		$categoria=$_GET["categoria"];
		$sql_categoria="AND `inv_articulos`.`CATEGORIA`='" . $categoria . "'";
	}

	if(isset($_POST["articulo"])){
		if($_POST["articulo"]=='Todos'){
			$articulo="Todos";
			$sql_articulo="";
		}else{
			$articulo=$_POST["articulo"];
			$sql_articulo="AND `inv_operacion`.`NOMBRE_ARTICULO`='" . $articulo . "'";
		}
	}else{
		$articulo="Todos";
		$sql_articulo="";
	}
	if(isset($_GET["articulo"])){
		$articulo=$_GET["articulo"];
		$sql_articulo="AND `inv_operacion`.`NOMBRE_ARTICULO`='" . $articulo . "'";
	}

	//OBTENEINDO DATOS PARA LAS TABLAS Y GRAFICAS DEL INVENTARIO
	//DATOS PARA LAS GRÁFICAS
	//RESUMEN DE INVENTARIO POR GERENCIA
	$consulta="SELECT 
	`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS NOMBRE_GERENCIA,
	SUM(case when `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_RECIBIDA,
	SUM(case when `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_ENTREGADA
	FROM `inv_operacion` 
	INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO` 
	WHERE 1 
	AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
	$sql_articulo 
	$sql_gerencia
	$sql_departamento
	$sql_empleado
	$sql_categoria
	GROUP BY 
	`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` 
	ORDER BY 
	`descripcion_de_cargos`.`TIPO_DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_gcia[$i]['NOMBRE_GERENCIA']=$fila['NOMBRE_GERENCIA'];
		$inv_gcia[$i]['CANTIDAD_RECIBIDA']=$fila['CANTIDAD_RECIBIDA'];
		$inv_gcia[$i]['CANTIDAD_ENTREGADA']=$fila['CANTIDAD_ENTREGADA'];
		$inv_gcia[$i]['EN_EXISTENCIA']=$fila['CANTIDAD_RECIBIDA']-$fila['CANTIDAD_ENTREGADA'];
		$i=$i+1;
	}
	//RESUMEN DE INVENTARIO POR DEPARTAMENTO
	$consulta="SELECT 
	`descripcion_de_cargos`.`DEPARTAMENTO` AS NOMBRE_DEPARTAMENTO,
	SUM(case when `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_RECIBIDA,
	SUM(case when `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_ENTREGADA
	FROM `inv_operacion` 
	INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO` 
	WHERE 1 
	AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
	$sql_articulo 
	$sql_gerencia
	$sql_departamento
	$sql_empleado
	$sql_categoria
	GROUP BY 
	`descripcion_de_cargos`.`DEPARTAMENTO` 
	ORDER BY 
	`descripcion_de_cargos`.`DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_dpto[$i]['NOMBRE_DEPARTAMENTO']=$fila['NOMBRE_DEPARTAMENTO'];
		$inv_dpto[$i]['CANTIDAD_RECIBIDA']=$fila['CANTIDAD_RECIBIDA'];
		$inv_dpto[$i]['CANTIDAD_ENTREGADA']=$fila['CANTIDAD_ENTREGADA'];
		$inv_dpto[$i]['EN_EXISTENCIA']=$fila['CANTIDAD_RECIBIDA']-$fila['CANTIDAD_ENTREGADA'];
		$i=$i+1;
	}
	//RESUMEN DE INVENTARIO POR EMPLEADO
	$consulta="SELECT 
	`usuarios`.`APELLIDO` AS APELIIDO_EMPLEADO,
	`usuarios`.`NOMBRE` AS NOMBRE_EMPLEADO,
	`usuarios`.`CORREO` AS CORREO_EMPLEADO,
	SUM(case when `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_RECIBIDA,
	SUM(case when `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_ENTREGADA
	FROM `inv_operacion` 
	INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO` 
	WHERE 1 
	AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
	$sql_articulo 
	$sql_gerencia
	$sql_departamento
	$sql_empleado
	$sql_categoria
	GROUP BY 
	`usuarios`.`APELLIDO`, 
	`usuarios`.`NOMBRE`, 
	`usuarios`.`CORREO` 
	ORDER BY 
	`usuarios`.`APELLIDO`, 
	`usuarios`.`NOMBRE`, 
	`usuarios`.`CORREO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_user[$i]['APELIIDO_EMPLEADO']=$fila['APELIIDO_EMPLEADO'];
		$inv_user[$i]['NOMBRE_EMPLEADO']=$fila['NOMBRE_EMPLEADO'];
		$inv_user[$i]['CORREO_EMPLEADO']=$fila['CORREO_EMPLEADO'];
		$inv_user[$i]['CANTIDAD_RECIBIDA']=$fila['CANTIDAD_RECIBIDA'];
		$inv_user[$i]['CANTIDAD_ENTREGADA']=$fila['CANTIDAD_ENTREGADA'];
		$inv_user[$i]['EN_EXISTENCIA']=$fila['CANTIDAD_RECIBIDA']-$fila['CANTIDAD_ENTREGADA'];
		$i=$i+1;
	}
	//RESUMEN DE INVENTARIO POR CATEGORIA
	$consulta="SELECT 
	`inv_articulos`.`CATEGORIA` AS CATEGORIA,
	SUM(case when `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_RECIBIDA,
	SUM(case when `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_ENTREGADA
	FROM `inv_operacion` 
	INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO`
	WHERE 1 
	AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
	$sql_articulo 
	$sql_gerencia
	$sql_departamento
	$sql_empleado
	$sql_categoria
	GROUP BY 
	`inv_articulos`.`CATEGORIA` 
	ORDER BY 
	`inv_articulos`.`CATEGORIA`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_cat[$i]['CATEGORIA']=$fila['CATEGORIA'];
		$inv_cat[$i]['CANTIDAD_RECIBIDA']=$fila['CANTIDAD_RECIBIDA'];
		$inv_cat[$i]['CANTIDAD_ENTREGADA']=$fila['CANTIDAD_ENTREGADA'];
		$inv_cat[$i]['EN_EXISTENCIA']=$fila['CANTIDAD_RECIBIDA']-$fila['CANTIDAD_ENTREGADA'];
		$i=$i+1;
	}
	//RESUMEN DE INVENTARIO POR ARTICULO
	$consulta="SELECT 
	`inv_operacion`.`NOMBRE_ARTICULO` AS NOMBRE_ARTICULO,
	SUM(case when `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_RECIBIDA,
	SUM(case when `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_ENTREGADA
	FROM `inv_operacion` 
	INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO`
	WHERE 1 
	AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
	$sql_articulo 
	$sql_gerencia
	$sql_departamento
	$sql_empleado
	$sql_categoria
	GROUP BY 
	`inv_operacion`.`NOMBRE_ARTICULO` 
	ORDER BY 
	`inv_operacion`.`NOMBRE_ARTICULO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_art[$i]['NOMBRE_ARTICULO']=$fila['NOMBRE_ARTICULO'];
		$inv_art[$i]['CANTIDAD_RECIBIDA']=$fila['CANTIDAD_RECIBIDA'];
		$inv_art[$i]['CANTIDAD_ENTREGADA']=$fila['CANTIDAD_ENTREGADA'];
		$inv_art[$i]['EN_EXISTENCIA']=$fila['CANTIDAD_RECIBIDA']-$fila['CANTIDAD_ENTREGADA'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Inventario</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<!---------- FILTROS ---------->
		<form action="inventario_departamentos.php" method="post" class="text-center bg-dark p-2 my-1 rounded">
			<h4 class="mb-2 text-center rounded text-light"><span class="text-danger fa fa-cog fa-spin"></span> RESUMEN DE INVENTARIO:</h4>
			<div class="row">
				<div class="col-md-4 mb-2">
					<?php 
						//PASANDO OCULTO EL NOMBRE DE LA GERENCIA EN CASO DE QUE SE PRETENDA INGRESAR POR EL MENU DE NAVEGACIÓN DE CADA USUARIO PORQUE SE VA  A DESABILITAR EL SELECT QUE VIENE A CONTINUACIÓN
						echo "<input type='hidden' name='gerencia' value='$gerencia'>";
					?>
					<span class="input-group-text w-100 rounded-0">Gerencia:</span>
					<select class="form-control col rounded-0" name="gerencia" id="gerencia" required autocomplete="off" title="Indique la Gerencia a Mostrar" disabled>
						<option><?php echo $gerencia; ?></option>
						<option class="text-danger">Todas</option>
						<?php
							$consulta_i="SELECT 
								`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS TIPO_DEPARTAMENTO
								FROM `inv_operacion` 
								INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
								INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
								WHERE 1 
								AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
								GROUP BY 
								`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` 
								ORDER BY 
								`descripcion_de_cargos`.`TIPO_DEPARTAMENTO`";
							$resultados_i=mysqli_query($conexion,$consulta_i);
							$i=0;
							while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
								$datos_i=$fila_i['TIPO_DEPARTAMENTO'];
								echo "<option>$datos_i</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="col-md-4 mb-2">
					<div class="input-group">
						<?php 
							//PASANDO OCULTO EL NOMBRE DE LA GERENCIA EN CASO DE QUE SE PRETENDA INGRESAR POR EL MENU DE NAVEGACIÓN DE CADA USUARIO PORQUE SE VA  A DESABILITAR EL SELECT QUE VIENE A CONTINUACIÓN
							echo "<input type='hidden' name='departamento' value='$departamento'>";
						?>
						<span class="input-group-text w-100 rounded-0">Departamento:</span>
						<select class="form-control col rounded-0" name="departamento" id="departamento" required autocomplete="off" title="Indique el departamento a Mostrar" disabled>
							<option><?php echo $departamento; ?></option>
							<option class="text-danger">Todos</option>
							<?php
								$consulta_i="SELECT 
									`descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO
									FROM `inv_operacion` 
									INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
									INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									WHERE 1 
									AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
									$sql_gerencia 
									GROUP BY 
									`descripcion_de_cargos`.`DEPARTAMENTO` 
									ORDER BY 
									`descripcion_de_cargos`.`DEPARTAMENTO`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['DEPARTAMENTO'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-4 mb-2">
						<span class="input-group-text w-100 rounded-0">Empleado:</span>
						<select class="form-control col rounded-0" name="empleado" id="empleado" required autocomplete="off" title="Indique la Empleado a Mostrar">
							<option value="<?php echo $empleado; ?>">
								<?php 
									if($empleado=="Todos"){
										echo $empleado;
									}else{
									$consulta_i="SELECT `NOMBRE`, `APELLIDO` FROM `usuarios` WHERE `CORREO`='$empleado'";
									$resultados_i=mysqli_query($conexion,$consulta_i);
									$fila_i=mysqli_fetch_array($resultados_i);
									echo $fila_i['APELLIDO'] . ", " . $fila_i['NOMBRE']; 
									}
								?>
							</option>
							<option class="text-danger">Todos</option>
							<?php
								$consulta_i="SELECT 
									`usuarios`.`APELLIDO` AS APELLIDO,
									`usuarios`.`NOMBRE` AS NOMBRE,
									`usuarios`.`CORREO` AS CORREO
									FROM `inv_operacion` 
									INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
									INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									WHERE 1 
									AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
									$sql_gerencia 
									$sql_departamento 
									GROUP BY 
									`usuarios`.`APELLIDO`, 
									`usuarios`.`NOMBRE`, 
									`usuarios`.`CORREO` 
									ORDER BY 
									`usuarios`.`APELLIDO`, 
									`usuarios`.`NOMBRE`, 
									`usuarios`.`CORREO`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									echo "<option value='" . $fila_i['CORREO'] . "'>" . $fila_i['APELLIDO'] . ", " . $fila_i['NOMBRE'] . "</option>";
									$i=$i+1;
								}
							?>
						</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<!--CUADRNADO GRAFICAS AL CENTRO -->
				</div>
				<div class="col-md-4 mb-2">
					<span class="input-group-text w-100 rounded-0">Categoría:</span>
					<select class="form-control col rounded-0" name="categoria" id="categoria" required autocomplete="off" title="Indique la categoría a Mostrar">
						<option><?php echo $categoria; ?></option>
						<option class="text-danger">Todos</option>
						<?php
							//// QUEDE POR AQUI
							$consulta_i="SELECT 
							`inv_articulos`.`CATEGORIA` AS CATEGORIA
							FROM `inv_operacion` 
							INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
							INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
							INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO`
							WHERE 1 
							AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
							$sql_articulo 
							$sql_gerencia
							$sql_departamento
							$sql_empleado
							GROUP BY 
							`inv_articulos`.`CATEGORIA` 
							ORDER BY 
							`inv_articulos`.`CATEGORIA`";
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
				<div class="col-md-4 mb-2">
					<span class="input-group-text w-100 rounded-0">Artículo:</span>
					<select class="form-control col rounded-0" name="articulo" id="articulo" required autocomplete="off" title="Indique el artículo a Mostrar">
						<option><?php echo $articulo; ?></option>
						<option class="text-danger">Todos</option>
						<?php
							$consulta_i="SELECT 
								`inv_operacion`.`NOMBRE_ARTICULO` AS NOMBRE_ARTICULO
								FROM `inv_operacion` 
								INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
								INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
								WHERE 1 
								AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
								$sql_gerencia
								$sql_departamento
								$sql_empleado
								GROUP BY 
								`inv_operacion`.`NOMBRE_ARTICULO` 
								ORDER BY 
								`inv_operacion`.`NOMBRE_ARTICULO`";
							$resultados_i=mysqli_query($conexion,$consulta_i);
							$i=0;
							while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
								$datos_i=$fila_i['NOMBRE_ARTICULO'];
								echo "<option>$datos_i</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="col-md-2">
					<!--CUADRNADO GRAFICAS AL CENTRO -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="m-auto">
						<input type="submit" value="Generar" class="btn btn-danger">
					</div>
				</div>
			</div>
		</form>
		<!---------- GRAFICAS ---------->
		<h4 colspan="8" class="mt-1 mt-2 py-2 text-center">Resumen Cantidades por:</h4>
		<div class="row mx-0 my-1 p-1 align-items-center">
			<div class="col-md-4 mb-2">
				<canvas id="graf_gerencia_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_gerencia_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($inv_gcia[$i]['NOMBRE_GERENCIA'])){
									echo "'" . $inv_gcia[$i]['NOMBRE_GERENCIA'] . "'";
									if(isset($inv_gcia[$i+1]['NOMBRE_GERENCIA'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
							],
							datasets: [{
								data: [
								<?php
								$i=0;
								while(isset($inv_gcia[$i]['NOMBRE_GERENCIA'])){
									echo $inv_gcia[$i]['EN_EXISTENCIA'];
									if(isset($inv_gcia[$i+1]['NOMBRE_GERENCIA'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
								],
								backgroundColor: [
									<?php
										$color_i=0;
										while(isset($paleta_de_colores[$color_i])){
											echo "'" . $paleta_de_colores[$color_i] . "'";
											if(isset($paleta_de_colores[$color_i+1])){
												echo ", ";
											}
											$color_i=$color_i+1;
										}
									?>
								],
							}]
						},
						options: {
							legend: false,
							title: {
									display: true,
									text: 'Gerencias',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
			<div class="col-md-4 mb-2">
				<canvas id="graf_departamento_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_departamento_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($inv_dpto[$i]['NOMBRE_DEPARTAMENTO'])){
									echo "'" . $inv_dpto[$i]['NOMBRE_DEPARTAMENTO'] . "'";
									if(isset($inv_dpto[$i+1]['NOMBRE_DEPARTAMENTO'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
							],
							datasets: [{
								data: [
								<?php
								$i=0;
								while(isset($inv_dpto[$i]['NOMBRE_DEPARTAMENTO'])){
									echo $inv_dpto[$i]['EN_EXISTENCIA'];
									if(isset($inv_dpto[$i+1]['NOMBRE_DEPARTAMENTO'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
								],
								backgroundColor: [
									<?php
										$color_i=0;
										while(isset($paleta_de_colores[$color_i])){
											echo "'" . $paleta_de_colores[$color_i] . "'";
											if(isset($paleta_de_colores[$color_i+1])){
												echo ", ";
											}
											$color_i=$color_i+1;
										}
									?>
								],
							}]
						},
						options: {
							legend: false,
							title: {
									display: true,
									text: 'Departamentos',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
			<div class="col-md-4 mb-2">
				<canvas id="graf_empleado_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_empleado_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($inv_user[$i]['CORREO_EMPLEADO'])){
									echo "'" . $inv_user[$i]['APELIIDO_EMPLEADO'] . ", " . $inv_user[$i]['NOMBRE_EMPLEADO'] . "'";
									if(isset($inv_user[$i+1]['CORREO_EMPLEADO'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
							],
							datasets: [{
								data: [
								<?php
								$i=0;
								while(isset($inv_user[$i]['CORREO_EMPLEADO'])){
									echo $inv_user[$i]['EN_EXISTENCIA'];
									if(isset($inv_user[$i+1]['CORREO_EMPLEADO'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
								],
								backgroundColor: [
									<?php
										$color_i=0;
										while(isset($paleta_de_colores[$color_i])){
											echo "'" . $paleta_de_colores[$color_i] . "'";
											if(isset($paleta_de_colores[$color_i+1])){
												echo ", ";
											}
											$color_i=$color_i+1;
										}
									?>
								],
							}]
						},
						options: {
							legend: false,
							title: {
									display: true,
									text: 'Empleados',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
		</div>
		<div class="row mx-0 my-1 p-1 align-items-center">
			<div class="col-md-2">
				<!--CUADRNADO GRAFICAS AL CENTRO -->
			</div>
			<div class="col-md-4 mb-2">
				<canvas id="graf_categoria_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_categoria_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($inv_cat[$i]['CATEGORIA'])){
									echo "'" . $inv_cat[$i]['CATEGORIA'] . "'";
									if(isset($inv_cat[$i+1]['CATEGORIA'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
							],
							datasets: [{
								data: [
								<?php
								$i=0;
								while(isset($inv_cat[$i]['CATEGORIA'])){
									echo $inv_cat[$i]['EN_EXISTENCIA'];
									if(isset($inv_cat[$i+1]['CATEGORIA'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
								],
								backgroundColor: [
									<?php
										$color_i=0;
										while(isset($paleta_de_colores[$color_i])){
											echo "'" . $paleta_de_colores[$color_i] . "'";
											if(isset($paleta_de_colores[$color_i+1])){
												echo ", ";
											}
											$color_i=$color_i+1;
										}
									?>
								],
							}]
						},
						options: {
							legend: false,
							title: {
									display: true,
									text: 'Categorías',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
			<div class="col-md-4 mb-2">
				<canvas id="graf_articulo_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_articulo_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($inv_art[$i]['NOMBRE_ARTICULO'])){
									echo "'" . $inv_art[$i]['NOMBRE_ARTICULO'] . "'";
									if(isset($inv_art[$i+1]['NOMBRE_ARTICULO'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
							],
							datasets: [{
								data: [
								<?php
								$i=0;
								while(isset($inv_art[$i]['NOMBRE_ARTICULO'])){
									echo $inv_art[$i]['EN_EXISTENCIA'];
									if(isset($inv_art[$i+1]['NOMBRE_ARTICULO'])){
										echo ",";
									}
									$i=$i+1;
								}
								?>
								],
								backgroundColor: [
									<?php
										$color_i=0;
										while(isset($paleta_de_colores[$color_i])){
											echo "'" . $paleta_de_colores[$color_i] . "'";
											if(isset($paleta_de_colores[$color_i+1])){
												echo ", ";
											}
											$color_i=$color_i+1;
										}
									?>
								],
							}]
						},
						options: {
							legend: false,
							title: {
									display: true,
									text: 'Articulos',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
			<div class="col-md-2">
				<!--CUADRNADO GRAFICAS AL CENTRO -->
			</div>
		</div>
		<hr>
		<div>
			<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered mr-auto">
				<thead>
					<tr><td colspan="8" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Resumen de Inventario por Artículo:</td></tr>
					<tr class="text-center">
						<th class="align-middle border-dark bordered"><b title="Nombre de la Categoría del Artículo">Categoría</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre del Artículo">Nombre del Artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre de la Unidad del Artículo">Unidad</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad mínima que debe existir en el inventario">Inventario<br>mínimo</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad disponible en el inventario">Cantidad<br>disponible</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad disponible en el inventario">Cantidad<br>recibida</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad disponible en el inventario">Cantidad<br>entregada</b></th>
						<th class="align-middle border-dark bordered">Movimientos<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i=0;
						while(isset($inv_art[$i]['NOMBRE_ARTICULO'])){
							$consulta_i="SELECT * FROM `inv_articulos` WHERE `NOMBRE_ART`='" . $inv_art[$i]['NOMBRE_ARTICULO'] . "'";
							$resultados_i=mysqli_query($conexion,$consulta_i);
							$fila_i=mysqli_fetch_array( $resultados_i);
							echo "<tr>
								<td class='text-left border-dark bordered'>" . $fila_i['CATEGORIA'] . "</td>
								<td class='text-left border-dark bordered'>" . $inv_art[$i]['NOMBRE_ARTICULO'] . "</td>
								<td class='text-left border-dark bordered'>" . $fila_i['UNIDAD'] . "</td>
								<td class='text-center border-dark bordered'>" . $fila_i['INVENTARIO_MINIMO'] . "</td>
								<td class='text-center border-dark bordered'>" . $inv_art[$i]['EN_EXISTENCIA'] . "</td>
								<td class='text-center border-dark bordered'>" . $inv_art[$i]['CANTIDAD_RECIBIDA'] . "</td>
								<td class='text-center border-dark bordered'>" . $inv_art[$i]['CANTIDAD_ENTREGADA'] . "</td>
								";
								echo "<td class='text-center border-dark bordered'><a data-toggle='collapse' data-target='#Example$i' aria-controls='Example$i' aria-expanded='false' aria-label='Toggle navigation' class='text-danger fa fa-plus-square-o link_para_mostrar' href='#Example$i'> Detalle</a></td>";
								echo "</tr>";
							$i=$i+1;
						}
					?>
				</tbody>
			</table>
		</div>
		<br>
		<?php
			//IMPRIMIENDO LAS TABLAS DEL DETALLE REAL PARA CADA ARTICULO
			$i=0;
			while(isset($inv_art[$i]['NOMBRE_ARTICULO'])){
		?>
		<div class="collapse navbar-collapse my-3" id="Example<?php echo $i; ?>">
			<hr>
			<table class="table table-responsive table-hover table-bordered text-justify m-auto border-dark border tablaDinamica">
				<thead>
					<tr>
						<th colspan="6" class="text-center bg-dark text-light h3 border-dark bordered">Histórico de movimientos para el Artículo: <strong><?php echo $inv_art[$i]['NOMBRE_ARTICULO']; ?></strong></th>
					</tr>
					<tr>
						<th class="align-middle text-center border-dark bordered w-25">Fecha del movimiento</th>
						<th class="align-middle text-center border-dark bordered w-25">Cantidad Transferida</th>
						<th class="align-middle text-center border-dark bordered w-25">Correo del Responsable (quien envió)</th>
						<th class="align-middle text-center border-dark bordered w-25">Correo del Responsable (quien Recibió)</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$consulta_i="SELECT
					`inv_operacion`.`FECHA_RECIBIDO` AS FECHA_RECIBIDO, 
					`inv_operacion`.`CANTIDAD` AS CANTIDAD, 
					`inv_operacion`.`CORREO_DESDE` AS CORREO_DESDE, 
					`inv_operacion`.`CORREO_HACIA` AS CORREO_HACIA 
					FROM `inv_operacion` 
					INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
					INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
					INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO`
					WHERE 1 
					AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
					$sql_articulo 
					$sql_gerencia
					$sql_departamento
					$sql_empleado
					$sql_categoria
					GROUP BY `inv_operacion`.`ID` ORDER BY `inv_operacion`.`ID`";
					$resultados_i=mysqli_query($conexion,$consulta_i);
					$art_i=0;
					while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
						echo "<tr>";
						echo "<td class='text-center border-dark bordered'>" . $fila_i['FECHA_RECIBIDO'] . "</td>";
						echo "<td class='text-center border-dark bordered'>" . $fila_i['CANTIDAD'] . "</td>";
						echo "<td class='text-center border-dark bordered'>" . $fila_i['CORREO_DESDE'] . "</td>";
						echo "<td class='text-center border-dark bordered'>" . $fila_i['CORREO_HACIA'] . "</td>";
						echo "</tr>";
						$art_i=$art_i+1;
					}
				?>
				</tbody>
			</table>
		</div>
		<?php
				$i=$i+1;
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
	  $('.TablaDinamica').DataTable();
	});
</script>
<script>
	// LLAMANDO A LA FUNCIÓN PARA CAMBIAR EL COLOR Y EL SIMBOLO DE LOS DETALLES
	$(".link_para_mostrar").click(function(){
		if($(this).hasClass('text-danger fa fa-plus-square-o link_para_mostrar')){
			$(this).removeClass("text-danger fa fa-plus-square-o link_para_mostrar");
			$(this).addClass("text-success fa fa-minus-square-o link_para_mostrar");
		}else if($(this).hasClass('text-success fa fa-minus-square-o link_para_mostrar')){
			$(this).removeClass("text-success fa fa-minus-square-o link_para_mostrar");
			$(this).addClass("text-danger fa fa-plus-square-o link_para_mostrar");
		}
	});	
</script>
<?php
mysqli_close($conexion);
?>