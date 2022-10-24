<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//OBTENIENDO CANDIDATOS DE LA BASE DE DATOS
	$consulta="SELECT * FROM `postulaciones`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA GUARDAR LA EDAD Y PODER ORDENAR LUEGO POR DONDE QUERAMOS
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['PROFESION'][$i]=$fila['PROFESION'];
		$datos['ANOS_EXPERIENCIA'][$i]=$fila['ANOS_EXPERIENCIA'];
		$datos['INGLES'][$i]=$fila['INGLES'];
		$datos['SEXO'][$i]=$fila['SEXO'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$fecha_nac_partida=explode("-",$datos['FECHA_NACIMIENTO'][$i]);
		$fecha_hoy_partida=explode("-",date("Y-m-d"));
		$edad=($fecha_hoy_partida[0]-$fecha_nac_partida[0])+(($fecha_hoy_partida[1]-$fecha_nac_partida[1])/12)+(($fecha_hoy_partida[2]-$fecha_nac_partida[2])/30);
		$datos['EDAD'][$i]=floor($edad);
		$datos['CARGO_QUE_ASPIRA'][$i]=$fila['CARGO_QUE_ASPIRA'];
		$datos['SALARIO_QUE_ASPIRA'][$i]=$fila['SALARIO_QUE_ASPIRA'];
		$datos['EXPERIENCIA_PREVIA'][$i]=$fila['EXPERIENCIA_PREVIA'];
		$datos['CURRICULUM'][$i]=$fila['CURRICULUM'];
		$datos['FECHA_ENVIO'][$i]=$fila['FECHA_ENVIO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Candidatos</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Candidatos que se han postulado hasta ahora:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle">Nombre</th>
								<th class="align-middle">Sexo</th>
								<th class="align-middle">Edad</th>
								<th class="align-middle">Experiencia</th>
								<th class="align-middle">Profesión</th>
								<th class="align-middle">Enviado el:</th>
								<th class="align-middle">Detalles<br><b class="text-dark fa fa-arrow-circle-down"></b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['NOMBRE'][$i])){
							?>
							<tr>
								<td><?php echo $datos['APELLIDO'][$i] . ", " . $datos['NOMBRE'][$i]; ?></td>
								<td><?php echo $datos['SEXO'][$i]; ?></td>
								<td><?php echo $datos['EDAD'][$i]; ?></td>
								<td><?php echo $datos['ANOS_EXPERIENCIA'][$i]; ?></td>
								<td><?php echo $datos['PROFESION'][$i]; ?></td>
								<td><?php echo $datos['FECHA_ENVIO'][$i]; ?></td>
								<td><a data-toggle='collapse' data-target='#Example<?php echo $i; ?>' aria-controls='Example<?php echo $i; ?>' aria-expanded='false' aria-label='Toggle navigation' class='text-danger fa fa-plus-square-o link_para_mostrar' href='#Example$i'> Detalle</a></td>
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
			$i=0;
			while(isset($datos['NOMBRE'][$i])){
		?>
		<div class="collapse navbar-collapse my-3" id="Example<?php echo $i; ?>">
			<table class="table table-hover text-justify m-auto">
				<tr>
					<th colspan="2" class="text-center bg-dark text-light h4">Detalles de: <strong><?php echo $datos['APELLIDO'][$i] . ", " . $datos['NOMBRE'][$i]; ?></strong></th>
				</tr>
				<tr>
					<td class="text-left"><strong>Cargo que Aspira:</strong></td>
					<td><?php echo $datos['CARGO_QUE_ASPIRA'][$i]; ?></td>
				</tr>
				<tr>
					<td class="text-left"><strong>Salario que Aspira:</strong></td>
					<td><?php echo $datos['SALARIO_QUE_ASPIRA'][$i]; ?></td>
				</tr>
				<tr>
					<td class="text-left"><strong>Experiencia Previa:</strong></td>
					<td><?php echo $datos['EXPERIENCIA_PREVIA'][$i]; ?></td>
				</tr>
				<tr>
					<td class="text-left"><strong>Nivel de Ingles:</strong></td>
					<td><?php echo $datos['INGLES'][$i]; ?></td>
				</tr>
				<tr>
					<td class="text-left"><strong>Correo:</strong></td>
					<td><?php echo $datos['CORREO'][$i]; ?></td>
				</tr>
				<tr>
					<td class="text-left"><strong>Telefono:</strong></td>
					<td><?php echo $datos['TELEFONO'][$i]; ?></td>
				</tr>
				<tr>
					<td class="text-left"><strong>Ver Curriculum:</strong></td>
					<td><a href="curriculum/<?php 
						if($datos['CURRICULUM'][$i]==""){ 
							echo "no_registrado";
						}else{
							echo $datos['CURRICULUM'][$i]; 
						}
						?>" target="_blank" onclick="window.open(this.href, this.target, 'width=800,height=600'); return false;">Ver Curriculum</a></td>
				</tr>
			</table>
		</div>
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
	  $('#dataTable01').DataTable();
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