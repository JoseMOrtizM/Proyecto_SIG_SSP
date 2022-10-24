<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
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
		<!-- ORGANIGRAMA -->
		<h3 class="mt-1 my-2 py-2 border-bottom text-center"><span class="text-danger fa fa-cog fa-spin"></span> ESTRUCTURA ORGANIZACIONAL (SSP):</h3>
		<?php require("php_require/organigrama.php"); ?>
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