<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//ARMANDO ARRAY DE DIRECTORIO TELEFÓNICO:
	$consulta="SELECT * FROM `usuarios` WHERE `ACTIVO`='SI'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos_usuarios['NOMBRE'][$i]=$fila['APELLIDO'] . ", " . $fila['NOMBRE'];
		$datos_usuarios['CARGO'][$i]=$fila['CARGO'];
		$datos_usuarios['CORREO'][$i]=$fila['CORREO'];
		$datos_usuarios['TELEFONO'][$i]=$fila['TELEFONO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Inicio</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<!-- DataTables Example -->
		<h3 class="mt-1 my-2 py-2 border-bottom text-center"><span class="text-danger fa fa-cog fa-spin"></span> DIRECTORIO TELEFÓNICO DEL PERSONAL ACTIVO:</h3>
		<div class="card mb-5">
			<div class="card-body px-1">
			  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="dataTable">
				  <thead>
					<tr class="text-center">
   			  	      <th class="align-middle">Foto</th>
					  <th class="align-middle">Nombre</th>
					  <th class="align-middle">Correo</th>
					  <th class="align-middle">Telefonos</th>
					  <th class="align-middle">Cargo</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					$i=0;
					while(isset($datos_usuarios['NOMBRE'][$i])){
				  ?>
					<tr>
				  	  <td><img src="fotos_del_personal/<?php echo $datos_usuarios['CORREO'][$i]; ?>.png" width="60px" height="55px" class="rounded" title="<?php echo $datos_usuarios['CARGO'][$i]; ?>"></td>
					  <td><?php echo $datos_usuarios['NOMBRE'][$i]; ?></td>
					  <td><?php echo $datos_usuarios['CORREO'][$i]; ?></td>
					  <td><?php echo $datos_usuarios['TELEFONO'][$i]; ?></td>
					  <td class="text-left"><?php echo $datos_usuarios['CARGO'][$i]; ?></td>
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
		<?php require("php_require/carrusel_01.php") ?>
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
	  $('#dataTable').DataTable();
	});
</script>
<?php
mysqli_close($conexion);
?>