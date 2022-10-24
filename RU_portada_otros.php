<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A MODIFICAR UN REGISTRO
		if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$idioma=mysqli_real_escape_string($conexion, $_POST['idioma']);
			$tipo=mysqli_real_escape_string($conexion, $_POST['tipo']);
			$nombre_dato=mysqli_real_escape_string($conexion, $_POST['nombre_dato']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			//PROCESAMIENTO DE IMAGEN
			$verf_foto_size='ok';
			$verf_foto_type='ok';
			if(isset($_FILES['foto']['type'])){
				$foto_type=$_FILES['foto']['type'];
				$foto_size=$_FILES['foto']['size'];
				$nombre_foto=$_FILES['foto']['name'];
				$ruta_temporal=$_FILES['foto']['tmp_name'];
				$ruta_destino=$url_sitio . 'img/' . $nombre_foto;
				//VERIFICANDO TAMAÑO DE LA IMAGEN
				if($foto_size>4000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
				//VERIFICANDO FORMATO DE LA IMAGEN
				if(strpos($foto_type,"png") or strpos($foto_type,"ico")){ $verf_foto_type="ok";}else{$verf_foto_type="error";}
			}
			//CARGANDO DATOS EN BASE DE DATOS
			$consulta="UPDATE `portada` SET 
			`IDIOMA`='$idioma', 
			`TIPO`='$tipo', 
			`NOMBRE`='$nombre_dato', 
			`DESCRIPCION`='$descripcion' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
			//MOVIENDO FOTO AL SITIO
			if(isset($_FILES['foto']['type']) and $verf_foto_size=="ok" and $verf_foto_type=="ok"){
				//VERIFICANDO DUPLICADO Y ELIMINANDO
				if(file_exists($ruta_destino)){
					unlink($ruta_destino);
				}
				//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
				move_uploaded_file($ruta_temporal,$ruta_destino);
				//ACTUALIZANDO EL NOMBRE DE LA FOTO EN LA BASE DE DATOS
				$consulta="UPDATE `portada` SET 
				`FOTO`='$nombre_foto'
				WHERE `ID`='$crud_id'";
				$resultados=mysqli_query($conexion,$consulta);
			}
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `portada` WHERE `TIPO`<>'SERVICIO' ORDER BY `NOMBRE`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['IDIOMA'][$i]=$fila['IDIOMA'];
		$datos['TIPO'][$i]=$fila['TIPO'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['FOTO'][$i]=$fila['FOTO'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Portada-Otros</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<?php
		//SI SE QUIERE CAMBIAR ALGO ENTONCES:
		if(isset($_GET["NA_Accion"])){
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `portada` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$fila=mysqli_fetch_array($resultados);
				//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
				$datos_a_actualizar['ID']=$fila['ID'];
				$datos_a_actualizar['IDIOMA']=$fila['IDIOMA'];
				$datos_a_actualizar['TIPO']=$fila['TIPO'];
				$datos_a_actualizar['NOMBRE']=$fila['NOMBRE'];
				$datos_a_actualizar['DESCRIPCION']=$fila['DESCRIPCION'];
				$datos_a_actualizar['FOTO']=$fila['FOTO'];
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar Dato de la Portada"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Portada:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="RU_portada_otros.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="RU_portada_otros.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Idioma:</span>
						</div>
						<select name="idioma" id="idioma" class="form-control mb-2 text-center" required title="Elija el tipo de información que desea modificar" autocomplete="off">
							<option><?php echo $datos_a_actualizar['IDIOMA']; ?></option>
							<option disabled>------</option>
							<?php 
								$consulta="SELECT `IDIOMA` FROM `portada` GROUP BY `IDIOMA` ORDER BY `IDIOMA`";
								$resultados=mysqli_query($conexion,$consulta);
								while(($fila=mysqli_fetch_array($resultados))==true){
									echo "<option>" . $fila['IDIOMA'] . "</option>";
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Tipo:</span>
						</div>
						<select name="tipo" id="tipo" class="form-control mb-2 text-center" required title="Elija el tipo de información que desea modificar" autocomplete="off">
							<option><?php echo $datos_a_actualizar['TIPO']; ?></option>
							<option disabled>------</option>
							<?php 
								$consulta="SELECT `TIPO` FROM `portada` GROUP BY `TIPO` ORDER BY `TIPO`";
								$resultados=mysqli_query($conexion,$consulta);
								while(($fila=mysqli_fetch_array($resultados))==true){
									echo "<option>" . $fila['TIPO'] . "</option>";
								}
							?>
						</select>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Nombre:</span>
						<textarea class="form-control col mb-2" name="nombre_dato" id="nombre_dato" required><?php echo $datos_a_actualizar['NOMBRE'] ?></textarea>
						<script>
							$(document).ready(function() {
								$('#nombre_dato').summernote({
									placeholder: 'Indique el nombre del dato a modificar',
									tabsize: 1,
									height: 100								
								});
							});
						</script>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100" title='Si desea actualizar las personas de contacto, separar los correos electronicos de las mismas con una, y sin espacios'>Descripción:</span>
						<textarea class="form-control col mb-2" name="descripcion" id="descripcion" required placeholder="separar los correos electronicos de las personas contacto con una coma y sin espacios" title="separar los correos electronicos de las personas contacto con una coma y sin espacios"><?php echo $datos_a_actualizar['DESCRIPCION'] ?></textarea>
						<?php 
							if($datos_a_actualizar['TIPO']<>'PERSONAS DE CONTACTO'){
						?>
							<script>
								$(document).ready(function() {
									$('#descripcion').summernote({
										placeholder: 'Indique la descripción del dato a modificar',
										tabsize: 1,
										height: 250								
									});
								});
							</script>
						<?php 
							}
						?>
					</div>
					<div class="row">
						<div class="col-md-2">
							<img src="img/<?php echo $datos_a_actualizar['FOTO']; ?>" class="rounded border border-danger" style="height: 82px; width: 95px;">
						</div>
						<div class="col-md-10">
							<div class="text-center bg">
								<span class="input-group-text mb-1">Actualize la Foto (en formato png o ico y máximo 4 MegaBytes)</span>
							</div>
							<input type='file' name='foto' id='foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte la Foto (en formato .png o .ico y máximo 4 MegaBytes)">
						</div>
					</div>
					<div class="m-auto">
						<a href="RU_portada_otros.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE REALIZAR CUALQUIER OTRA OPERACIÓN ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=RU_portada_otros.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Datos Adicionales del Portal:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover border-dark bordered TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle border-dark bordered"><b title="Tipo de Dato e Idioma">Tipo / <br>Idioma</b></th>
								<th class="align-middle border-dark bordered w-50"><b title="Descripción del Dato">Descripción</b></th>
								<th class="align-middle border-dark bordered"><b title="Foto del Dato">Foto</b></th>
								<th class="align-middle border-dark bordered"><b class="text-dark fa fa-arrow-circle-down"></b></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos['TIPO'][$i]; ?><br>/<br><?php echo $datos['IDIOMA'][$i]; ?></td>
								<td class="text-left"><?php echo $datos['DESCRIPCION'][$i]; ?></td>
								<td class="text-center"><img src="img/<?php echo $datos['FOTO'][$i]; ?>" width="100%" class="rounded"></td>
								<td class="text-center h5"><a title="Modificar" href="RU_portada_otros.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a></td>
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