<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	require("php_require/paleta_de_colores.php");
	//RESCATANDO DATOS DEL FORMULARIO
	if(isset($_POST["ano"])){
		$ano=$_POST["ano"];
		$sql_ano="AND YEAR(`reales_adicional`.`FECHA_ACTIVIDAD`)='" . $ano . "'";
	}else{
		$ano=date("Y");
		$sql_ano="AND YEAR(`reales_adicional`.`FECHA_ACTIVIDAD`)='" . $ano . "'";
	}
	if(isset($_GET["ano"])){
		$ano=$_GET["ano"];
		$sql_ano="AND YEAR(`reales_adicional`.`FECHA_ACTIVIDAD`)='" . $ano . "'";
	}

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

	if(isset($_POST["unidad"])){
		if($_POST["unidad"]=='Todas'){
			$unidad="Todas";
			$sql_unidad="";
		}else{
			$unidad=$_POST["unidad"];
			$sql_unidad="AND `reales_adicional`.`UNIDAD`='" . $unidad . "'";
		}
	}else{
		$unidad="Todas";
		$sql_unidad="";
	}
	if(isset($_GET["unidad"])){
		$unidad=$_GET["unidad"];
		$sql_unidad="AND `reales_adicional`.`UNIDAD`='" . $unidad . "'";
	}

	if(isset($_POST["cargo"])){
		if($_POST["cargo"]=='Todos'){
			$cargo="Todos";
			$sql_cargo="";
		}else{
			$cargo=$_POST["cargo"];
			$sql_cargo="AND `reales_adicional`.`CARGO`='" . $cargo . "'";
		}
	}else{
		$cargo="Todos";
		$sql_cargo="";
	}
	if(isset($_GET["cargo"])){
		$cargo=$_GET["cargo"];
		$sql_cargo="AND `reales_adicional`.`CARGO`='" . $cargo . "'";
	}

	if(isset($_POST["empleado"])){
		if($_POST["empleado"]=='Todos'){
			$empleado="Todos";
			$sql_empleado="";
		}else{
			$empleado=$_POST["empleado"];
			$sql_empleado="AND `reales_adicional`.`CORREO_RESPONSABLE`='" . $empleado . "'";
		}
	}else{
		$empleado="Todos";
		$sql_empleado="";
	}
	if(isset($_GET["empleado"])){
		$empleado=$_GET["empleado"];
		$sql_empleado="AND `reales_adicional`.`CORREO_RESPONSABLE`='" . $empleado . "'";
	}
	//OBTENEINDO DATOS PARA LA RDC ADICIONAL
	//INFORMACIÓN DETALLADA POR ACTIVIDAD ADICIONAL PARA LA TABLA DE DETALLE
	if($ano==date("Y")){
		if(date("m")=='01'){$sql_mes='1';}
		if(date("m")=='02'){$sql_mes='2';}
		if(date("m")=='03'){$sql_mes='3';}
		if(date("m")=='04'){$sql_mes='4';}
		if(date("m")=='05'){$sql_mes='5';}
		if(date("m")=='06'){$sql_mes='6';}
		if(date("m")=='07'){$sql_mes='7';}
		if(date("m")=='08'){$sql_mes='8';}
		if(date("m")=='09'){$sql_mes='9';}
		if(date("m")=='10'){$sql_mes='10';}
		if(date("m")=='11'){$sql_mes='11';}
		if(date("m")=='12'){$sql_mes='12';}
	}else{
		$sql_mes='12';
	}
	$consulta="SELECT 
	`reales_adicional`.`ID` AS ID,
	`reales_adicional`.`DESCRIPCION` AS DESCRIPCION,
	`reales_adicional`.`DETALLE_01` AS DETALLE_01,
	`reales_adicional`.`DETALLE_02` AS DETALLE_02,
	`reales_adicional`.`DETALLE_03` AS DETALLE_03,
	`reales_adicional`.`FECHA_ACTIVIDAD` AS FECHA_ACTIVIDAD,
	`usuarios`.`NOMBRE` AS NOMBRE,
	`usuarios`.`APELLIDO` AS APELLIDO,
	`reales_adicional`.`UNIDAD` AS UNIDAD,
	`reales_adicional`.`CANTIDAD` AS CANTIDAD
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado
	ORDER BY `reales_adicional`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$act_adc[$i]['DESCRIPCION']=$fila['DESCRIPCION'];
		$act_adc[$i]['APELLIDO_NOMBRE']=$fila['APELLIDO'] . ", " . $fila['NOMBRE'];
		$act_adc[$i]['UNIDAD']=$fila['UNIDAD'];
		$act_adc[$i]['CANTIDAD']=$fila['CANTIDAD'];
		$act_adc[$i]['FECHA_ACTIVIDAD']=$fila['FECHA_ACTIVIDAD'];
		$act_adc[$i]['DETALLES']=$fila['DETALLE_01'] . "<br>" . $fila['DETALLE_02'] . "<br>" . $fila['DETALLE_03'];
		$i=$i+1;
	}
	//INFORMACIÓN PARA LAS GRÁFICAS:
	//GRAFICAS RESUMEN ANUAL Y MENSUAL (1 Y 2):
	$consulta="SELECT 
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='1' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_1,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='2' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_2,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='3' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_3,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='4' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_4,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='5' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_5,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='6' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_6,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='7' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_7,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='8' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_8,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='9' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_9,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='10' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_10,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='11' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_11,
	SUM(case when MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)='12' then `reales_adicional`.`CANTIDAD` end) as REAL_ADIC_MES_12,
	SUM(`reales_adicional`.`CANTIDAD`) AS TOTAL_REAL_ADIC	
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado";
	$resultados=mysqli_query($conexion,$consulta);
	while(($fila=mysqli_fetch_array($resultados))==true){
		$mes=1;
		while($mes<=12){
			$act_adc_res['REAL_ADIC_MES_' . $mes]=$fila['REAL_ADIC_MES_' . $mes]==""?0:$fila['REAL_ADIC_MES_' . $mes];
			$mes=$mes+1;
		}
		$act_adc_res['TOTAL_REAL_ADIC']=$fila['TOTAL_REAL_ADIC'];
	}
	//GRAFICAS RESUMEN POR UNIDAD GRAFICA 3:
	$consulta="SELECT 
	`reales_adicional`.`UNIDAD` AS UNIDAD,
	SUM(`reales_adicional`.`CANTIDAD`) AS TOTAL_REAL_ADIC	
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado
	GROUP BY `reales_adicional`.`UNIDAD` ORDER BY `reales_adicional`.`UNIDAD`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf3_unidad[$i]=$fila['UNIDAD'];
		$graf3_real[$i]=$fila['TOTAL_REAL_ADIC'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR GERENCIA O TIPO_DEPARTAMENTO GRAFICA 4:
	$consulta="SELECT 
	`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS GERENCIA,
	SUM(`reales_adicional`.`CANTIDAD`) AS TOTAL_REAL_ADIC	
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado
	GROUP BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf4_gerencia[$i]=$fila['GERENCIA'];
		$graf4_real[$i]=$fila['TOTAL_REAL_ADIC'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR DEPARTAMENTO GRAFICA 5:
	$consulta="SELECT 
	`descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO,
	SUM(`reales_adicional`.`CANTIDAD`) AS TOTAL_REAL_ADIC	
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado
	GROUP BY `descripcion_de_cargos`.`DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf5_departamento[$i]=$fila['DEPARTAMENTO'];
		$graf5_real[$i]=$fila['TOTAL_REAL_ADIC'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR CARGO GRAFICA 6:
	$consulta="SELECT 
	`reales_adicional`.`CARGO` AS CARGO,
	SUM(`reales_adicional`.`CANTIDAD`) AS TOTAL_REAL_ADIC	
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado
	GROUP BY `reales_adicional`.`CARGO` ORDER BY `reales_adicional`.`CARGO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf6_cargo[$i]=$fila['CARGO'];
		$graf6_real[$i]=$fila['TOTAL_REAL_ADIC'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR EMPLEADO GRAFICA 7:
	$consulta="SELECT 
	`reales_adicional`.`CORREO_RESPONSABLE` AS CORREO,
	`usuarios`.`NOMBRE` AS NOMBRE,
	`usuarios`.`APELLIDO` AS APELLIDO,
	SUM(`reales_adicional`.`CANTIDAD`) AS TOTAL_REAL_ADIC	
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON 
	`reales_adicional`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`reales_adicional`.`CORREO_RESPONSABLE`=`usuarios`.`CORREO`
	WHERE 1 
	AND `reales_adicional`.`APROBADO`='SI' 
	AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_cargo
	$sql_empleado
	GROUP BY `reales_adicional`.`CORREO_RESPONSABLE`, `usuarios`.`NOMBRE`, `usuarios`.`APELLIDO` ORDER BY `reales_adicional`.`CORREO_RESPONSABLE`, `usuarios`.`NOMBRE`, `usuarios`.`APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf7_nombre[$i]=$fila['APELLIDO'] . ", " . $fila['NOMBRE'];
		$graf7_real[$i]=$fila['TOTAL_REAL_ADIC'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: RDC-Adc</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<!---------- FILTROS ---------->
		<form action="rdc_adicional_general.php" method="post" class="text-center bg-dark p-2 my-1 rounded">
			<h4 class="mb-2 text-center rounded text-light"><span class="text-danger fa fa-cog fa-spin"></span> RESUMEN - ACTIVIDADES ADICIONALES:</h4>
			<div class="row">
				<div class="col-md-4 mb-2">
					<span class="input-group-text w-100 rounded-0">Año:</span>
					<select class="form-control col rounded-0" name="ano" id="ano" required autocomplete="off" title="Indique el Año a Mostrar">
						<option><?php echo $ano; ?></option>
						<?php
							$consulta_i="SELECT YEAR(`reales_adicional`.`FECHA_ACTIVIDAD`) AS ANO 	
								FROM `reales_adicional` 
								GROUP BY YEAR(`reales_adicional`.`FECHA_ACTIVIDAD`) ORDER BY YEAR(`reales_adicional`.`FECHA_ACTIVIDAD`)";
							$resultados_i=mysqli_query($conexion,$consulta_i);
							$i=0;
							while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
								$datos_i=$fila_i['ANO'];
								echo "<option>$datos_i</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
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
							`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS GERENCIA 
							FROM `reales_adicional` 
							INNER JOIN `descripcion_de_cargos` ON 
							`reales_adicional`.`CARGO`= `descripcion_de_cargos`.`CARGO` 
							INNER JOIN `usuarios` ON 
							`reales_adicional`.`CORREO_RESPONSABLE`= `usuarios`.`CORREO`
							WHERE 1 
							AND `reales_adicional`.`APROBADO`='SI' 
							AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
							$sql_ano
							GROUP BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO`";
							$resultados_i=mysqli_query($conexion,$consulta_i);
							$i=0;
							while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
								$datos_i=$fila_i['GERENCIA'];
								echo "<option>$datos_i</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="col-md-4 mb-2">
					<?php 
						//PASANDO OCULTO EL NOMBRE DE LA GERENCIA EN CASO DE QUE SE PRETENDA INGRESAR POR EL MENU DE NAVEGACIÓN DE CADA USUARIO PORQUE SE VA  A DESABILITAR EL SELECT QUE VIENE A CONTINUACIÓN
						echo "<input type='hidden' name='departamento' value='$departamento'>";
					?>
					<div class="input-group">
						<span class="input-group-text w-100 rounded-0">Departamento:</span>
						<select class="form-control col rounded-0" name="departamento" id="departamento" required autocomplete="off" title="Indique el departamento a Mostrar" disabled>
							<option><?php echo $departamento; ?></option>
							<option class="text-danger">Todos</option>
							<?php
								$consulta_i="SELECT 
								`descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO
								FROM `reales_adicional` 
								INNER JOIN `descripcion_de_cargos` ON 
								`reales_adicional`.`CARGO`= `descripcion_de_cargos`.`CARGO` 
								INNER JOIN `usuarios` ON 
								`reales_adicional`.`CORREO_RESPONSABLE`= `usuarios`.`CORREO`
								WHERE 1 
								AND `reales_adicional`.`APROBADO`='SI' 
								AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
								$sql_ano
								$sql_gerencia
								GROUP BY `descripcion_de_cargos`.`DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`DEPARTAMENTO`";
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
			</div>
			<div class="row">
				<div class="col-md-4 mb-2">
					<span class="input-group-text w-100 rounded-0">Unidad de Medida:</span>
					<select class="form-control col rounded-0" name="unidad" id="unidad" required autocomplete="off" title="Indique la Unidad de Medida a Mostrar">
						<option><?php echo $unidad; ?></option>
						<option class="text-danger">Todas</option>
						<?php
							$consulta_i="SELECT 
							`reales_adicional`.`UNIDAD` AS UNIDAD 
							FROM `reales_adicional` 
							INNER JOIN `descripcion_de_cargos` ON 
							`reales_adicional`.`CARGO`= `descripcion_de_cargos`.`CARGO` 
							INNER JOIN `usuarios` ON 
							`reales_adicional`.`CORREO_RESPONSABLE`= `usuarios`.`CORREO`
							WHERE 1 
							AND `reales_adicional`.`APROBADO`='SI' 
							AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
							$sql_ano
							$sql_gerencia
							$sql_departamento
							GROUP BY `reales_adicional`.`UNIDAD` ORDER BY `reales_adicional`.`UNIDAD`";
							$resultados_i=mysqli_query($conexion,$consulta_i);
							$i=0;
							while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
								$datos_i=$fila_i['UNIDAD'];
								echo "<option>$datos_i</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="col-md-4 mb-2">
					<div class="input-group">
						<span class="input-group-text w-100 rounded-0">Cargo:</span>
						<select class="form-control col rounded-0" name="cargo" id="cargo" required autocomplete="off" title="Indique el Cargo a Mostrar">
							<option><?php echo $cargo; ?></option>
							<option class="text-danger">Todos</option>
							<?php
								$consulta_i="SELECT 
								`reales_adicional`.`CARGO` AS CARGO 	
								FROM `reales_adicional` 
								INNER JOIN `descripcion_de_cargos` ON 
								`reales_adicional`.`CARGO`= `descripcion_de_cargos`.`CARGO` 
								INNER JOIN `usuarios` ON 
								`reales_adicional`.`CORREO_RESPONSABLE`= `usuarios`.`CORREO`
								WHERE 1 
								AND `reales_adicional`.`APROBADO`='SI' 
								AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
								$sql_ano
								$sql_gerencia
								$sql_departamento
								$sql_unidad
								GROUP BY `reales_adicional`.`CARGO` ORDER BY `reales_adicional`.`CARGO`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['CARGO'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-4 mb-2">
					<span class="input-group-text w-100 rounded-0">Empleado:</span>
					<select class="form-control col rounded-0" name="empleado" id="empleado" required autocomplete="off" title="Indique la Unidad de Medida a Mostrar">
						<option value="<?php echo $empleado; ?>">
							<?php 
								if($empleado=="Todos"){
									echo $empleado;
								}else{
								$consulta_i="SELECT `NOMBRE`, `APELLIDO` FROM `usuarios` WHERE `CORREO`='$empleado'";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$fila_i=mysqli_fetch_array($resultados_i);
								echo $fila_i['APELLIDO'] . " , " . $fila_i['NOMBRE']; 
								}
							?>
						</option>
						<option class="text-danger">Todos</option>
						<?php
							$consulta_i="SELECT 
							`reales_adicional`.`CORREO_RESPONSABLE` AS CORREO,
							`usuarios`.`NOMBRE` AS NOMBRE,
							`usuarios`.`APELLIDO` AS APELLIDO 
							FROM `reales_adicional` 
							INNER JOIN `descripcion_de_cargos` ON 
							`reales_adicional`.`CARGO`= `descripcion_de_cargos`.`CARGO` 
							INNER JOIN `usuarios` ON 
							`reales_adicional`.`CORREO_RESPONSABLE`= `usuarios`.`CORREO`
							WHERE 1 
							AND `reales_adicional`.`APROBADO`='SI' 
							AND MONTH(`reales_adicional`.`FECHA_ACTIVIDAD`)<='$sql_mes'
							$sql_ano
							$sql_gerencia
							$sql_departamento
							$sql_unidad
							$sql_cargo
							GROUP BY `reales_adicional`.`CORREO_RESPONSABLE`, `usuarios`.`NOMBRE`, `usuarios`.`APELLIDO` ORDER BY `reales_adicional`.`CORREO_RESPONSABLE`, `usuarios`.`NOMBRE`, `usuarios`.`APELLIDO`";
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
				<div class="col-12">
					<div class="m-auto">
						<input type="submit" value="Generar" class="btn btn-danger">
					</div>
				</div>
			</div>
		</form>
		<!---------- GRAFICAS ---------->
		<div class="row mx-0 p-1 align-items-center">
			<div class="col-md-3 mb-2">
				<canvas id="graf_anual_1" height="294%" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var chart = new Chart($("#graf_anual_1"), {
						type: 'bar',
						data: {
							labels: ["Anual"],
							datasets: [
								{
									type: 'bar',
									label: "Adicional",
									yAxisID: 'y-axis-1',
									backgroundColor: 'rgba(0, 0, 255, 0.8)',
									data: [<?php echo $act_adc_res['TOTAL_REAL_ADIC']; ?>]
								}
							]
						},
						options: {
							responsive: true,
							hoverMode: 'index',
							stacked: false,
							title: {
									display: true,
									text: 'Resumen Ene-<?php echo date("M"); ?>',
									fontSize: 20,
									fontColor: '#555'
								},
							scales: {
								yAxes: [
									{
										type: 'linear',
										display: true,
										position: 'left',
										id: 'y-axis-1',
										ticks: {
											beginAtZero:true
										},
										scaleLabel: {
										display: true,
										labelString: "Cantidad",
										fontColor: '#555'
									   },
										gridLines: {
											drawOnChartArea: false,
									   }
									}
								],
							}
						}
					});
				</script>
			</div>
			<div class="col-md-9 mb-2">
				<canvas id="graf_mensual_1" height="90%" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var chart = new Chart($("#graf_mensual_1"), {
						type: 'bar',
						data: {
							labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
							datasets: [
								{
									type: 'bar',
									label: "Real - Adicional",
									yAxisID: 'y-axis-1',
									backgroundColor: 'rgba(0, 0, 255, 0.8)',
									data: [
										<?php
										$mes=1;
										while(isset($act_adc_res['REAL_ADIC_MES_' . $mes])){
											echo $act_adc_res['REAL_ADIC_MES_' . $mes];
											$a=$mes+1;
											if(isset($act_adc_res['REAL_ADIC_MES_' . $mes])){
												echo ",";
											}
											$mes=$mes+1;
										}
										?>
									]
								}
							]
						},
						options: {
							responsive: true,
							hoverMode: 'index',
							stacked: false,
							title: {
									display: true,
									text: 'Detalle por Mes',
									fontSize: 20,
									fontColor: '#555'
								},
							scales: {
								yAxes: [
									{
										type: 'linear',
										display: true,
										position: 'left',
										id: 'y-axis-1',
										ticks: {
											beginAtZero:true
										},
										scaleLabel: {
										display: true,
										labelString: "Cantidad",
										fontColor: '#555'
									   },
										gridLines: {
											drawOnChartArea: false,
									   }
									}
								],
							}
						}
					});
				</script>
			</div>
		</div>
		<div class="row mx-0 my-1 p-1 align-items-center">
			<div class="col-md-4 mb-2">
				<canvas id="graf_unidad_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_unidad_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($graf3_unidad[$i])){
									echo "'" . $graf3_unidad[$i] . "'";
									if(isset($graf3_unidad[$i+1])){
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
								while(isset($graf3_unidad[$i])){
									echo $graf3_real[$i];
									if(isset($graf3_unidad[$i+1])){
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
									text: 'Unidades',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
			<div class="col-md-4 mb-2">
				<canvas id="graf_gerencia_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_gerencia_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($graf4_gerencia[$i])){
									echo "'" . $graf4_gerencia[$i] . "'";
									if(isset($graf4_gerencia[$i+1])){
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
								while(isset($graf4_gerencia[$i])){
									echo $graf4_real[$i];
									if(isset($graf4_gerencia[$i+1])){
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
								while(isset($graf5_departamento[$i])){
									echo "'" . $graf5_departamento[$i] . "'";
									if(isset($graf5_departamento[$i+1])){
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
								while(isset($graf5_departamento[$i])){
									echo $graf5_real[$i];
									if(isset($graf5_departamento[$i+1])){
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
		</div>
		<div class="row mx-0 my-1 p-1 align-items-center">
			<div class="col-md-2 mb-2">
				<!-- ESPACIANDO LAS GRÁFICAS -->
			</div>
			<div class="col-md-4 mb-2">
				<canvas id="graf_cargo_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_cargo_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($graf6_cargo[$i])){
									echo "'" . $graf6_cargo[$i] . "'";
									if(isset($graf6_cargo[$i+1])){
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
								while(isset($graf6_cargo[$i])){
									echo $graf6_real[$i];
									if(isset($graf6_cargo[$i+1])){
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
									text: 'Cargos',
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
								while(isset($graf7_nombre[$i])){
									echo "'" . $graf7_nombre[$i] . "'";
									if(isset($graf7_nombre[$i+1])){
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
								while(isset($graf7_nombre[$i])){
									echo $graf7_real[$i];
									if(isset($graf7_nombre[$i+1])){
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
			<div class="col-md-2 mb-2">
				<!-- ESPACIANDO LAS GRÁFICAS -->
			</div>
		</div>
		<hr>
		<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered">
			<thead>
				<tr>
					<td colspan="8" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Detalle por Actividad Adicional:</td>
				</tr>
				<tr class="text-center">
					<th class="text-center border-dark bordered">Fecha</th>
					<th class="text-center border-dark bordered w-25">Descripción</th>
					<th class="text-center border-dark bordered">Unidad</th>
					<th class="text-center border-dark bordered">Cantidad</th>
					<th class="text-center border-dark bordered w-50">Detalles</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=0;
					while(isset($act_adc[$i]['FECHA_ACTIVIDAD'])){
						echo "<tr>
							<td class='text-center border-dark bordered'>" . $act_adc[$i]['FECHA_ACTIVIDAD'] . "</td>
							<td class='text-left border-dark bordered'>" . $act_adc[$i]['DESCRIPCION'] . "</td>
							<td class='text-left border-dark bordered'>" . $act_adc[$i]['UNIDAD'] . "</td>
							<td class='text-center border-dark bordered'>" . $act_adc[$i]['CANTIDAD'] . "</td>
							<td class='text-left border-dark bordered'>" . $act_adc[$i]['DETALLES'] . "</td>";
							echo "</tr>";
						$i=$i+1;
					}
				?>
			</tbody>
		</table>
		<br>
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
<?php
mysqli_close($conexion);
?>