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
		<!-- PRESENTACION -->
		<h3 class="mt-1 my-2 py-2 border-bottom text-center"><span class="text-danger fa fa-cog fa-spin"></span> SISTEMA INTEGRAL DE GESTIÓN (SIG-SSP):</h3>
		<p>La Gerencia de Planificación Presupuesto y Gestión en conjunto con AIT pone a su disposición una herramienta web denominada "SIG-SSP" acrónimo de <strong>Sistema Integral de Gestión</strong> para la Empresa Mixta de Servicios <strong>Sismica Servicios Petroleros</strong></p>
		<p>Este sistema, permite consultar los datos oficiales de SISMICA Servicios Petroleros S.A. Mejora el flujo de trabajo para los usuarios, aumentando la productividad y optimizando el manejo de los datos, mediante la generación de reportes de Gestión por cada Departamiento de la Compañía, además agiliza la toma de decisiones en las actividades diarias.</p>
		<p>SIG-SSP cuenta con módulos independientes para cada Año, Gerencia, Departamento, Objetivo o Meta, Cargo y Empleado; permitiendo hacer Seguimiento a la ejecución de Planes por Departamento o a nivel Global dentro de la Empresa.</p>
		<p>Asimismo SIG-SSP permite la disposición de Data de altísima confiabilidad, y de disponibilidad inmediata.</p>
		<p class="pb-5">Si deseas <b><a href="instructivo.php">ver las instrucciones de uso</a></b> de este sitio web, puedes acceder a ellas haciendo <b><a href="instructivo.php">click aquí</a></b></p>
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