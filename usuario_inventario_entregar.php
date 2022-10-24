<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	require("php_require/paleta_de_colores.php");
	//VERIFICANDO ACCION DE TRANSFERIR:
	if(isset($_POST["TRANSFERIR"])){
		if($_POST["TRANSFERIR"]=='SI'){
			$nombre_articulo=mysqli_real_escape_string($conexion, $_POST['nombre_articulo']);
			$cantidad_a_enviar=mysqli_real_escape_string($conexion, $_POST['cantidad_a_enviar']);
			$correo_hacia=mysqli_real_escape_string($conexion, $_POST['correo_hacia']);
			$fecha_envio=date('Y-m-d');
			$correo_desde=$usuario_correo;
			$consulta="INSERT INTO `inv_operacion` (`NOMBRE_ARTICULO`, `CORREO_DESDE`, `CORREO_HACIA`, `CANTIDAD`, `FECHA_ENVIO`, `FECHA_RECIBIDO`) VALUES ('$nombre_articulo','$correo_desde','$correo_hacia','$cantidad_a_enviar','$fecha_envio','0000-00-00')";
			$resultados=mysqli_query($conexion,$consulta);
			$verificar_envio=true;
		}
	}
	//OBTENEINDO DATOS PARA LAS TABLAS
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
	AND `usuarios`.`CORREO`='" . $usuario_correo . "'
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
	<title>SIG-SSP: Entregar Artículo</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<?php 
			if(isset($_GET['NA_Accion'])){
				if($_GET['NA_Accion']=='entregar'){
					//AQUI VA EL FORMULARIO DE TRANSFERENCIA
					$id_articulo=$_GET['id_art'];
					//OBTENIENDO INFORMACIÓN DEL ARTICULO
					$consulta="SELECT 
					`inv_operacion`.`NOMBRE_ARTICULO` AS NOMBRE_ARTICULO,
					`inv_articulos`.`CATEGORIA` AS CATEGORIA,
					`inv_articulos`.`UNIDAD` AS UNIDAD,
					`inv_articulos`.`INVENTARIO_MINIMO` AS INVENTARIO_MINIMO,
					SUM(case when `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_RECIBIDA,
					SUM(case when `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` then `inv_operacion`.`CANTIDAD` end) AS CANTIDAD_ENTREGADA
					FROM `inv_operacion` 
					INNER JOIN `usuarios` ON (`inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` OR `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO`)
					INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO`
					INNER JOIN `inv_articulos` ON `inv_articulos`.`NOMBRE_ART`=`inv_operacion`.`NOMBRE_ARTICULO`
					WHERE 1 
					AND `usuarios`.`CORREO`='" . $usuario_correo . "'
					AND `inv_articulos`.`ID`='" . $id_articulo . "'
					GROUP BY 
					`inv_operacion`.`NOMBRE_ARTICULO` 
					ORDER BY 
					`inv_operacion`.`NOMBRE_ARTICULO`";
					$resultados=mysqli_query($conexion,$consulta);
					$fila=mysqli_fetch_array($resultados);
					$art_transf['NOMBRE_ARTICULO']=$fila['NOMBRE_ARTICULO'];
					$art_transf['CATEGORIA']=$fila['CATEGORIA'];
					$art_transf['UNIDAD']=$fila['UNIDAD'];
					$art_transf['INVENTARIO_MINIMO']=$fila['INVENTARIO_MINIMO'];
					$art_transf['EN_EXISTENCIA']=$fila['CANTIDAD_RECIBIDA']-$fila['CANTIDAD_ENTREGADA'];
		?>
		<div class="col-md-12 col-lg-9 mx-auto">
			<div class="row mt-4 align-items-center">
				<div class="col-md-9 mb-1">
					<h3 class="text-center text-md-left" title="Registrar entrega de Artículo"><span class="text-danger fa fa-cog fa-spin "></span> Registrar Entrega:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1">
					<a href="usuario_inventario_entregar.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="usuario_inventario_entregar.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="TRANSFERIR" id="TRANSFERIR" value="SI">
				<input type="hidden" name="nombre_articulo" id="nombre_articulo" value="<?php echo $art_transf['NOMBRE_ARTICULO'];?>">
				<div class="row">
					<div class="col-md-5">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Categoría:</span>
							<input type="text" disabled class="form-control col mb-2 rounded-0 text-left" name="categoria" id="categoria" placeholder="Categoria del Artículo" required autocomplete="off" title="Categoria del Artículo" value="<?php echo $art_transf['CATEGORIA'];?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Unidad:</span>
							<input type="text" disabled class="form-control col mb-2 rounded-0 text-left" name="unidad" id="unidad" placeholder="Unidad de medida" required autocomplete="off" title="unidad de medida para el Artículo" value="<?php echo $art_transf['UNIDAD'];?>">
						</div>
					</div>
					<div class="col-md-2">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Mínimo:</span>
							<input type="text" disabled class="form-control col mb-2 rounded-0 text-center" name="minimo" id="minimo" placeholder="Inventaio mínimo del Artículo" required autocomplete="off" title="Inventaio mínimo del Artículo" value="<?php echo $art_transf['INVENTARIO_MINIMO'];?>">
						</div>
					</div>
					<div class="col-md-2">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Existecia:</span>
							<input type="text" disabled class="form-control col mb-2 rounded-0 text-center" name="existencia" id="existencia" placeholder="Unidades en existencia para el Artículo" required autocomplete="off" title="Unidades en existencia para el Artículo" value="<?php echo $art_transf['EN_EXISTENCIA'];?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Artículo:</span>
							<input type="text" disabled class="form-control col mb-2 rounded-0" name="articulo" id="articulo" placeholder="Nombre del Artículo" required autocomplete="off" title="Nombre del Artículo" value="<?php echo $art_transf['NOMBRE_ARTICULO'];?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Quién recibe:</span>
							<select class="form-control col mb-2 rounded-0 bg-light text-center" name="correo_hacia" id="correo_hacia" required autocomplete="off" title="Nombre de quién recibe">
								<option></option>
								<?php
									$consulta="SELECT `NOMBRE`, `APELLIDO`, `CORREO` FROM `usuarios` WHERE `CORREO`<>'$usuario_correo' AND `ACTIVO`='SI' GROUP BY `CORREO` ORDER BY `APELLIDO`, `NOMBRE`";
									$resultados=mysqli_query($conexion,$consulta);
									while(($fila=mysqli_fetch_array($resultados))==true){
										echo "<option value='" . $fila['CORREO'] . "'>" . $fila['APELLIDO'] . ", " . $fila['NOMBRE'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group">
							<span class="input-group-text w-100 rounded-0">Cantidad a Enviar:</span>
							<input type="number" class="form-control col mb-2 rounded-0 bg-light text-center" name="cantidad_a_enviar" id="cantidad_a_enviar" placeholder="Cantidad" required autocomplete="off" title="Cantidad a enviar" min="0" max="<?php echo $art_transf['EN_EXISTENCIA']; ?>">
						</div>
					</div>
				</div>
				<div class="m-auto">
					<a href="usuario_inventario_entregar.php" class="btn btn-danger text-light mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Registrar Transferencia &raquo;" class="btn btn-danger mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br><br><br>
		</div>			
		<?php
				}else{
					//SI SE QUIERE ENVIAR LA INFORMACIÓN ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL --- ENTONCES:
		?>
					<META HTTP-EQUIV="Refresh" CONTENT="0; URL=usuario_inventario_entregar.php">
		<?php
				}
			}else{
		?>
		<div class="mt-3 pt-3">
			<?php 
				if(isset($verificar_envio)){
					if($verificar_envio){
						echo "<div class='container-fluid'><h4 class='bg-success text-center text-dark py-2 rounded'>Se registró el envio de $cantidad_a_enviar $nombre_articulo a $correo_hacia (pendiente por confirmar)</h4></div>";
						echo "<div class='container-fluid'><h4 class='bg-warning text-center text-dark py-2 rounded'>IMPORTANTE: el sistema sólo actualiza los inventarios luego de confirmadas las transferncias por quién recibe</h4></div>";
					}
				}
			?>
			<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered mr-auto">
				<thead>
					<tr><td colspan="8" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Resumen de Inventario por Artículo para <?php echo $usuario_nombre;?>:</td></tr>
					<tr class="text-center">
						<th class="align-middle border-dark bordered"><b title="Nombre de la Categoría del Artículo">Categoría del Artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre del Artículo">Nombre del Artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre de la Unidad del Artículo">Unidad</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad mínima que debe existir en el inventario">Inventario mínimo</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad disponible en el inventario">Cantidad disponible</b></th>
						<th class="align-middle border-dark bordered">Movimiento<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
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
								";
								echo "<td class='text-center border-dark bordered'><a title='Insertar' href='usuario_inventario_entregar.php?NA_Accion=entregar&id_art=" . $fila_i['ID'] . "' class='h3 btn btn-transparent text-primary fa fa-share-square-o'> Enviar</a></td>";
								echo "</tr>";
							$i=$i+1;
						}
					?>
				</tbody>
			</table>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br>
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