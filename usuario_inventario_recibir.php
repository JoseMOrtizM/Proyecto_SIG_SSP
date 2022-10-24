<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	require("php_require/paleta_de_colores.php");
	//VERIFICANDO ACCION DE CONFIRMAR TRANSFERENCIA:
	if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=='recibir'){
			$id_operacion=mysqli_real_escape_string($conexion, $_GET['id_operacion']);
			$fecha_recibido=date('Y-m-d');
			$consulta="UPDATE `inv_operacion` SET `FECHA_RECIBIDO`='$fecha_recibido' WHERE `ID`='$id_operacion'";
			$resultados=mysqli_query($conexion,$consulta);
			$verificar_recibido=true;
		}
	}
	//OBTENEINDO DATOS PARA LAS TABLAS
	//RESUMEN DE INVENTARIO POR ARTICULO
	$consulta="SELECT 
	`inv_operacion`.`ID` AS ID,
	`inv_operacion`.`NOMBRE_ARTICULO` AS NOMBRE_ARTICULO,
	`inv_articulos`.`CATEGORIA` AS CATEGORIA,
	`inv_articulos`.`UNIDAD` AS UNIDAD,
	`inv_operacion`.`CANTIDAD` AS CANTIDAD,
	`inv_operacion`.`FECHA_ENVIO` AS FECHA_ENVIO,
	`inv_operacion`.`CORREO_DESDE` AS CORREO_DESDE,
	`usuarios`.`APELLIDO` AS APELLIDO,
	`usuarios`.`NOMBRE` AS NOMBRE
	FROM `inv_operacion` 
	INNER JOIN `inv_articulos` ON `inv_operacion`.`NOMBRE_ARTICULO`=`inv_articulos`.`NOMBRE_ART` 
	INNER JOIN `usuarios` ON `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` 
	WHERE `inv_operacion`.`CORREO_HACIA`='$usuario_correo' 
	AND `inv_operacion`.`FECHA_RECIBIDO`='0000-00-00' 
	ORDER BY 
	`inv_operacion`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$inv_art[$i]['ID_OPERACION']=$fila['ID'];
		$inv_art[$i]['NOMBRE_ARTICULO']=$fila['NOMBRE_ARTICULO'];
		$inv_art[$i]['CATEGORIA']=$fila['CATEGORIA'];
		$inv_art[$i]['UNIDAD']=$fila['UNIDAD'];
		$inv_art[$i]['CANTIDAD']=$fila['CANTIDAD'];
		$inv_art[$i]['FECHA_ENVIO']=$fila['FECHA_ENVIO'];
		$inv_art[$i]['APELLIDO_NOMBRE_CORREO_DESDE']=$fila['APELLIDO'] . ", " . $fila['NOMBRE'] . " (" . $fila['CORREO_DESDE'] . ")";
		$i=$i+1;
	}
	$hay_pendientes=($i>0)?true:false;
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Confirmar envios</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<?php
			if($hay_pendientes){
				echo "<div class='container-fluid pt-4'><h3 class='text-center bg-warning rounded m-auto p-2'>Tienes Transferencias pendientes por Confirmar</h3>";
				echo "<p class='text-center m-auto p-2'><b>IMPORTANTE:</b> Si has recibido los siguientes articulos, debes registrarlo en el sistema</p></div>";
			}else{
				echo "<div class='container-fluid pt-4'><h3 class='text-center bg-success rounded m-auto p-2'>No Tienes recepciones por Confirmar</h3></div>";
			}
		?>
		<div class="mt-3 pt-3">
			<?php 
				if(isset($verificar_recibido)){
					if($verificar_recibido){
						echo "<div class='container-fluid'><h4 class='bg-success text-center text-dark py-2 rounded'>Se registró confirmación</h4></div>";
					}
				}
			?>
			<table class="table table-responsive table-bordered table-hover TablaDinamica border-dark bordered">
				<thead>
					<tr><td colspan="7" class="mt-1 mt-2 py-2 text-center border-dark bg-dark text-light border h3">Resumen de Artículos en Tránsito para <?php echo $usuario_nombre;?>:</td></tr>
					<tr class="text-center">
						<th class="align-middle border-dark bordered"><b title="Nombre de la Categoría del Artículo">Categoría del artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre de la Unidad del Artículo">Unidad de medida</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre del Artículo">Nombre del artículo</b></th>
						<th class="align-middle border-dark bordered"><b title="Cantidad de Unidades Transferidas">Cantidad transferida</b></th>
						<th class="align-middle border-dark bordered"><b title="Fecha de envío">Fecha de envío</b></th>
						<th class="align-middle border-dark bordered"><b title="Nombre de quién recibe el envío">Transferido desde</b></th>
						<th class="align-middle border-dark bordered">Movimiento<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
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
						<td class='text-left border-dark bordered'><?php echo $inv_art[$i]['APELLIDO_NOMBRE_CORREO_DESDE']; ?></td>
						<td class='text-left border-dark bordered'><a title='Confirmar Recepción' href='usuario_inventario_recibir.php?NA_Accion=recibir&id_operacion=<?php echo $inv_art[$i]['ID_OPERACION']; ?>' class='h3 btn btn-transparent text-primary fa fa-share-square-o'> Recibir</a></td>
					</tr>
					<?php
							$i=$i+1;
						}
					?>
				</tbody>
			</table>
		</div>
		<br><br><br><br><br><br><br>
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