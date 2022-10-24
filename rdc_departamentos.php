<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	require("php_require/paleta_de_colores.php");
	//RESCATANDO DATOS DEL FORMULARIO
	if(isset($_POST["ano"])){
		$ano=$_POST["ano"];
		$sql_ano="AND `planes`.`ANO`='" . $ano . "'";
	}else{
		$ano=date("Y");
		$sql_ano="AND `planes`.`ANO`='" . $ano . "'";
	}
	if(isset($_GET["ano"])){
		$ano=$_GET["ano"];
		$sql_ano="AND `planes`.`ANO`='" . $ano . "'";
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
			$sql_unidad="AND `planes`.`UNIDAD`='" . $unidad . "'";
		}
	}else{
		$unidad="Todas";
		$sql_unidad="";
	}
	if(isset($_GET["unidad"])){
		$unidad=$_GET["unidad"];
		$sql_unidad="AND `planes`.`UNIDAD`='" . $unidad . "'";
	}

	if(isset($_POST["cargo"])){
		if($_POST["cargo"]=='Todos'){
			$cargo="Todos";
			$sql_cargo="";
		}else{
			$cargo=$_POST["cargo"];
			$sql_cargo="AND `planes`.`CARGO`='" . $cargo . "'";
		}
	}else{
		$cargo="Todos";
		$sql_cargo="";
	}
	if(isset($_GET["cargo"])){
		$cargo=$_GET["cargo"];
		$sql_cargo="AND `planes`.`CARGO`='" . $cargo . "'";
	}

	if(isset($_POST["meta"])){
		if($_POST["meta"]=='Todas'){
			$meta="Todas";
			$sql_meta="";
		}else{
			$meta=$_POST["meta"];
			$sql_meta="AND `planes`.`DESCRIPCION`='" . $meta . "'";
		}
	}else{
		$meta="Todas";
		$sql_meta="";
	}
	if(isset($_GET["meta"])){
		$meta=$_GET["meta"];
		$sql_meta="AND `planes`.`DESCRIPCION`='" . $meta . "'";
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
	//OBTENEINDO DATOS PARA LA RDC
	//INFORMACIÓN DETALLADA POR META PARA LAS TABLAS Y PARA LA GRAFICA POR METAS (8)
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
	`planes`.`DESCRIPCION` AS META,
	`planes`.`ID` AS ID_PLAN,
	`planes`.`CARGO` AS CARGO,
	`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS TIPO_DEPARTAMENTO,
	`descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO,
	`usuarios`.`CORREO` AS CORREO,
	`usuarios`.`NOMBRE` AS NOMBRE,
	`usuarios`.`APELLIDO` AS APELLIDO,
	`planes`.`UNIDAD` AS UNIDAD,
	SUM(`planes`.`1`) AS PLAN_MES_1, 
	SUM(`planes`.`2`) AS PLAN_MES_2, 
	SUM(`planes`.`3`) AS PLAN_MES_3, 
	SUM(`planes`.`4`) AS PLAN_MES_4, 
	SUM(`planes`.`5`) AS PLAN_MES_5, 
	SUM(`planes`.`6`) AS PLAN_MES_6, 
	SUM(`planes`.`7`) AS PLAN_MES_7, 
	SUM(`planes`.`8`) AS PLAN_MES_8, 
	SUM(`planes`.`9`) AS PLAN_MES_9, 
	SUM(`planes`.`10`) AS PLAN_MES_10, 
	SUM(`planes`.`11`) AS PLAN_MES_11, 
	SUM(`planes`.`12`) AS PLAN_MES_12,
	`planes`.`EXPLICACION` AS EXPLICACION, 
	SUM(case when `reales`.`MES_REAL`='1' then `reales`.`CANTIDAD` end) as REAL_MES_1,
	SUM(case when `reales`.`MES_REAL`='2' then `reales`.`CANTIDAD` end) as REAL_MES_2,
	SUM(case when `reales`.`MES_REAL`='3' then `reales`.`CANTIDAD` end) as REAL_MES_3,
	SUM(case when `reales`.`MES_REAL`='4' then `reales`.`CANTIDAD` end) as REAL_MES_4,
	SUM(case when `reales`.`MES_REAL`='5' then `reales`.`CANTIDAD` end) as REAL_MES_5,
	SUM(case when `reales`.`MES_REAL`='6' then `reales`.`CANTIDAD` end) as REAL_MES_6,
	SUM(case when `reales`.`MES_REAL`='7' then `reales`.`CANTIDAD` end) as REAL_MES_7,
	SUM(case when `reales`.`MES_REAL`='8' then `reales`.`CANTIDAD` end) as REAL_MES_8,
	SUM(case when `reales`.`MES_REAL`='9' then `reales`.`CANTIDAD` end) as REAL_MES_9,
	SUM(case when `reales`.`MES_REAL`='10' then `reales`.`CANTIDAD` end) as REAL_MES_10,
	SUM(case when `reales`.`MES_REAL`='11' then `reales`.`CANTIDAD` end) as REAL_MES_11,
	SUM(case when `reales`.`MES_REAL`='12' then `reales`.`CANTIDAD` end) as REAL_MES_12,
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL	
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado
	GROUP BY `planes`.`DESCRIPCION` ORDER BY `planes`.`DESCRIPCION`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$meta_id[$i]=$fila['ID_PLAN'];
		$meta_nombre[$i]=$fila['META'];
		$meta_gerencia[$i]=$fila['TIPO_DEPARTAMENTO'];
		$meta_departamento[$i]=$fila['DEPARTAMENTO'];
		$meta_usuario_correo[$i]=$fila['CORREO'];
		$meta_usuario_nombre[$i]=$fila['NOMBRE'];
		$meta_usuario_apellido[$i]=$fila['APELLIDO'];
		$meta_unidad[$i]=$fila['UNIDAD'];
		$meta_explicacion[$i]=$fila['EXPLICACION'];
		$meta_real_total[$i]=$fila['TOTAL_REAL'];
		$e=0;
		while($e<12){
			$o=$e+1;
			if($fila['REAL_MES_' . $o]==null){
				$meta_real_mes[$i][$e]=0;
			}else{
				$meta_real_mes[$i][$e]=$fila['REAL_MES_' . $o];//[META][MES-1]
			}
			if($fila['PLAN_MES_' . $o]==null){
				$meta_plan_mes[$i][$e]=0;
			}else{
				$meta_plan_mes[$i][$e]=$fila['PLAN_MES_' . $o];//[META][MES-1]
			}
			$e=$e+1;
		}
		$meta_plan_total_actual[$i]=0;
		$e=0;
		while($e<12){
			$meta_plan_total_actual[$i]=$meta_plan_total_actual[$i]+$meta_plan_mes[$i][$e];
			$e=$e+1;
		}
		$meta_variacion[$i]=$meta_real_total[$i]-$meta_plan_total_actual[$i];
		$i=$i+1;
	}
	//INFORMACIÓN PARA LAS GRÁFICAS:
	//GRAFICAS RESUMEN ANUAL Y MENSUAL (1 Y 2):
	$consulta="SELECT 
	SUM(`planes`.`1`) AS PLAN_MES_1, 
	SUM(`planes`.`2`) AS PLAN_MES_2, 
	SUM(`planes`.`3`) AS PLAN_MES_3, 
	SUM(`planes`.`4`) AS PLAN_MES_4, 
	SUM(`planes`.`5`) AS PLAN_MES_5, 
	SUM(`planes`.`6`) AS PLAN_MES_6, 
	SUM(`planes`.`7`) AS PLAN_MES_7, 
	SUM(`planes`.`8`) AS PLAN_MES_8, 
	SUM(`planes`.`9`) AS PLAN_MES_9, 
	SUM(`planes`.`10`) AS PLAN_MES_10, 
	SUM(`planes`.`11`) AS PLAN_MES_11, 
	SUM(`planes`.`12`) AS PLAN_MES_12,
	SUM(case when `reales`.`MES_REAL`='1' then `reales`.`CANTIDAD` end) as REAL_MES_1,
	SUM(case when `reales`.`MES_REAL`='2' then `reales`.`CANTIDAD` end) as REAL_MES_2,
	SUM(case when `reales`.`MES_REAL`='3' then `reales`.`CANTIDAD` end) as REAL_MES_3,
	SUM(case when `reales`.`MES_REAL`='4' then `reales`.`CANTIDAD` end) as REAL_MES_4,
	SUM(case when `reales`.`MES_REAL`='5' then `reales`.`CANTIDAD` end) as REAL_MES_5,
	SUM(case when `reales`.`MES_REAL`='6' then `reales`.`CANTIDAD` end) as REAL_MES_6,
	SUM(case when `reales`.`MES_REAL`='7' then `reales`.`CANTIDAD` end) as REAL_MES_7,
	SUM(case when `reales`.`MES_REAL`='8' then `reales`.`CANTIDAD` end) as REAL_MES_8,
	SUM(case when `reales`.`MES_REAL`='9' then `reales`.`CANTIDAD` end) as REAL_MES_9,
	SUM(case when `reales`.`MES_REAL`='10' then `reales`.`CANTIDAD` end) as REAL_MES_10,
	SUM(case when `reales`.`MES_REAL`='11' then `reales`.`CANTIDAD` end) as REAL_MES_11,
	SUM(case when `reales`.`MES_REAL`='12' then `reales`.`CANTIDAD` end) as REAL_MES_12 
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado";
	$resultados=mysqli_query($conexion,$consulta);
	$total_plan=0;
	$total_real=0;
	$fila=mysqli_fetch_array($resultados);
	$i=0;
	while($i<12){
		$e=$i+1;
		$total_plan_mes[$i]=$fila['PLAN_MES_' . $e]<>null?$fila['PLAN_MES_' . $e]:0;
		$total_real_mes[$i]=$fila['REAL_MES_' . $e]<>null?$fila['REAL_MES_' . $e]:0;
		if($total_plan_mes[$i]==0){
			$porc_cumplimiento_mes[$i]=0;
		}else{
			if($total_plan_mes[$i]<=$total_real_mes[$i]){
				$porc_cumplimiento_mes[$i]=100;
			}else{
				$porc_cumplimiento_mes[$i]= round($total_real_mes[$i] * 100 / $total_plan_mes[$i] , 0);
			}
		}
		$total_plan=$total_plan+$total_plan_mes[$i];
		$total_real=$total_real+$total_real_mes[$i];
		$i=$i+1;
	}
	if($total_plan==0){
		$porc_cumplimiento=0;
	}else{
		if($total_plan<=$total_real){
			$porc_cumplimiento=100;
		}else{
			$porc_cumplimiento=round($total_real*100/$total_plan,0);
		}
	}
	//GRAFICAS RESUMEN POR UNIDAD GRAFICA 3:
	$consulta="SELECT 
	`planes`.`UNIDAD` AS UNIDAD,
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL	
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado
	GROUP BY `planes`.`UNIDAD` ORDER BY `planes`.`UNIDAD`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf3_unidad[$i]=$fila['UNIDAD'];
		$graf3_real[$i]=$fila['TOTAL_REAL'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR GERENCIA O TIPO_DEPARTAMENTO GRAFICA 4:
	$consulta="SELECT 
	`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS TIPO_DEPARTAMENTO,
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL	
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado
	GROUP BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf4_tipo_departamento[$i]=$fila['TIPO_DEPARTAMENTO'];
		$graf4_real[$i]=$fila['TOTAL_REAL'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR DEPARTAMENTO GRAFICA 5:
	$consulta="SELECT 
	`descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO,
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL	
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado
	GROUP BY `descripcion_de_cargos`.`DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf5_departamento[$i]=$fila['DEPARTAMENTO'];
		$graf5_real[$i]=$fila['TOTAL_REAL'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR CARGO GRAFICA 6:
	$consulta="SELECT 
	`descripcion_de_cargos`.`CARGO` AS CARGO,
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL	
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado
	GROUP BY `descripcion_de_cargos`.`CARGO` ORDER BY `descripcion_de_cargos`.`CARGO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf6_cargo[$i]=$fila['CARGO'];
		$graf6_real[$i]=$fila['TOTAL_REAL'];
		$i=$i+1;
	}
	//GRAFICAS RESUMEN POR EMPLEADO GRAFICA 7:
	$consulta="SELECT 
	`usuarios`.`CORREO` AS CORREO,
	`usuarios`.`APELLIDO` AS APELLIDO,
	`usuarios`.`NOMBRE` AS NOMBRE,
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL	
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON 
	`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	INNER JOIN `usuarios` ON 
	`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
	INNER JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `reales`.`MES_REAL`<='$sql_mes'
	$sql_ano
	$sql_gerencia
	$sql_departamento
	$sql_unidad
	$sql_meta
	$sql_cargo
	$sql_empleado
	GROUP BY `usuarios`.`APELLIDO`, `usuarios`.`NOMBRE`, `usuarios`.`CORREO` ORDER BY `usuarios`.`APELLIDO`, `usuarios`.`NOMBRE`, `usuarios`.`CORREO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$graf7_nombre[$i]=$fila['APELLIDO'] . ", " . $fila['NOMBRE'];
		$graf7_real[$i]=$fila['TOTAL_REAL'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: RDC</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<!---------- FILTROS ---------->
		<form action="rdc_departamentos.php" method="post" class="text-center bg-dark p-2 my-1 rounded">
			<h4 class="mb-2 text-center rounded text-light"><span class="text-danger fa fa-cog fa-spin"></span> RESUMEN - PLAN VS. REAL:</h4>
			<div class="row">
				<div class="col-md-3 mb-2">
						<span class="input-group-text w-100 rounded-0">Año:</span>
						<select class="form-control col rounded-0" name="ano" id="ano" required autocomplete="off" title="Indique el Año a Mostrar">
							<option><?php echo $ano; ?></option>
							<?php
								$consulta_i="SELECT `planes`.`ANO` AS ANO 	
									FROM `planes` 
									GROUP BY `planes`.`ANO` ORDER BY `planes`.`ANO`";
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
				<div class="col-md-3 mb-2">
					<?php 
						//PASANDO OCULTO EL NOMBRE DE LA GERENCIA EN CASO DE QUE SE PRETENDA INGRESAR POR EL MENU DE NAVEGACIÓN DE CADA USUARIO PORQUE SE VA  A DESABILITAR EL SELECT QUE VIENE A CONTINUACIÓN
						echo "<input type='hidden' name='gerencia' value='$gerencia'>";
					?>
					<span class="input-group-text w-100 rounded-0">Gerencia:</span>
					<select class="form-control col rounded-0" name="gerencia" id="gerencia" required autocomplete="off" title="Indique la Gerencia a Mostrar"disabled>
						<option><?php echo $gerencia; ?></option>
						<option class="text-danger">Todas</option>
						<?php
							$consulta_i="SELECT `descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS TIPO_DEPARTAMENTO 
								FROM `planes` 
								INNER JOIN `descripcion_de_cargos` ON 
								`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
								INNER JOIN `usuarios` ON 
								`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
								INNER JOIN `reales` ON 
								`planes`.`ID`=`reales`.`ID_PLAN` 
								WHERE 1 
								AND `planes`.`APROBADO`='SI' 
								AND `reales`.`APROBADO`='SI' 
								AND `reales`.`MES_REAL`<='$sql_mes'
								$sql_ano
								GROUP BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO` ORDER BY `descripcion_de_cargos`.`TIPO_DEPARTAMENTO`";
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
				<div class="col-md-3 mb-2">
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
								$consulta_i="SELECT `descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO
									FROM `planes` 
									INNER JOIN `descripcion_de_cargos` ON 
									`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
									INNER JOIN `usuarios` ON 
									`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									INNER JOIN `reales` ON 
									`planes`.`ID`=`reales`.`ID_PLAN` 
									WHERE 1 
									AND `planes`.`APROBADO`='SI' 
									AND `reales`.`APROBADO`='SI' 
									AND `reales`.`MES_REAL`<='$sql_mes'
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
				<div class="col-md-3 mb-2">
						<span class="input-group-text w-100 rounded-0">Unidad de Medida:</span>
						<select class="form-control col rounded-0" name="unidad" id="unidad" required autocomplete="off" title="Indique la Unidad de Medida a Mostrar">
							<option><?php echo $unidad; ?></option>
							<option class="text-danger">Todas</option>
							<?php
								$consulta_i="SELECT `planes`.`UNIDAD` AS UNIDAD 
									FROM `planes` 
									INNER JOIN `descripcion_de_cargos` ON 
									`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
									INNER JOIN `usuarios` ON 
									`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									INNER JOIN `reales` ON 
									`planes`.`ID`=`reales`.`ID_PLAN` 
									WHERE 1 
									AND `planes`.`APROBADO`='SI' 
									AND `reales`.`APROBADO`='SI' 
									AND `reales`.`MES_REAL`<='$sql_mes'
									$sql_ano
									$sql_gerencia
									$sql_departamento
									GROUP BY `planes`.`UNIDAD` ORDER BY `planes`.`UNIDAD`";
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
			</div>
			<div class="row">
				<div class="col-md-4 mb-2">
					<div class="input-group">
						<span class="input-group-text w-100 rounded-0">Cargo:</span>
						<select class="form-control col rounded-0" name="cargo" id="cargo" required autocomplete="off" title="Indique el Cargo a Mostrar">
							<option><?php echo $cargo; ?></option>
							<option class="text-danger">Todos</option>
							<?php
								$consulta_i="SELECT `descripcion_de_cargos`.`CARGO` AS CARGO  
									FROM `planes` 
									INNER JOIN `descripcion_de_cargos` ON 
									`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
									INNER JOIN `usuarios` ON 
									`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									INNER JOIN `reales` ON 
									`planes`.`ID`=`reales`.`ID_PLAN` 
									WHERE 1 
									AND `planes`.`APROBADO`='SI' 
									AND `reales`.`APROBADO`='SI' 
									AND `reales`.`MES_REAL`<='$sql_mes'
									$sql_ano
									$sql_gerencia
									$sql_departamento
									$sql_unidad
									GROUP BY `descripcion_de_cargos`.`CARGO` ORDER BY `descripcion_de_cargos`.`CARGO`";
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
						<span class="input-group-text w-100 rounded-0">Meta:</span>
						<select class="form-control col rounded-0" name="meta" id="meta" required autocomplete="off" title="Indique el nombre de la Meta a Mostrar">
							<option><?php echo $meta; ?></option>
							<option class="text-danger">Todas</option>
							<?php
								$consulta_i="SELECT `planes`.`DESCRIPCION` AS DESCRIPCION 
									FROM `planes` 
									INNER JOIN `descripcion_de_cargos` ON 
									`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
									INNER JOIN `usuarios` ON 
									`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									INNER JOIN `reales` ON 
									`planes`.`ID`=`reales`.`ID_PLAN` 
									WHERE 1 
									AND `planes`.`APROBADO`='SI' 
									AND `reales`.`APROBADO`='SI' 
									AND `reales`.`MES_REAL`<='$sql_mes'
									$sql_ano
									$sql_gerencia
									$sql_departamento
									$sql_unidad
									$sql_cargo
									GROUP BY `planes`.`DESCRIPCION` ORDER BY `planes`.`DESCRIPCION`";
								$resultados_i=mysqli_query($conexion,$consulta_i);
								$i=0;
								while(($fila_i=mysqli_fetch_array( $resultados_i))==true){
									$datos_i=$fila_i['DESCRIPCION'];
									echo "<option>$datos_i</option>";
									$i=$i+1;
								}
							?>
						</select>
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
								$consulta_i="SELECT `usuarios`.`NOMBRE`, `usuarios`.`APELLIDO`, `usuarios`.`CORREO` 
									FROM `planes` 
									INNER JOIN `descripcion_de_cargos` ON 
									`planes`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
									INNER JOIN `usuarios` ON 
									`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
									INNER JOIN `reales` ON 
									`planes`.`ID`=`reales`.`ID_PLAN` 
									WHERE 1 
									AND `planes`.`APROBADO`='SI' 
									AND `reales`.`APROBADO`='SI' 
									AND `reales`.`MES_REAL`<='$sql_mes'
									$sql_ano
									$sql_gerencia
									$sql_departamento
									$sql_unidad
									$sql_meta
									$sql_cargo
									GROUP BY `usuarios`.`APELLIDO`, `usuarios`.`NOMBRE`, `usuarios`.`CORREO` ORDER BY `usuarios`.`APELLIDO`, `usuarios`.`NOMBRE`, `usuarios`.`CORREO`";
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
									type: 'line',
									yAxisID: 'y-axis-2',
									label: "%",
									backgroundColor: 'rgba(0, 0, 0, 0.8)',
									fill: false,
									data: [<?php echo $porc_cumplimiento; ?>]
								},{
									type: 'bar',
									label: "P",
									yAxisID: 'y-axis-1',
									backgroundColor: 'rgba(255, 0, 0, 0.8)',
									data: [<?php echo $total_plan; ?>]
								},{
									type: 'bar',
									label: "R",
									yAxisID: 'y-axis-1',
									backgroundColor: 'rgba(0, 0, 255, 0.8)',
									data: [<?php echo $total_real; ?>]
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
									},
									{
										type: 'linear',
										display: true,
										position: 'right',
										id: 'y-axis-2',
										ticks: {
											beginAtZero:true
										},
										scaleLabel: {
											display: true,
											labelString: "% Cumplimiento",
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
									type: 'line',
									yAxisID: 'y-axis-2',
									label: "%Cumplimiento",
									backgroundColor: 'rgba(0, 0, 0, 0.8)',
									fill: false,
									data: [
										<?php
										$i=0;
										while(isset($total_plan_mes[$i])){
											echo $porc_cumplimiento_mes[$i];
											if(isset($total_plan_mes[$i+1])){
												echo ",";
											}
											$i=$i+1;
										}
										?>
									]
								},{
									type: 'bar',
									label: "Plan",
									yAxisID: 'y-axis-1',
									backgroundColor: 'rgba(255, 0, 0, 0.8)',
									data: [
										<?php
										$i=0;
										while(isset($total_plan_mes[$i])){
											echo $total_plan_mes[$i];
											if(isset($total_plan_mes[$i+1])){
												echo ",";
											}
											$i=$i+1;
										}
										?>
									]
								},{
									type: 'bar',
									label: "Real",
									yAxisID: 'y-axis-1',
									backgroundColor: 'rgba(0, 0, 255, 0.8)',
									data: [
										<?php
										$i=0;
										while(isset($total_plan_mes[$i])){
											echo $total_real_mes[$i];
											if(isset($total_plan_mes[$i+1])){
												echo ",";
											}
											$i=$i+1;
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
									},
									{
										type: 'linear',
										display: true,
										position: 'right',
										id: 'y-axis-2',
										ticks: {
											beginAtZero:true
										},
										scaleLabel: {
											display: true,
											labelString: "% Cumplimiento",
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
								while(isset($graf4_tipo_departamento[$i])){
									echo "'" . $graf4_tipo_departamento[$i] . "'";
									if(isset($graf4_tipo_departamento[$i+1])){
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
								while(isset($graf4_tipo_departamento[$i])){
									echo $graf4_real[$i];
									if(isset($graf4_tipo_departamento[$i+1])){
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
			<div class="col-md-4 mb-2">
				<canvas id="graf_meta_1" height="180px" class="border-dark border rounded px-3"><p>Canvas no Soportado</p></canvas>
				<script type="text/javascript">
					var myChart = new Chart($("#graf_meta_1"), {
						type: 'pie',
						data: {
							labels: [
								<?php
								$i=0;
								while(isset($meta_nombre[$i])){
									echo "'" . $meta_nombre[$i] . "'";
									if(isset($meta_nombre[$i+1])){
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
								while(isset($meta_nombre[$i])){
									echo $meta_real_total[$i];
									if(isset($meta_nombre[$i+1])){
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
									text: 'Metas',
									fontSize: 16,
									fontColor: '#333'
							}
						}
					});
				</script>
			</div>
		</div>
		<hr>
		<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered">
			<thead>
				<tr>
					<td colspan="8" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Explicaciones por Meta:</td>
				</tr>
				<tr class="text-center">
					<th class="align-middle border-dark bordered"><b title="Nombre de la Meta">Meta</b></th>
					<th class="align-middle border-dark bordered"><b title="Nombre de la Meta">Unidad</b></th>
					<th class="align-middle border-dark bordered"><b title="Resumen de la Variación (Real - Plan = Variación)"> (R-P=Var)</b></th>
					<th class="align-middle border-dark bordered"><b title="Explicación de la Variación">Breve explicación de la Variación ( Real vs. Plan )</b></th>
					<th class="align-middle border-dark bordered"><b>Detalles</b><br><b class="text-dark fa fa-arrow-circle-down"></b></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=0;
					while(isset($meta_nombre[$i])){
						echo "<tr>
							<td class='text-left border-dark bordered'> $meta_nombre[$i]</td>
							<td class='text-justify border-dark bordered'>$meta_unidad[$i]</td>
							<td class='text-center border-dark bordered' style='width:120px;'>$meta_real_total[$i]-$meta_plan_total_actual[$i]=";
						if($meta_variacion[$i]>0){
							echo "<b style='color:#00F;'>" . $meta_variacion[$i] . "</b>";
						}else{
							echo "<b style='color:#F00;'>" . $meta_variacion[$i] . "</b>";
						}
						echo "</td>
							<td class='text-justify border-dark bordered'>";
							if($meta_explicacion[$i]=="" and $meta_variacion[$i]){
								echo "<i style='color:#F00;'>Sin Información</i>";
							}else{
								echo $meta_explicacion[$i];
							}
							echo "</td>";
							echo "<td class='text-center border-dark bordered'><a data-toggle='collapse' data-target='#Example$i' aria-controls='Example$i' aria-expanded='false' aria-label='Toggle navigation' class='text-danger fa fa-plus-square-o link_para_mostrar' href='#Example$i'> Detalle</a></td>";
							echo "</tr>";
						$i=$i+1;
					}
				?>
			</tbody>
		</table>
		<br>
		<?php
			//IMPRIMIENDO LAS TABLAS DEL DETALLE REAL PARA CADA META
			$i=0;
			while(isset($meta_nombre[$i])){
		?>
		<div class="collapse navbar-collapse my-3" id="Example<?php echo $i; ?>">
			<hr>
			<table class="table table-hover table-bordered text-justify m-auto border-dark border">
				<tr>
					<th colspan="13" class="text-center bg-dark text-light h3 border-dark bordered">Detalle por mes para la Meta: <strong><?php echo $meta_nombre[$i]; ?></strong></th>
				</tr>
				<tr>
					<th class="text-center border-dark bordered" style="width:7.6%;">Dato</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Ene</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Feb</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Mar</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Abr</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">May</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Jun</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Jul</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Ago</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Sep</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Oct</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Nov</th>
					<th class="text-center border-dark bordered" style="width:7.7%;">Dic</th>
				</tr>
				<?php
				echo "<tr>";
				echo "<th class='text-center border-dark bordered'>Plan</th>";
				$c1=0;
				while(isset($meta_plan_mes[$i][$c1])){
					echo "<td class='text-center bg-light text-dark border-dark bordered'>" . $meta_plan_mes[$i][$c1] . "</td>";
					$c1=$c1+1;
				}
				echo "</tr>";
				echo "<tr>";
				echo "<th class='text-center border-dark bordered'>Real</th>";
				$c1=0;
				while(isset($meta_real_mes[$i][$c1])){
					if($c1>$sql_mes-1){
						echo "<td class='text-center bg-light text-light border-dark bordered'>" . $meta_real_mes[$i][$c1] . "</td>";
					}else{
						echo "<td class='text-center bg-light text-dark border-dark bordered'>" . $meta_real_mes[$i][$c1] . "</td>";
					}
					$c1=$c1+1;
				}
				echo "</tr>";
				?>
				<tr>
					<th colspan="13" class="text-center bg-dark text-light h4 border-dark bordered">Actividades cargadas</th>
				</tr>
				<tr>
					<th colspan="1" class="text-center border-dark bordered">Mes</th>
					<th colspan="1" class="text-center border-dark bordered">Cantidad</th>
					<th colspan="4" class="text-justify border-dark bordered">Detalle 1</th>
					<th colspan="4" class="text-justify border-dark bordered">Detalle 2</th>
					<th colspan="3" class="text-justify border-dark bordered">Detalle 3</th>
				</tr>
				<?php
				$consulta_i2="SELECT `reales`.`MES_REAL` AS MES_REAL, `reales`.`CANTIDAD` AS CANTIDAD, `reales`.`DETALLE_01` AS DETALLE_01, `reales`.`DETALLE_02` AS DETALLE_02, `reales`.`DETALLE_03` AS DETALLE_03 FROM `reales` INNER JOIN `planes` ON `reales`.`ID_PLAN`=`planes`.`ID` WHERE `reales`.`ID_PLAN`='$meta_id[$i]' AND `reales`.`APROBADO`='SI' ORDER BY `reales`.`MES_REAL`, `reales`.`DETALLE_01`";
				$resultados_i2=mysqli_query($conexion,$consulta_i2);
				$i2=0;
				while(($fila_i2=mysqli_fetch_array($resultados_i2))==true){
					if($fila_i2['MES_REAL']>$sql_mes){
						echo "<tr class='text-danger' title='ESTE DATO ESTA MAL CARGADO'>";
					}else{
						echo "<tr>";
					}
					echo "<td colspan='1' class='text-center border-dark bordered'>" . $fila_i2['MES_REAL'] . "</td>";
					echo "<td colspan='1' class='text-center border-dark bordered'>" . $fila_i2['CANTIDAD'] . "</td>";
					echo "<td colspan='4' class='text-justify border-dark bordered'>" . $fila_i2['DETALLE_01'] . "</td>";
					echo "<td colspan='4' class='text-justify border-dark bordered'>" . $fila_i2['DETALLE_02'] . "</td>";
					echo "<td colspan='3' class='text-justify border-dark bordered'>" . $fila_i2['DETALLE_03'] . "</td>";
					echo "</tr>";
					$i2=$i2+1;
				}				
				?>
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