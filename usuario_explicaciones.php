<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$explicacion=mysqli_real_escape_string($conexion, $_POST['explicacion']);
			$consulta="UPDATE `planes` SET 
			`EXPLICACION`='$explicacion'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT 
	`planes`.`ID` AS ID,
	`planes`.`DESCRIPCION` AS META,
	`planes`.`CARGO` AS CARGO,
	`planes`.`UNIDAD` AS UNIDAD,
	`planes`.`ANO` AS ANO,
	`planes`.`1` AS PLAN_MES_1, 
	`planes`.`2` AS PLAN_MES_2, 
	`planes`.`3` AS PLAN_MES_3, 
	`planes`.`4` AS PLAN_MES_4, 
	`planes`.`5` AS PLAN_MES_5, 
	`planes`.`6` AS PLAN_MES_6, 
	`planes`.`7` AS PLAN_MES_7, 
	`planes`.`8` AS PLAN_MES_8, 
	`planes`.`9` AS PLAN_MES_9, 
	`planes`.`10` AS PLAN_MES_10, 
	`planes`.`11` AS PLAN_MES_11, 
	`planes`.`12` AS PLAN_MES_12,
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
	SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL,	
	`planes`.`EXPLICACION` AS EXPLICACION 
	FROM `planes` 
	LEFT JOIN `reales` ON 
	`planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE 1 
	AND `planes`.`APROBADO`='SI' 
	AND `reales`.`APROBADO`='SI' 
	AND `planes`.`CARGO`='$usuario_cargo'
	GROUP BY `planes`.`ID` ORDER BY `planes`.`ANO` DESC, `planes`.`DESCRIPCION`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['META'][$i]=$fila['META'];
		$datos['UNIDAD'][$i]=$fila['UNIDAD'];
		$datos['ANO'][$i]=$fila['ANO'];
		$datos['PLAN_TOTAL'][$i]=$fila['PLAN_MES_1']+$fila['PLAN_MES_2']+ $fila['PLAN_MES_3']+$fila['PLAN_MES_4']+$fila['PLAN_MES_5']+ $fila['PLAN_MES_6']+$fila['PLAN_MES_7']+$fila['PLAN_MES_8']+ $fila['PLAN_MES_9']+$fila['PLAN_MES_10']+$fila['PLAN_MES_11']+ $fila['PLAN_MES_12'];
		$datos['REAL_TOTAL'][$i]=$fila['TOTAL_REAL'];
		$datos['EXPLICACION'][$i]=$fila['EXPLICACION'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Explicaciones-<?php echo $usuario_nombre;?></title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<?php
		//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if(isset($_GET["NA_Accion"])){
			if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT 
				`planes`.`ID` AS ID,
				`planes`.`DESCRIPCION` AS META,
				`planes`.`CARGO` AS CARGO,
				`planes`.`UNIDAD` AS UNIDAD,
				`planes`.`ANO` AS ANO,
				`planes`.`1` AS PLAN_MES_1, 
				`planes`.`2` AS PLAN_MES_2, 
				`planes`.`3` AS PLAN_MES_3, 
				`planes`.`4` AS PLAN_MES_4, 
				`planes`.`5` AS PLAN_MES_5, 
				`planes`.`6` AS PLAN_MES_6, 
				`planes`.`7` AS PLAN_MES_7, 
				`planes`.`8` AS PLAN_MES_8, 
				`planes`.`9` AS PLAN_MES_9, 
				`planes`.`10` AS PLAN_MES_10, 
				`planes`.`11` AS PLAN_MES_11, 
				`planes`.`12` AS PLAN_MES_12,
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
				SUM(`reales`.`CANTIDAD`) AS TOTAL_REAL,	
				`planes`.`EXPLICACION` AS EXPLICACION 
				FROM `planes` 
				LEFT JOIN `reales` ON 
				`planes`.`ID`=`reales`.`ID_PLAN` 
				WHERE 1 
				AND `planes`.`APROBADO`='SI' 
				AND `reales`.`APROBADO`='SI' 
				AND `planes`.`ID`='$id_a_actualizar'
				GROUP BY `planes`.`ID`";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['META']=$fila['META'];
					$datos_a_actualizar['UNIDAD']=$fila['UNIDAD'];
					$datos_a_actualizar['ANO']=$fila['ANO'];
					$datos_a_actualizar['PLAN_TOTAL']= $fila['PLAN_MES_1']+$fila['PLAN_MES_2']+ $fila['PLAN_MES_3']+$fila['PLAN_MES_4']+ $fila['PLAN_MES_5']+$fila['PLAN_MES_6']+ $fila['PLAN_MES_7']+$fila['PLAN_MES_8']+ $fila['PLAN_MES_9']+$fila['PLAN_MES_10']+ $fila['PLAN_MES_11']+$fila['PLAN_MES_12'];
					$datos_a_actualizar['PLAN_MES_1']=$fila['PLAN_MES_1'];
					$datos_a_actualizar['PLAN_MES_2']=$fila['PLAN_MES_2'];
					$datos_a_actualizar['PLAN_MES_3']=$fila['PLAN_MES_3'];
					$datos_a_actualizar['PLAN_MES_4']=$fila['PLAN_MES_4'];
					$datos_a_actualizar['PLAN_MES_5']=$fila['PLAN_MES_5'];
					$datos_a_actualizar['PLAN_MES_6']=$fila['PLAN_MES_6'];
					$datos_a_actualizar['PLAN_MES_7']=$fila['PLAN_MES_7'];
					$datos_a_actualizar['PLAN_MES_8']=$fila['PLAN_MES_8'];
					$datos_a_actualizar['PLAN_MES_9']=$fila['PLAN_MES_9'];
					$datos_a_actualizar['PLAN_MES_10']=$fila['PLAN_MES_10'];
					$datos_a_actualizar['PLAN_MES_11']=$fila['PLAN_MES_11'];
					$datos_a_actualizar['PLAN_MES_12']=$fila['PLAN_MES_12'];
					$datos_a_actualizar['REAL_TOTAL']=$fila['TOTAL_REAL'];
					$datos_a_actualizar['REAL_MES_1']=($fila['REAL_MES_1']=='')?0:$fila['REAL_MES_1'];
					$datos_a_actualizar['REAL_MES_2']=($fila['REAL_MES_2']=='')?0:$fila['REAL_MES_2'];
					$datos_a_actualizar['REAL_MES_3']=($fila['REAL_MES_3']=='')?0:$fila['REAL_MES_3'];
					$datos_a_actualizar['REAL_MES_4']=($fila['REAL_MES_4']=='')?0:$fila['REAL_MES_4'];
					$datos_a_actualizar['REAL_MES_5']=($fila['REAL_MES_5']=='')?0:$fila['REAL_MES_5'];
					$datos_a_actualizar['REAL_MES_6']=($fila['REAL_MES_6']=='')?0:$fila['REAL_MES_6'];
					$datos_a_actualizar['REAL_MES_7']=($fila['REAL_MES_7']=='')?0:$fila['REAL_MES_7'];
					$datos_a_actualizar['REAL_MES_8']=($fila['REAL_MES_8']=='')?0:$fila['REAL_MES_8'];
					$datos_a_actualizar['REAL_MES_9']=($fila['REAL_MES_9']=='')?0:$fila['REAL_MES_9'];
					$datos_a_actualizar['REAL_MES_10']=($fila['REAL_MES_10']=='')?0:$fila['REAL_MES_10'];
					$datos_a_actualizar['REAL_MES_11']=($fila['REAL_MES_11']=='')?0:$fila['REAL_MES_11'];
					$datos_a_actualizar['REAL_MES_12']=($fila['REAL_MES_12']=='')?0:$fila['REAL_MES_12'];
					$datos_a_actualizar['EXPLICACION']=$fila['EXPLICACION'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar explicación de la variación Plan Vs. Real"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Explicación:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="usuario_explicaciones.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="usuario_explicaciones.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Meta:</span>
						</div>
						<input type="text" disabled class="form-control col mb-2 bg-light" name="descripcion" id="descripcion" placeholder="Descripción de la meta" required autocomplete="off" title="Modifique la descripción de la nueva meta" value="<?php echo $datos_a_actualizar['META'];?>">
					</div>
					<div class="row">
						<div class="col-4">
								<span class="input-group-text w-100 rounded-0">Unidad:</span>
								<input type="text" disabled class="form-control col mb-2 rounded-0 bg-light text-center" name="unidad" id="unidad" placeholder="Unidad de medida" required autocomplete="off" title="unidad de medida para la meta" value="<?php echo $datos_a_actualizar['UNIDAD'];?>">
						</div>
						<div class="col-2">
							<div class="input-group">
								<span class="input-group-text w-100 rounded-0">Año:</span>
								<input type="text" disabled class="form-control col mb-2 rounded-0 bg-light text-center" name="ano_i" id="ano_i" placeholder="Año del ejercicio" required autocomplete="off" title="Año del ejercicio para la meta" value="<?php echo $datos_a_actualizar['ANO'];?>" min="0">
							</div>
						</div>
						<div class="col-2">
								<span class="input-group-text w-100 rounded-0">Plan:</span>
								<input type="text" disabled class="form-control col mb-2 rounded-0 bg-light text-center" name="plan" id="plan" placeholder="Cantidad Plan" required autocomplete="off" title="Cantidad Planificada" value="<?php echo $datos_a_actualizar['PLAN_TOTAL'];?>">
						</div>
						<div class="col-2">
								<span class="input-group-text w-100 rounded-0">Real:</span>
								<input type="text" disabled class="form-control col mb-2 rounded-0 bg-light text-center" name="real" id="real" placeholder="Cantidad Real" required autocomplete="off" title="Cantidad Real Reportada" value="<?php echo $datos_a_actualizar['REAL_TOTAL'];?>">
						</div>
						<div class="col-2">
								<span class="input-group-text w-100 rounded-0">R-P:</span>
								<input type="text" disabled class="form-control col mb-2 rounded-0 bg-light text-center" name="real" id="real" placeholder="Cantidad Real" required autocomplete="off" title="Cantidad Real Reportada" value="<?php echo $datos_a_actualizar['REAL_TOTAL']-$datos_a_actualizar['PLAN_TOTAL'];?>">
						</div>
					</div>
					<div class="input-group">
						<table class="table table-bordered table-hover mb-2 w-100">
							<tr>
								<th colspan="13" class="text-dark bg-light border-dark">Cantidades <b class="text-danger">PUNTUALES</b> planificadas y reales por mes</th>
							</tr>
							<tr>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 16%;">Dato</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Ene</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Feb</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Mar</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Abr</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">May</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Jun</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Jul</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Ago</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Sep</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Oct</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Nov</th>
								<th class="bg-light text-dark border border-dark rounded-0" style="width: 7%;">Dic</th>
							</tr>
							<tr>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><strong>Plan</strong></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_1'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_2'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_3'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_4'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_5'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_6'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_7'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_8'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_9'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_10'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_11'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['PLAN_MES_12'];?></td>
							</tr>
							<tr>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><strong>Real</strong></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_1'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_2'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_3'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_4'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_5'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_6'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_7'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_8'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_9'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_10'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_11'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_12'];?></td>
							</tr>
							<tr>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><strong>R-P=</strong></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_1']-$datos_a_actualizar['PLAN_MES_1'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_2']-$datos_a_actualizar['PLAN_MES_2'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_3']-$datos_a_actualizar['PLAN_MES_3'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_4']-$datos_a_actualizar['PLAN_MES_4'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_5']-$datos_a_actualizar['PLAN_MES_5'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_6']-$datos_a_actualizar['PLAN_MES_6'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_7']-$datos_a_actualizar['PLAN_MES_7'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_8']-$datos_a_actualizar['PLAN_MES_8'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_9']-$datos_a_actualizar['PLAN_MES_9'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_10']-$datos_a_actualizar['PLAN_MES_10'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_11']-$datos_a_actualizar['PLAN_MES_11'];?></td>
								<td class="w-100 p-0 m-0 text-center bg-light text-dark border-dark"><?php echo $datos_a_actualizar['REAL_MES_12']-$datos_a_actualizar['PLAN_MES_12'];?></td>
							</tr>
						</table>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Explicacion de la Variación Plan vs. Real:</span>
						<textarea class="form-control col mb-2" name="explicacion" id="explicacion" required><?php echo $datos_a_actualizar['EXPLICACION']; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#explicacion').summernote({
									placeholder: 'Indique la explicación de la variación',
									tabsize: 1,
									height: 250
								});
							});
						</script>
					</div>
					<div class="m-auto">
						<a href="usuario_explicaciones.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=usuario_explicaciones.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estas son las Explicaciónes para las Metas de tu Cargo Actual:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Año al que corresponde el meta">Año</b></th>
								<th class="align-middle"><b title="Descripción de la meta">Meta</b></th>
								<th class="align-middle"><b title="Unidad de medida de la meta">Unidad</b></th>
								<th class="align-middle"><b title="Cantidad Plan Acumulada para el año">Plan</b></th>
								<th class="align-middle"><b title="Cantidad Real Acumulada para el año">Real</b></th>
								<th class="align-middle"><b title="Explicación para la variación entre Plan y Real">Explicación</b></th>
								<th class="align-middle h5 p-0"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-center"><?php echo $datos['ANO'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['META'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['UNIDAD'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['PLAN_TOTAL'][$i]; ?></td>
								<td class="text-center"><?php echo $datos['REAL_TOTAL'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['EXPLICACION'][$i]; ?></td>
								<td class="text-center h5"><a title="Modificar" href="usuario_explicaciones.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a></td>
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
		<br><br><br><br><br><br><br>
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
<?php
mysqli_close($conexion);
?>