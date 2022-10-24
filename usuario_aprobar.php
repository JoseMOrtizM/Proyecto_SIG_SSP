<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_GET["CRUD"])){
		//SI SE MANDÓ A APROBAR LA ACTIVIDAD PLAN
		if($_GET["CRUD"]=="U_PLANES_SI"){
			$crud_id=mysqli_real_escape_string($conexion, $_GET['CRUD_Id']);
			$consulta="UPDATE `planes` SET 
			`APROBADO`='SI', 
			`COMENTARIO_RECHASADO`='' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A APROBAR LA ACTIVIDAD REAL
		}else if($_GET["CRUD"]=="U_REALES_SI"){
			$crud_id=mysqli_real_escape_string($conexion, $_GET['CRUD_Id']);
			$consulta="UPDATE `reales` SET 
			`APROBADO`='SI', 
			`COMENTARIO_RECHASADO`='' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A APROBAR LA ACTIVIDAD REAL ADICIONAL
		}else if($_GET["CRUD"]=="U_REALES_ADC_SI"){
			$crud_id=mysqli_real_escape_string($conexion, $_GET['CRUD_Id']);
			$consulta="UPDATE `reales_adicional` SET 
			`APROBADO`='SI', 
			`COMENTARIO_RECHASADO`='' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		} 
	}
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A MODIFICAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="U_PLANES_NO"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_Id']);
			if(isset($_POST['comentario_rechaso'])){
				$comentario_rechasado=mysqli_real_escape_string($conexion, $_POST['comentario_rechaso']);
			}else{
				$comentario_rechasado="";
			}
			$consulta="UPDATE `planes` SET 
			`APROBADO`='NO', 
			`COMENTARIO_RECHASADO`='$comentario_rechasado'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}else if($_POST["CRUD"]=="U_REALES_NO"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_Id']);
			if(isset($_POST['comentario_rechaso'])){
				$comentario_rechasado=mysqli_real_escape_string($conexion, $_POST['comentario_rechaso']);
			}else{
				$comentario_rechasado="";
			}
			$consulta="UPDATE `reales` SET 
			`APROBADO`='NO', 
			`COMENTARIO_RECHASADO`='$comentario_rechasado'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}else if($_POST["CRUD"]=="U_REALES_ADC_NO"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_Id']);
			if(isset($_POST['comentario_rechaso'])){
				$comentario_rechasado=mysqli_real_escape_string($conexion, $_POST['comentario_rechaso']);
			}else{
				$comentario_rechasado="";
			}
			$consulta="UPDATE `reales_adicional` SET 
			`APROBADO`='NO', 
			`COMENTARIO_RECHASADO`='$comentario_rechasado'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... 

	//SE OBTIENEN LOS DATOS DE planes PARA PENDIENTES POR APROBAR
	$consulta="SELECT
	`planes`.`ID` AS ID,
	`planes`.`CARGO` AS CARGO,
	`planes`.`DESCRIPCION` AS DESCRIPCION,
	`planes`.`ANO` AS ANO,
	`planes`.`UNIDAD` AS UNIDAD,
	`planes`.`1` AS MES_1, 
	`planes`.`2` AS MES_2, 
	`planes`.`3` AS MES_3, 
	`planes`.`4` AS MES_4, 
	`planes`.`5` AS MES_5, 
	`planes`.`6` AS MES_6, 
	`planes`.`7` AS MES_7, 
	`planes`.`8` AS MES_8, 
	`planes`.`9` AS MES_9, 
	`planes`.`10` AS MES_10, 
	`planes`.`11` AS MES_11, 
	`planes`.`12` AS MES_12, 
	`usuarios`.`CORREO` AS CORREO, 
	`usuarios`.`NOMBRE` AS NOMBRE, 
	`usuarios`.`APELLIDO` AS APELLIDO, 
	`descripcion_de_cargos`.`JEFE` AS JEFE 
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`planes`.`CARGO` 
	INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
	AND `planes`.`APROBADO`='NO' 
	AND `planes`.`COMENTARIO_RECHASADO`='' 
	ORDER BY `planes`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos_planes_aprobar['ID'][$i]=$fila['ID'];//********
		$datos_planes_aprobar['CARGO'][$i]=$fila['CARGO'];//********
		$datos_planes_aprobar['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos_planes_aprobar['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos_planes_aprobar['ANO'][$i]=$fila['ANO'];
		$datos_planes_aprobar['MES_1'][$i]=$fila['MES_1']; 
		$datos_planes_aprobar['MES_2'][$i]=$fila['MES_2']; 
		$datos_planes_aprobar['MES_3'][$i]=$fila['MES_3']; 
		$datos_planes_aprobar['MES_4'][$i]=$fila['MES_4']; 
		$datos_planes_aprobar['MES_5'][$i]=$fila['MES_5']; 
		$datos_planes_aprobar['MES_6'][$i]=$fila['MES_6']; 
		$datos_planes_aprobar['MES_7'][$i]=$fila['MES_7']; 
		$datos_planes_aprobar['MES_8'][$i]=$fila['MES_8']; 
		$datos_planes_aprobar['MES_9'][$i]=$fila['MES_9']; 
		$datos_planes_aprobar['MES_10'][$i]=$fila['MES_10']; 
		$datos_planes_aprobar['MES_11'][$i]=$fila['MES_11']; 
		$datos_planes_aprobar['MES_12'][$i]=$fila['MES_12']; 
		$datos_planes_aprobar['ACUMULADO'][$i]= $fila['1']+$fila['2']+$fila['3']+$fila['4']+$fila['5']+$fila['6']+$fila['7']+$fila['8']+$fila['9']+$fila['10']+$fila['11']+$fila['12'];//********ACUMULADO
		$datos_planes_aprobar['SUPERVISADO'][$i]= $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO'] . ")";//********
		$datos_planes_aprobar['JEFE'][$i]=$fila['JEFE'];//********
		$i=$i+1;
	}
	//SE OBTIENEN LOS DATOS DE planes RECHASADOS
	$consulta="SELECT
	`planes`.`ID` AS ID,
	`planes`.`CARGO` AS CARGO,
	`planes`.`DESCRIPCION` AS DESCRIPCION,
	`planes`.`COMENTARIO_RECHASADO` AS COMENTARIO_RECHASADO,
	`planes`.`ANO` AS ANO,
	`planes`.`UNIDAD` AS UNIDAD,
	`planes`.`1` AS MES_1, 
	`planes`.`2` AS MES_2, 
	`planes`.`3` AS MES_3, 
	`planes`.`4` AS MES_4, 
	`planes`.`5` AS MES_5, 
	`planes`.`6` AS MES_6, 
	`planes`.`7` AS MES_7, 
	`planes`.`8` AS MES_8, 
	`planes`.`9` AS MES_9, 
	`planes`.`10` AS MES_10, 
	`planes`.`11` AS MES_11, 
	`planes`.`12` AS MES_12, 
	`usuarios`.`CORREO` AS CORREO, 
	`usuarios`.`NOMBRE` AS NOMBRE, 
	`usuarios`.`APELLIDO` AS APELLIDO, 
	`descripcion_de_cargos`.JEFE AS JEFE 
	FROM `planes` 
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`planes`.`CARGO` 
	INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
	AND `planes`.`APROBADO`='NO' 
	AND `planes`.`COMENTARIO_RECHASADO`<>'' 
	ORDER BY `planes`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos_planes_rechasado['ID'][$i]=$fila['ID'];//********
		$datos_planes_rechasado['CARGO'][$i]=$fila['CARGO'];//********
		$datos_planes_rechasado['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos_planes_rechasado['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos_planes_rechasado['ANO'][$i]=$fila['ANO'];
		$datos_planes_rechasado['MES_1'][$i]=$fila['MES_1']; 
		$datos_planes_rechasado['MES_2'][$i]=$fila['MES_2']; 
		$datos_planes_rechasado['MES_3'][$i]=$fila['MES_3']; 
		$datos_planes_rechasado['MES_4'][$i]=$fila['MES_4']; 
		$datos_planes_rechasado['MES_5'][$i]=$fila['MES_5']; 
		$datos_planes_rechasado['MES_6'][$i]=$fila['MES_6']; 
		$datos_planes_rechasado['MES_7'][$i]=$fila['MES_7']; 
		$datos_planes_rechasado['MES_8'][$i]=$fila['MES_8']; 
		$datos_planes_rechasado['MES_9'][$i]=$fila['MES_9']; 
		$datos_planes_rechasado['MES_10'][$i]=$fila['MES_10']; 
		$datos_planes_rechasado['MES_11'][$i]=$fila['MES_11']; 
		$datos_planes_rechasado['MES_12'][$i]=$fila['MES_12']; 
		$datos_planes_rechasado['ACUMULADO'][$i]= $fila['1']+$fila['2']+$fila['3']+$fila['4']+$fila['5']+$fila['6']+$fila['7']+$fila['8']+$fila['9']+$fila['10']+$fila['11']+$fila['12'];//********ACUMULADO
		$datos_planes_rechasado['COMENTARIO_RECHASADO'][$i]=$fila['COMENTARIO_RECHASADO'];//***************
		$datos_planes_rechasado['SUPERVISADO'][$i]= $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO'] . ")";//********
		$datos_planes_rechasado['JEFE'][$i]=$fila['JEFE'];//********
		$i=$i+1;
	}
	//SE OBTIENEN LOS DATOS DE reales PARA PENDIENTES POR APROBAR
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
	`usuarios`.`CORREO` AS CORREO, 
	`usuarios`.`NOMBRE` AS NOMBRE, 
	`usuarios`.`APELLIDO` AS APELLIDO, 
	`descripcion_de_cargos`.`JEFE` AS JEFE 
	FROM `reales` 
	INNER JOIN `planes` ON `reales`.`ID_PLAN`=`planes`.`ID` 
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`planes`.`CARGO` 
	INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
	AND `reales`.`APROBADO`='NO' 
	AND `reales`.`COMENTARIO_RECHASADO`='' 
	ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos_reales_aprobar['ID'][$i]=$fila['ID'];
		$datos_reales_aprobar['ID_PLAN'][$i]=$fila['ID_PLAN'];
		$datos_reales_aprobar['CARGO'][$i]=$fila['CARGO'];//********
		$datos_reales_aprobar['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos_reales_aprobar['ANO'][$i]=$fila['ANO'];//********
		$datos_reales_aprobar['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos_reales_aprobar['MES_REAL'][$i]=$fila['MES_REAL'];//********
		$datos_reales_aprobar['CANTIDAD'][$i]=$fila['CANTIDAD'];//********
		$datos_reales_aprobar['DETALLE_01'][$i]=$fila['DETALLE_01'];
		$datos_reales_aprobar['DETALLE_02'][$i]=$fila['DETALLE_02'];
		$datos_reales_aprobar['DETALLE_03'][$i]=$fila['DETALLE_03'];
		$datos_reales_aprobar['SUPERVISADO'][$i]= $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO'] . ")";//********
		$datos_reales_aprobar['JEFE'][$i]=$fila['JEFE'];//********
		$i=$i+1;
	}
	//SE OBTIENEN LOS DATOS DE reales RECHASADOS
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
	`usuarios`.`CORREO` AS CORREO, 
	`usuarios`.`NOMBRE` AS NOMBRE, 
	`usuarios`.`APELLIDO` AS APELLIDO, 
	`descripcion_de_cargos`.`JEFE` AS JEFE 
	FROM `reales` 
	INNER JOIN `planes` ON `reales`.`ID_PLAN`=`planes`.`ID` 
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`planes`.`CARGO` 
	INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
	AND `reales`.`APROBADO`='NO' 
	AND `reales`.`COMENTARIO_RECHASADO`<>'' 
	ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos_reales_rechasado['ID'][$i]=$fila['ID'];
		$datos_reales_rechasado['ID_PLAN'][$i]=$fila['ID_PLAN'];
		$datos_reales_rechasado['CARGO'][$i]=$fila['CARGO'];//********
		$datos_reales_rechasado['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos_reales_rechasado['ANO'][$i]=$fila['ANO'];//********
		$datos_reales_rechasado['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos_reales_rechasado['MES_REAL'][$i]=$fila['MES_REAL'];//********
		$datos_reales_rechasado['CANTIDAD'][$i]=$fila['CANTIDAD'];//********
		$datos_reales_rechasado['DETALLE_01'][$i]=$fila['DETALLE_01'];
		$datos_reales_rechasado['DETALLE_02'][$i]=$fila['DETALLE_02'];
		$datos_reales_rechasado['DETALLE_03'][$i]=$fila['DETALLE_03'];
		$datos_reales_rechasado['COMENTARIO_RECHASADO'][$i]=$fila['COMENTARIO_RECHASADO'];//********
		$datos_reales_rechasado['SUPERVISADO'][$i]= $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO'] . ")";//********
		$datos_reales_rechasado['JEFE'][$i]=$fila['JEFE'];//********
		$i=$i+1;
	}
	//SE OBTIENEN LOS DATOS DE reales_adicionales PARA PENDIENTES POR APROBAR
	$consulta="SELECT
	`reales_adicional`.`ID` AS ID,
	`reales_adicional`.`CARGO` AS CARGO,
	`reales_adicional`.`DESCRIPCION` AS DESCRIPCION,
	`reales_adicional`.`FECHA_ACTIVIDAD` AS FECHA_ACTIVIDAD,
	`reales_adicional`.`UNIDAD` AS UNIDAD,
	`reales_adicional`.`CANTIDAD` AS CANTIDAD,
	`reales_adicional`.`DETALLE_01` AS DETALLE_01,
	`reales_adicional`.`DETALLE_02` AS DETALLE_02,
	`reales_adicional`.`DETALLE_03` AS DETALLE_03,
	`usuarios`.`CORREO` AS CORREO, 
	`usuarios`.`NOMBRE` AS NOMBRE, 
	`usuarios`.`APELLIDO` AS APELLIDO, 
	`descripcion_de_cargos`.`JEFE` AS JEFE 
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`reales_adicional`.`CARGO` 
	INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
	AND `reales_adicional`.`APROBADO`='NO' 
	AND `reales_adicional`.`COMENTARIO_RECHASADO`='' 
	ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos_reales_adc_aprobar['ID'][$i]=$fila['ID'];
		$datos_reales_adc_aprobar['CARGO'][$i]=$fila['CARGO'];//********
		$datos_reales_adc_aprobar['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos_reales_adc_aprobar['FECHA_ACTIVIDAD'][$i]=$fila['FECHA_ACTIVIDAD'];//********
		$datos_reales_adc_aprobar['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos_reales_adc_aprobar['CANTIDAD'][$i]=$fila['CANTIDAD'];//********
		$datos_reales_adc_aprobar['DETALLE_01'][$i]=$fila['DETALLE_01'];
		$datos_reales_adc_aprobar['DETALLE_02'][$i]=$fila['DETALLE_02'];
		$datos_reales_adc_aprobar['DETALLE_03'][$i]=$fila['DETALLE_03'];
		$datos_reales_adc_aprobar['SUPERVISADO'][$i]= $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO'] . ")";//********
		$datos_reales_adc_aprobar['JEFE'][$i]=$fila['JEFE'];//********
		$i=$i+1;
	}
	//SE OBTIENEN LOS DATOS DE reales_adicionales RECHASADOS
	$consulta="SELECT
	`reales_adicional`.`ID` AS ID,
	`reales_adicional`.`CARGO` AS CARGO,
	`reales_adicional`.`DESCRIPCION` AS DESCRIPCION,
	`reales_adicional`.`FECHA_ACTIVIDAD` AS FECHA_ACTIVIDAD,
	`reales_adicional`.`UNIDAD` AS UNIDAD,
	`reales_adicional`.`CANTIDAD` AS CANTIDAD,
	`reales_adicional`.`DETALLE_01` AS DETALLE_01,
	`reales_adicional`.`DETALLE_02` AS DETALLE_02,
	`reales_adicional`.`DETALLE_03` AS DETALLE_03,
	`reales_adicional`.`COMENTARIO_RECHASADO` AS COMENTARIO_RECHASADO,
	`usuarios`.`CORREO` AS CORREO, 
	`usuarios`.`NOMBRE` AS NOMBRE, 
	`usuarios`.`APELLIDO` AS APELLIDO, 
	`descripcion_de_cargos`.`JEFE` AS JEFE 
	FROM `reales_adicional` 
	INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`reales_adicional`.`CARGO` 
	INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
	WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
	AND `reales_adicional`.`APROBADO`='NO' 
	AND `reales_adicional`.`COMENTARIO_RECHASADO`<>'' 
	ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos_reales_adc_rechasado['ID'][$i]=$fila['ID'];
		$datos_reales_adc_rechasado['CARGO'][$i]=$fila['CARGO'];//********
		$datos_reales_adc_rechasado['DESCRIPCION'][$i]=$fila['DESCRIPCION'];//********
		$datos_reales_adc_rechasado['FECHA_ACTIVIDAD'][$i]=$fila['FECHA_ACTIVIDAD'];//********
		$datos_reales_adc_rechasado['UNIDAD'][$i]=$fila['UNIDAD'];//********
		$datos_reales_adc_rechasado['CANTIDAD'][$i]=$fila['CANTIDAD'];//********
		$datos_reales_adc_rechasado['DETALLE_01'][$i]=$fila['DETALLE_01'];
		$datos_reales_adc_rechasado['DETALLE_02'][$i]=$fila['DETALLE_02'];
		$datos_reales_adc_rechasado['DETALLE_03'][$i]=$fila['DETALLE_03'];
		$datos_reales_adc_rechasado['COMENTARIO_RECHASADO'][$i]=$fila['COMENTARIO_RECHASADO'];
		$datos_reales_adc_rechasado['SUPERVISADO'][$i]= $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO'] . ")";//********
		$datos_reales_adc_rechasado['JEFE'][$i]=$fila['JEFE'];//********
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Aprobar-<?php echo $usuario_nombre;?></title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<?php 
		if(isset($_GET["CRUD"])){
			//SI SE MANDÓ A APROBAR LA ACTIVIDAD PLAN
			if($_GET["CRUD"]=="U_PLANES_NO"){
				echo "
					<div class='col-md-12 col-lg-9 mx-auto'>
						<div class='row mt-4 align-items-center'>
							<div class='col-md-9 mb-1'>
								<h3 class='text-center text-md-left' title='Incluir motivo de rechaso'><span class='text-danger fa fa-cog fa-spin '></span> Motivo de Rechaso:</h3>
							</div>
							<div class='col-md-3 text-center text-md-right mb-1'>
								<a href='usuario_aprobar.php' class='btn btn-danger text-light p-1'><span class='fa fa-reply-all'></span> Volver</a>
							</div>
						</div>
						<form action='usuario_aprobar.php' method='post' class='text-center bg-dark p-2 rounded'>
							<input type='hidden' name='CRUD' id='CRUD' value='U_PLANES_NO'>
							<input type='hidden' name='CRUD_Id' id='CRUD_Id' value='" . $_GET['CRUD_Id'] . "'>
							<div class='input-group mb-2'>
								<span class='input-group-text w-100'>Comentario de Rechaso:</span>
								<textarea class='form-control col mb-2 comentario_rechaso' name='comentario_rechaso' id='comentario_rechaso' required></textarea>
							</div>
							<div class='m-auto'>
								<a href='usuario_aprobar.php' class='btn btn-danger text-light'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Insertar Nuevo Renglón &raquo;' class='btn btn-danger'>
							</div>
						</form>
						<br><br><br><br>
					</div>
				";
			//SI SE MANDÓ A APROBAR LA ACTIVIDAD REAL
			}else if($_GET["CRUD"]=="U_REALES_NO"){
				echo "
					<div class='col-md-12 col-lg-9 mx-auto'>
						<div class='row mt-4 align-items-center'>
							<div class='col-md-9 mb-1'>
								<h3 class='text-center text-md-left' title='Incluir motivo de rechaso'><span class='text-danger fa fa-cog fa-spin '></span> Motivo de Rechaso:</h3>
							</div>
							<div class='col-md-3 text-center text-md-right mb-1'>
								<a href='usuario_aprobar.php' class='btn btn-danger text-light p-1'><span class='fa fa-reply-all'></span> Volver</a>
							</div>
						</div>
						<form action='usuario_aprobar.php' method='post' class='text-center bg-dark p-2 rounded'>
							<input type='hidden' name='CRUD' id='CRUD' value='U_REALES_NO'>
							<input type='hidden' name='CRUD_Id' id='CRUD_Id' value='" . $_GET['CRUD_Id'] . "'>
							<div class='input-group mb-2'>
								<span class='input-group-text w-100'>Comentario de Rechaso:</span>
								<textarea class='form-control col mb-2 comentario_rechaso' name='comentario_rechaso' id='comentario_rechaso' required></textarea>
							</div>
							<div class='m-auto'>
								<a href='usuario_aprobar.php' class='btn btn-danger text-light'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Insertar Nuevo Renglón &raquo;' class='btn btn-danger'>
							</div>
						</form>
						<br><br><br><br>
					</div>
				";
			//SI SE MANDÓ A APROBAR LA ACTIVIDAD REAL ADICIONAL
			}else if($_GET["CRUD"]=="U_REALES_ADC_NO"){
				echo "
					<div class='col-md-12 col-lg-9 mx-auto'>
						<div class='row mt-4 align-items-center'>
							<div class='col-md-9 mb-1'>
								<h3 class='text-center text-md-left' title='Incluir motivo de rechaso'><span class='text-danger fa fa-cog fa-spin '></span> Motivo de Rechaso:</h3>
							</div>
							<div class='col-md-3 text-center text-md-right mb-1'>
								<a href='usuario_aprobar.php' class='btn btn-danger text-light p-1'><span class='fa fa-reply-all'></span> Volver</a>
							</div>
						</div>
						<form action='usuario_aprobar.php' method='post' class='text-center bg-dark p-2 rounded'>
							<input type='hidden' name='CRUD' id='CRUD' value='U_REALES_ADC_NO'>
							<input type='hidden' name='CRUD_Id' id='CRUD_Id' value='" . $_GET['CRUD_Id'] . "'>
							<div class='input-group mb-2'>
								<span class='input-group-text w-100'>Comentario de Rechaso:</span>
								<textarea class='form-control col mb-2 comentario_rechaso' name='comentario_rechaso' id='comentario_rechaso' required></textarea>
							</div>
							<div class='m-auto'>
								<a href='usuario_aprobar.php' class='btn btn-danger text-light'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Insertar Nuevo Renglón &raquo;' class='btn btn-danger'>
							</div>
						</form>
						<br><br><br><br>
					</div>
				";
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=usuario_aprobar.php">
		<?php
			}
		}else{
		?>
		<h5 class='text-justify rounded border-danger border p-3'><b>IMPORTANTE:</b> En esta sección se muestran 6 tablas; las 3 primeras muestran las actividades que están pendientes por tu aprobación (1.- ACTIVIDADES PLANIFICADAS, 2.- ACTIVIDADES REALES y 3.- ACTIVIDADES ADICIONALES), mientras que las 3 últimas nuestran las actividades que has rechadas (4.- ACTIVIDADES PLANIFICADAS, 5.- ACTIVIDADES REALES y 6.- ACTIVIDADES ADICIONALES). Si el simbolo <span class="bg-dark text-warning fa fa-bell-o px-1"></span> apare en la sección "Aprobar Actividades" de tus "Opciones de usuario", debes revisar al mesnos las 3 primeras tablas hasta no tener ningún pendiente que aprobar.</h5>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Planes Pendientes por Aprobar:</h3>
			</div>
			<?php
				if(isset($datos_planes_aprobar['ID'][0])){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Planificadas por Aprobar</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Sólo las actividades aprobadas serán consideradas en los indicadores</p>";
				}else{
					echo "<h3 class='text-center bg-success rounded m-auto p-2'>Sin Actividades Planificadas por Aprobar</h3>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Nombre del Supervisado">Empleado / Cargo</b></th>
								<th class="align-middle border-dark bordered"><b title="Descripción de la Actvidad Planificada">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Año correspondiente a la Actvidad Planificada">Año</b></th>
								<th class="align-middle border-dark bordered"><b title="Unidad de Medida">Unidad</b></th>
								<th class="align-middle border-dark bordered"><b title="Cantidad Total Planificada">Total<br>Plan</b></th>
								<th class="align-middle border-dark bordered">¿Aprobar?<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos_planes_aprobar['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos_planes_aprobar['SUPERVISADO'][$i] . "<br>" . $datos_planes_aprobar['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos_planes_aprobar['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_planes_aprobar['ANO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_planes_aprobar['UNIDAD'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos_planes_aprobar['ACUMULADO'][$i];
										echo "<br><a href='' class='h3 btn btn-transparent text-primary d-inline' aria-hidden='true' title='Detalle' data-toggle='modal' data-target='#modal_plan_detalle_$i'>Detalle</a>";
										//Modal
										echo "<div class='modal fade bd-example-modal-lg' id='modal_plan_detalle_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_plan_detalle_$i' aria-hidden='true'>";
										echo "<div class='modal-dialog modal-lg' role='document'>
												<div class='modal-content text-justify px-4 py-1'>
													<div class='modal-header'>
														<h4 class='modal-title text-danger' id='Modal_Title_plan_detalle_$i'>Detalle de Actividades Planificadas</h4>
														<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
													<div class='modal-body'>
														<table class='table table-bordered table-hover'>
															<tr>
																<th colspan='12' class='text-center'>" . $datos_planes_aprobar['DESCRIPCION'][$i] . "</th>
															</tr>
															<tr>
																<th>Ene</th>
																<th>Feb</th>
																<th>Mar</th>
																<th>Abr</th>
																<th>May</th>
																<th>Jun</th>
																<th>Jul</th>
																<th>Ago</th>
																<th>Sep</th>
																<th>Oct</th>
																<th>Nov</th>
																<th>Dic</th>
															</tr>
															<tr>
																<td>" . $datos_planes_aprobar['MES_1'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_2'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_3'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_4'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_5'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_6'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_7'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_8'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_9'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_10'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_11'][$i] . "</td>
																<td>" . $datos_planes_aprobar['MES_12'][$i] . "</td>
															</tr>
														</table>
													</div>
													<div class='modal-footer'>
														<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</div>";
										echo "</div>";
									?>
								</td>
								<td class="text-center h5">
									<a title="Aprobar" href="usuario_aprobar.php?CRUD=U_PLANES_SI&CRUD_Id=<?php echo $datos_planes_aprobar['ID'][$i]; ?>" class="h3 btn btn-transparent text-success d-inline">SI</a>
									&nbsp;
									<a title="Aprobar" href="usuario_aprobar.php?CRUD=U_PLANES_NO&CRUD_Id=<?php echo $datos_planes_aprobar['ID'][$i]; ?>" class="h3 btn btn-transparent text-danger d-inline">NO</a>
								</td>
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
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Actividades Reales Pendientes por Aprobar:</h3>
			</div>
			<?php
				if(isset($datos_reales_aprobar['ID'][0])){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Reales por Aprobar</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Sólo las actividades aprobadas serán consideradas en los indicadores</p>";
				}else{
					echo "<h3 class='text-center bg-success rounded m-auto p-2'>Sin Actividades Reales por Aprobar</h3>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Nombre del Supervisado">Empleado / Cargo</b></th>
								<th class="align-middle border-dark bordered"><b title="Descripción de la Actvidad Real">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Año correspondiente a la Actvidad">Año</b></th>
								<th class="align-middle border-dark bordered"><b title="Unidad de Medida">Unidad</b></th>
								<th class="align-middle border-dark bordered"><b title="Cantidad Real">Cantidad</b></th>
								<th class="align-middle border-dark bordered">¿Aprobar?<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos_reales_aprobar['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos_reales_aprobar['SUPERVISADO'][$i] . "<br>" . $datos_reales_aprobar['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos_reales_aprobar['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_aprobar['ANO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_aprobar['UNIDAD'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos_reales_aprobar['CANTIDAD'][$i];
										echo "<br><a href='' class='h3 btn btn-transparent text-primary d-inline' aria-hidden='true' title='Detalle' data-toggle='modal' data-target='#modal_real_detalle_$i'>Detalle</a>";
										//Modal
										echo "<div class='modal fade bd-example-modal-lg' id='modal_real_detalle_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_real_detalle_$i' aria-hidden='true'>";
										echo "<div class='modal-dialog modal-lg' role='document'>
												<div class='modal-content text-justify px-4 py-1'>
													<div class='modal-header'>
														<h4 class='modal-title text-danger' id='Modal_Title_real_detalle_$i'>Detalle de Actividad Real</h4>
														<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
													<div class='modal-body'>
														<table class='table table-bordered table-hover'>
															<tr>
																<th colspan='2' class='text-center'>" . $datos_reales_aprobar['DESCRIPCION'][$i] . "</th>
															</tr>
															<tr>
																<th>Detalles 01</th>
																<td>" . $datos_reales_aprobar['DETALLE_01'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 02</th>
																<td>" . $datos_reales_aprobar['DETALLE_02'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 03</th>
																<td>" . $datos_reales_aprobar['DETALLE_03'][$i] . "</td>
															</tr>
														</table>
													</div>
													<div class='modal-footer'>
														<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</div>";
										echo "</div>";
									?>
								</td>
								<td class="text-center h5">
									<a title="Aprobar" href="usuario_aprobar.php?CRUD=U_REALES_SI&CRUD_Id=<?php echo $datos_reales_aprobar['ID'][$i]; ?>" class="h3 btn btn-transparent text-success d-inline">SI</a>
									&nbsp;
									<a title="Aprobar" href="usuario_aprobar.php?CRUD=U_REALES_NO&CRUD_Id=<?php echo $datos_reales_aprobar['ID'][$i]; ?>" class="h3 btn btn-transparent text-danger d-inline">NO</a>
								</td>
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
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Actividades Adicionales Pendientes por Aprobar:</h3>
			</div>
			<?php
				if(isset($datos_reales_adc_aprobar['ID'][0])){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Adicionales por Aprobar</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Sólo las actividades aprobadas serán consideradas en los indicadores</p>";
				}else{
					echo "<h3 class='text-center bg-success rounded m-auto p-2'>Sin Actividades Adicionales por Aprobar</h3>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Nombre del Supervisado">Empleado / Cargo</b></th>
								<th class="align-middle border-dark bordered"><b title="Descripción de la Actvidad Real">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Fecha correspondiente a la Actvidad">Fecha</b></th>
								<th class="align-middle border-dark bordered"><b title="Unidad de Medida">Unidad</b></th>
								<th class="align-middle border-dark bordered"><b title="Cantidad Real Adicional">Cantidad</b></th>
								<th class="align-middle border-dark bordered">¿Aprobar?<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos_reales_adc_aprobar['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos_reales_adc_aprobar['SUPERVISADO'][$i] . "<br>" . $datos_reales_adc_aprobar['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos_reales_adc_aprobar['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_adc_aprobar['FECHA_ACTIVIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_adc_aprobar['UNIDAD'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos_reales_adc_aprobar['CANTIDAD'][$i];
										echo "<br><a href='' class='h3 btn btn-transparent text-primary d-inline' aria-hidden='true' title='Detalle' data-toggle='modal' data-target='#modal_real_adc_detalle_$i'>Detalle</a>";
										//Modal
										echo "<div class='modal fade bd-example-modal-lg' id='modal_real_adc_detalle_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_real_adc_detalle_$i' aria-hidden='true'>";
										echo "<div class='modal-dialog modal-lg' role='document'>
												<div class='modal-content text-justify px-4 py-1'>
													<div class='modal-header'>
														<h4 class='modal-title text-danger' id='Modal_Title_real_adc_detalle_$i'>Detalle de Actividad Real Adicional</h4>
														<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
													<div class='modal-body'>
														<table class='table table-bordered table-hover'>
															<tr>
																<th colspan='2' class='text-center'>" . $datos_reales_adc_aprobar['DESCRIPCION'][$i] . "</th>
															</tr>
															<tr>
																<th>Detalles 01</th>
																<td>" . $datos_reales_adc_aprobar['DETALLE_01'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 02</th>
																<td>" . $datos_reales_adc_aprobar['DETALLE_02'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 03</th>
																<td>" . $datos_reales_adc_aprobar['DETALLE_03'][$i] . "</td>
															</tr>
														</table>
													</div>
													<div class='modal-footer'>
														<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</div>";
										echo "</div>";
									?>
								</td>
								<td class="text-center h5">
									<a title="Aprobar" href="usuario_aprobar.php?CRUD=U_REALES_ADC_SI&CRUD_Id=<?php echo $datos_reales_adc_aprobar['ID'][$i]; ?>" class="h3 btn btn-transparent text-success d-inline">SI</a>
									&nbsp;
									<a title="Aprobar" href="usuario_aprobar.php?CRUD=U_REALES_ADC_NO&CRUD_Id=<?php echo $datos_reales_adc_aprobar['ID'][$i]; ?>" class="h3 btn btn-transparent text-danger d-inline">NO</a>
								</td>
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
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Planes Rechasados:</h3>
			</div>
			<?php
				if(isset($datos_planes_rechasado['ID'][0])){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Planinifacas Rechasadas</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Tu supervisado debe corregir o eliminar esta actividad a la brevedad</p>";
				}else{
					echo "<h3 class='text-center bg-success rounded m-auto p-2'>Sin Actividades Planificadas Rechasadas</h3>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Nombre del Supervisado">Empleado / Cargo</b></th>
								<th class="align-middle border-dark bordered"><b title="Descripción de la Actvidad Planificada">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Año correspondiente a la Actvidad Planificada">Año</b></th>
								<th class="align-middle border-dark bordered"><b title="Unidad de Medida">Unidad</b></th>
								<th class="align-middle border-dark bordered"><b title="Cantidad Total Planificada">Total<br>Plan</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos_planes_rechasado['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos_planes_rechasado['SUPERVISADO'][$i] . "<br>" . $datos_planes_rechasado['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos_planes_rechasado['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_planes_rechasado['ANO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_planes_rechasado['UNIDAD'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos_planes_rechasado['ACUMULADO'][$i];
										echo "<br><a href='' class='h3 btn btn-transparent text-primary d-inline' aria-hidden='true' title='Detalle' data-toggle='modal' data-target='#modal_plan_detalle_rechasado_$i'>Detalle</a>";
										//Modal
										echo "<div class='modal fade bd-example-modal-lg' id='modal_plan_detalle_rechasado_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_plan_detalle_rechasado_$i' aria-hidden='true'>";
										echo "<div class='modal-dialog modal-lg' role='document'>
												<div class='modal-content text-justify px-4 py-1'>
													<div class='modal-header'>
														<h4 class='modal-title text-danger' id='Modal_Title_plan_detalle_rechasado_$i'>Detalle de Actividades Planificadas</h4>
														<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
													<div class='modal-body'>
														<table class='table table-bordered table-hover'>
															<tr>
																<th colspan='12' class='text-center'>" . $datos_planes_rechasado['DESCRIPCION'][$i] . "</th>
															</tr>
															<tr>
																<th>Ene</th>
																<th>Feb</th>
																<th>Mar</th>
																<th>Abr</th>
																<th>May</th>
																<th>Jun</th>
																<th>Jul</th>
																<th>Ago</th>
																<th>Sep</th>
																<th>Oct</th>
																<th>Nov</th>
																<th>Dic</th>
															</tr>
															<tr>
																<td>" . $datos_planes_rechasado['MES_1'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_2'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_3'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_4'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_5'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_6'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_7'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_8'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_9'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_10'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_11'][$i] . "</td>
																<td>" . $datos_planes_rechasado['MES_12'][$i] . "</td>
															</tr>
															<tr>
																<td colspan='12' class='text-left'>RECHASADO POR: " . $datos_planes_rechasado['COMENTARIO_RECHASADO'][$i] . "</td>
															</tr>
														</table>
													</div>
													<div class='modal-footer'>
														<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</div>";
										echo "</div>";
									?>
								</td>
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
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Actividades Reales Rechasadas:</h3>
			</div>
			<?php
				if(isset($datos_reales_rechasado['ID'][0])){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Reales Rechasadas</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Tu supervisado debe corregir o eliminar esta actividad a la brevedad</p>";
				}else{
					echo "<h3 class='text-center bg-success rounded m-auto p-2'>Sin Actividades Reales Rechasadas</h3>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Nombre del Supervisado">Empleado / Cargo</b></th>
								<th class="align-middle border-dark bordered"><b title="Descripción de la Actvidad Planificada">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Año correspondiente a la Actvidad Planificada">Año</b></th>
								<th class="align-middle border-dark bordered"><b title="Unidad de Medida">Unidad</b></th>
								<th class="align-middle border-dark bordered"><b title="Cantidad Real">Real</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos_reales_rechasado['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos_reales_rechasado['SUPERVISADO'][$i] . "<br>" . $datos_reales_rechasado['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos_reales_rechasado['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_rechasado['ANO'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_rechasado['UNIDAD'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos_reales_rechasado['CANTIDAD'][$i];
										echo "<br><a href='' class='h3 btn btn-transparent text-primary d-inline' aria-hidden='true' title='Detalle' data-toggle='modal' data-target='#modal_real_detalle_rechasado_$i'>Detalle</a>";
										//Modal
										echo "<div class='modal fade bd-example-modal-lg' id='modal_real_detalle_rechasado_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_real_detalle_rechasado_$i' aria-hidden='true'>";
										echo "<div class='modal-dialog modal-lg' role='document'>
												<div class='modal-content text-justify px-4 py-1'>
													<div class='modal-header'>
														<h4 class='modal-title text-danger' id='Modal_Title_real_detalle_rechasado_$i'>Detalle de Actividad Real</h4>
														<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
													<div class='modal-body'>
														<table class='table table-bordered table-hover'>
															<tr>
																<th colspan='2' class='text-center'>" . $datos_reales_rechasado['DESCRIPCION'][$i] . "</th>
															</tr>
															<tr>
																<th>Detalles 01</th>
																<td>" . $datos_reales_rechasado['DETALLE_01'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 02</th>
																<td>" . $datos_reales_rechasado['DETALLE_02'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 03</th>
																<td>" . $datos_reales_rechasado['DETALLE_03'][$i] . "</td>
															</tr>
															<tr>
																<th>Rechasado por:</th>
																<td>" . $datos_reales_rechasado['COMENTARIO_RECHASADO'][$i] . "</td>
															</tr>
														</table>
													</div>
													<div class='modal-footer'>
														<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</div>";
										echo "</div>";
									?>
								</td>
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
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Actividades Adicionales Rechasadas:</h3>
			</div>
			<?php
				if(isset($datos_reales_adc_rechasado['ID'][0])){
					echo "<h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Actividades Adicionales Rechasadas</h3>";
					echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Tu supervisado debe corregir o eliminar esta actividad a la brevedad</p>";
				}else{
					echo "<h3 class='text-center bg-success rounded m-auto p-2'>Sin Actividades Adicionales Rechasadas</h3>";
				}
			?>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Nombre del Supervisado">Empleado / Cargo</b></th>
								<th class="align-middle border-dark bordered"><b title="Descripción de la Actvidad Planificada">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Fecha correspondiente a la Actvidad Planificada">Fecha</b></th>
								<th class="align-middle border-dark bordered"><b title="Unidad de Medida">Unidad</b></th>
								<th class="align-middle border-dark bordered"><b title="Cantidad Real">Real</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos_reales_adc_rechasado['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos_reales_adc_rechasado['SUPERVISADO'][$i] . "<br>" . $datos_reales_adc_rechasado['CARGO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos_reales_adc_rechasado['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_adc_rechasado['FECHA_ACTIVIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos_reales_adc_rechasado['UNIDAD'][$i]; ?></td>
								<td class="text-center">
									<?php 
										echo $datos_reales_adc_rechasado['CANTIDAD'][$i];
										echo "<br><a href='' class='h3 btn btn-transparent text-primary d-inline' aria-hidden='true' title='Detalle' data-toggle='modal' data-target='#modal_real_adc_detalle_rechasado_$i'>Detalle</a>";
										//Modal
										echo "<div class='modal fade bd-example-modal-lg' id='modal_real_adc_detalle_rechasado_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_real_adc_detalle_rechasado_$i' aria-hidden='true'>";
										echo "<div class='modal-dialog modal-lg' role='document'>
												<div class='modal-content text-justify px-4 py-1'>
													<div class='modal-header'>
														<h4 class='modal-title text-danger' id='Modal_Title_real_adc_detalle_rechasado_$i'>Detalle de Actividad Real Adicional</h4>
														<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
													<div class='modal-body'>
														<table class='table table-bordered table-hover'>
															<tr>
																<th colspan='2' class='text-center'>" . $datos_reales_adc_rechasado['DESCRIPCION'][$i] . "</th>
															</tr>
															<tr>
																<th>Detalles 01</th>
																<td>" . $datos_reales_adc_rechasado['DETALLE_01'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 02</th>
																<td>" . $datos_reales_adc_rechasado['DETALLE_02'][$i] . "</td>
															</tr>
															<tr>
																<th>Detalles 03</th>
																<td>" . $datos_reales_adc_rechasado['DETALLE_03'][$i] . "</td>
															</tr>
															<tr>
																<th>Rechasado por:</th>
																<td>" . $datos_reales_adc_rechasado['COMENTARIO_RECHASADO'][$i] . "</td>
															</tr>
														</table>
													</div>
													<div class='modal-footer'>
														<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</div>";
										echo "</div>";
									?>
								</td>
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
	  $('.TablaDinamica').DataTable();
	});
</script>
<script>
	$(document).ready(function() {
		$('.comentario_rechaso').summernote({
			placeholder: 'Indique el motivo por el cual no se aprueba esta información',
			tabsize: 1,
			height: 100			
		});
	});
</script>
<?php
mysqli_close($conexion);
?>