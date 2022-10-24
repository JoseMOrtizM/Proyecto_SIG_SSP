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
	`inv_articulos`.`CATEGORIA` AS CATEGORIA,
	`inv_articulos`.`UNIDAD` AS UNIDAD,
	`inv_operacion`.`CANTIDAD` AS CANTIDAD,
	`inv_operacion`.`FECHA_ENVIO` AS FECHA_ENVIO,
	`inv_operacion`.`CORREO_HACIA` AS CORREO_HACIA,
	`usuarios`.`APELLIDO` AS APELLIDO,
	`usuarios`.`NOMBRE` AS NOMBRE
	FROM `inv_operacion` 
	INNER JOIN `inv_articulos` ON `inv_operacion`.`NOMBRE_ARTICULO`=`inv_articulos`.`NOMBRE_ART` 
	INNER JOIN `usuarios` ON `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` 
	WHERE `inv_operacion`.`CORREO_DESDE`='$usuario_correo' 
	AND `inv_operacion`.`FECHA_RECIBIDO`='0000-00-00' 
	ORDER BY 
	`inv_operacion`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_art[$i]['NOMBRE_ARTICULO']=$fila['NOMBRE_ARTICULO'];
		$inv_art[$i]['CATEGORIA']=$fila['CATEGORIA'];
		$inv_art[$i]['UNIDAD']=$fila['UNIDAD'];
		$inv_art[$i]['CANTIDAD']=$fila['CANTIDAD'];
		$inv_art[$i]['FECHA_ENVIO']=$fila['FECHA_ENVIO'];
		$inv_art[$i]['APELLIDO_NOMBRE_CORREO_HACIA']=$fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO_HACIA'] . ")";
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Artículos en Tránsito</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<?php
			$consulta="SELECT 
				`inv_operacion`.`ID` AS ID
				FROM `inv_operacion` 
				INNER JOIN `inv_articulos` ON `inv_operacion`.`NOMBRE_ARTICULO`=`inv_articulos`.`NOMBRE_ART` 
				INNER JOIN `usuarios` ON `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` 
				WHERE `inv_operacion`.`CORREO_DESDE`='$usuario_correo' 
				AND `inv_operacion`.`FECHA_RECIBIDO`='0000-00-00' 
				ORDER BY 
				`inv_operacion`.`ID`";
			$resultados=mysqli_query($conexion,$consulta);
			$verf=0;
			while(($fila=mysqli_fetch_array($resultados))==true){
				$verf=$verf+1;
			}
			if($verf>0){
				echo "<div class='container-fluid pt-4'><h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Transferencias en Tránsito</h3>";
				echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Quiénes reciben los articulos de esta tabla deben registrarlo en el sistema</p></div>";
			}
		?>
		<div class="mt-3 pt-3">
			<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered">
				<thead>
					<tr><td colspan="6" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Resumen de Artículos en Tránsito para <?php echo $usuario_nombre;?>:</td></tr>
					<tr class="text-center">
						<th class="align-middle border-dark bordered"><b title="Nombre de la Categoría del Artículo">Categoría del artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre de la Unidad del Artículo">Unidad de medida</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre del Artículo">Nombre del artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad de Unidades Transferidas">Cantidad transferida</b></th>
						<th class="align-middle border-dark bordered"><b title="Fecha de envío">Fecha de envío</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre de quién recibe el envío">Transferido hacia</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i=0;
						while(isset($inv_art[$i]['NOMBRE_ARTICULO'])){
					?>
					<tr>
						<td class='text-left border-dark bordered'><?php echo $inv_art[$i]['CATEGORIA']; ?></td>
						<td class='text-left border-dark bordered'><?php echo $inv_art[$i]['UNIDAD']; ?></td>
						<td class='text-left border-dark bordered'><?php echo $inv_art[$i]['NOMBRE_ARTICULO']; ?></td>
						<td class='text-center border-dark bordered'><?php echo $inv_art[$i]['CANTIDAD']; ?></td>
						<td class='text-center border-dark bordered'><?php echo $inv_art[$i]['FECHA_ENVIO']; ?></td>
						<td class='text-left border-dark bordered'><?php echo $inv_art[$i]['APELLIDO_NOMBRE_CORREO_HACIA']; ?></td>
					</tr>
					<?php
							$i=$i+1;
						}
					?>
				</tbody>
			</table>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br>
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