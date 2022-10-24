<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	require("php_require/paleta_de_colores.php");
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
	AND `inv_operacion`.`FECHA_RECIBIDO`<>'0000-00-00' 
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
	<title>SIG-SSP: Inventario-<?php echo $usuario_nombre;?></title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<div class="mt-3 pt-3">
			<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered">
				<thead>
					<tr><td colspan="8" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Resumen de Inventario por Artículo para <?php echo $usuario_nombre;?>:</td></tr>
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
					AND `usuarios`.`CORREO`='" . $usuario_correo . "'
					GROUP BY 
					`inv_operacion`.`ID` 
					ORDER BY 
					`inv_operacion`.`ID`";
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
		<br><br><br><br><br><br><br><br><br><br><br>
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