<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//OBTENIENDO CANDIDATOS DE LA BASE DE DATOS
	$consulta="SELECT * FROM `contactanos`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA GUARDAR LA EDAD Y PODER ORDENAR LUEGO POR DONDE QUERAMOS
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['FECHA_RECIBIDO'][$i]=$fila['FECHA_RECIBIDO'];
		$datos['COMENTARIO'][$i]=$fila['COMENTARIO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Mensajes Recibidos</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Comentarios que se han recibido hasta ahora:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th>Fecha</th>
								<th>Correo</th>
								<th>Mensaje</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['NOMBRE'][$i])){
							?>
							<tr>
								<td><?php echo $datos['FECHA_RECIBIDO'][$i]; ?></td>
								<td><?php echo $datos['CORREO'][$i]; ?></td>
								<td><strong><?php echo $datos['NOMBRE'][$i]; ?>:</strong> <?php echo $datos['COMENTARIO'][$i]; ?></td>
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