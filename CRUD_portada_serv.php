<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$idioma=mysqli_real_escape_string($conexion, $_POST['idioma']);
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$descripcion_corta=mysqli_real_escape_string($conexion, $_POST['descripcion_corta']);
			//PROCESAMIENTO DE IMAGEN 1
				$foto_type=$_FILES['foto']['type'];
				$foto_size=$_FILES['foto']['size'];
				$nombre_foto=$_FILES['foto']['name'];
				$ruta_temporal=$_FILES['foto']['tmp_name'];
				$ruta_destino=$url_sitio . 'img/' . $nombre_foto;
				//VERIFICANDO TAMAÑO DE LA IMAGEN
				if($foto_size>4000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
				//VERIFICANDO FORMATO DE LA IMAGEN
				if(strpos($foto_type,"png")){ $verf_foto_type="ok";}else{$verf_foto_type="error";}
			//PROCESAMIENTO DE IMAGEN 2
				$foto_type2=$_FILES['foto_carrusel']['type'];
				$foto_size2=$_FILES['foto_carrusel']['size'];
				$nombre_foto2=$_FILES['foto_carrusel']['name'];
				$ruta_temporal2=$_FILES['foto_carrusel']['tmp_name'];
				$ruta_destino2=$url_sitio . 'img/' . $nombre_foto2;
				//VERIFICANDO TAMAÑO DE LA IMAGEN
				if($foto_size2>4000000){$verf_foto_size2="error";}else{$verf_foto_size2="ok";}
				//VERIFICANDO FORMATO DE LA IMAGEN
				if(strpos($foto_type2,"png")){ $verf_foto_type2="ok";}else{$verf_foto_type2="error";}
			//INSERTANDO
			$consulta="INSERT INTO `portada` (`IDIOMA`, `TIPO`, `NOMBRE`, `DESCRIPCION`, `FOTO`, `DESCRIPCION_CORTA`, `FOTO_CARRUSEL`) VALUES ('$idioma', 'SERVICIO','$nombre','$descripcion','$nombre_foto','$descripcion_corta', '$nombre_foto2')";
			$resultados=mysqli_query($conexion,$consulta);
			//MOVIENDO FOTOS
			if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
				move_uploaded_file($ruta_temporal,$ruta_destino);
			}
			if($verf_foto_size2=='ok' and $verf_foto_type2=='ok'){
				move_uploaded_file($ruta_temporal2,$ruta_destino2);
			}
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$idioma=mysqli_real_escape_string($conexion, $_POST['idioma']);
			$nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);
			$descripcion=mysqli_real_escape_string($conexion, $_POST['descripcion']);
			$descripcion_corta=mysqli_real_escape_string($conexion, $_POST['descripcion_corta']);
			//PROCESAMIENTO DE IMAGEN 1
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
					if(strpos($foto_type,"png")){ $verf_foto_type="ok";}else{$verf_foto_type="error";}
				}
			//PROCESAMIENTO DE IMAGEN 2
				$verf_foto_size2='ok';
				$verf_foto_type2='ok';
				if(isset($_FILES['foto_carrusel']['type'])){
					$foto_type2=$_FILES['foto_carrusel']['type'];
					$foto_size2=$_FILES['foto_carrusel']['size'];
					$nombre_foto2=$_FILES['foto_carrusel']['name'];
					$ruta_temporal2=$_FILES['foto_carrusel']['tmp_name'];
					$ruta_destino2=$url_sitio . 'img/' . $nombre_foto2;
					//VERIFICANDO TAMAÑO DE LA IMAGEN
					if($foto_size2>4000000){$verf_foto_size2="error";}else{$verf_foto_size2="ok";}
					//VERIFICANDO FORMATO DE LA IMAGEN
					if(strpos($foto_type2,"png")){ $verf_foto_type2="ok";}else{$verf_foto_type2="error";}
				}
			//ACTUALIZANDO DATOS EN BASE DE DATOS
			$consulta="UPDATE `portada` SET 
			`IDIOMA`='$idioma',
			`NOMBRE`='$nombre',
			`DESCRIPCION`='$descripcion',
			`DESCRIPCION_CORTA`='$descripcion_corta' 
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
			//MOVIENDO FOTOS
			if(isset($_FILES['foto']['type'])){
				if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
					//VERIFICANDO DUPLICADO Y ELIMINANDO
					if(file_exists($ruta_destino)){
						unlink($ruta_destino);
					}
					move_uploaded_file($ruta_temporal,$ruta_destino);
					//ACTUALIZANDO NOMBRE DE LA FOTO
					$consulta="UPDATE `portada` SET 
					`FOTO`='$nombre_foto' 
					WHERE `ID`='$crud_id'";
					$resultados=mysqli_query($conexion,$consulta);
				}
			}
			if(isset($_FILES['foto_carrusel']['type'])){
				if($verf_foto_size2=='ok' and $verf_foto_type2=='ok'){
					//VERIFICANDO DUPLICADO Y ELIMINANDO
					if(file_exists($ruta_destino2)){
						unlink($ruta_destino2);
					}
					move_uploaded_file($ruta_temporal2,$ruta_destino2);
					//ACTUALIZANDO NOMBRE DE LA FOTO
					$consulta="UPDATE `portada` SET 
					`FOTO_CARRUSEL`='$nombre_foto2' 
					WHERE `ID`='$crud_id'";
					$resultados=mysqli_query($conexion,$consulta);
				}
			}
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `portada` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `portada` WHERE `TIPO`='SERVICIO' ORDER BY `NOMBRE`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];
		$datos['IDIOMA'][$i]=$fila['IDIOMA'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['FOTO'][$i]=$fila['FOTO'];
		$datos['DESCRIPCION_CORTA'][$i]=$fila['DESCRIPCION_CORTA'];
		$datos['FOTO_CARRUSEL'][$i]=$fila['FOTO_CARRUSEL'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Portada-Serv</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section class="container-fluid px-5 mt-2 mb-5">
		<?php
		//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if(isset($_GET["NA_Accion"])){
			if($_GET["NA_Accion"]=="insertar"){
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Insertar nuevo Servicio en el Portal"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Servicio:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_portada_serv.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_portada_serv.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Idioma:</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="idioma" id="idioma" required autocomplete="off" title="Indique El Idioma">
							<option></option>
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
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="introduzca el nombre del nuevo Servicio" required autocomplete="off" title="introduzca el nombre del nuevo Servicio">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Descripción:</span>
						<textarea class="form-control col mb-2" name="descripcion" id="descripcion" required></textarea>
						<script>
							$(document).ready(function() {
								$('#descripcion').summernote({
									placeholder: 'Indique la descripción del servicio',
									tabsize: 1,
									height: 250	
								});
							});
						</script>
					</div>
					<div class="text-center bg">
						<span class="input-group-text mb-1">Adjunte su Foto (en formato png y máximo 4 MegaBytes)</span>
					</div>
					<input type='file' name='foto' id='foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" required title="Adjunte su Foto (en formato png y máximo 4 MegaBytes)">
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Descripción Corta:</span>
						<textarea class="form-control col mb-2" name="descripcion_corta" id="descripcion_corta" required></textarea>
						<script>
							$(document).ready(function() {
								$('#descripcion_corta').summernote({
									placeholder: 'Indique la descripción corta del servicio',
									tabsize: 1,
									height: 150					
								});
							});
						</script>
					</div>
					<div class="text-center bg">
						<span class="input-group-text mb-1">Adjunte su Foto de Carrusel (en formato png y máximo 4 MegaBytes)</span>
					</div>
					<input type='file' name='foto_carrusel' id='foto_carrusel' class="mb-2 w-100 bg-light text-dark p-2 rounded" required title="Adjunte su Foto (en formato png y máximo 4 MegaBytes)">
					<div class="m-auto">
						<a href="CRUD_portada_serv.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `portada` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['IDIOMA']=$fila['IDIOMA'];
					$datos_a_actualizar['NOMBRE']=$fila['NOMBRE'];
					$datos_a_actualizar['DESCRIPCION']=$fila['DESCRIPCION'];
					$datos_a_actualizar['FOTO']=$fila['FOTO'];
					$datos_a_actualizar['DESCRIPCION_CORTA']=$fila['DESCRIPCION_CORTA'];
					$datos_a_actualizar['FOTO_CARRUSEL']=$fila['FOTO_CARRUSEL'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar Servicio"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Servicio:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_portada_serv.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_portada_serv.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Idioma:</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="idioma" id="idioma" required autocomplete="off" title="Indique El Idioma">
							<option><?php echo $datos_a_actualizar['IDIOMA']; ?></option>
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
							<span class="input-group-text w-100">Nombre:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="nombre" id="nombre" placeholder="Modifique el nombre del nuevo Servicio" required autocomplete="off" title="Modifique el nombre del nuevo Servicio" value="<?php echo $datos_a_actualizar['NOMBRE']; ?>">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Descripción:</span>
						<textarea class="form-control col mb-2" name="descripcion" id="descripcion" required><?php echo $datos_a_actualizar['DESCRIPCION']; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#descripcion').summernote({
									placeholder: 'Indique la descripción del servicio',
									tabsize: 1,
									height: 250	
								});
							});
						</script>
					</div>
					<div class="row">
						<div class="col-md-2">
							<img src="img/<?php echo $datos_a_actualizar['FOTO']; ?>" class="rounded border border-danger" style="height: 82px; width: 95px;">
						</div>
						<div class="col-md-10">
							<div class="text-center bg">
								<span class="input-group-text mb-1">Actualize la Foto (en formato png y máximo 4 MegaBytes)</span>
							</div>
							<input type='file' name='foto' id='foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte la Foto (en formato .png y máximo 4 MegaBytes)">
						</div>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Descripción Corta:</span>
						<textarea class="form-control col mb-2" name="descripcion_corta" id="descripcion_corta" required><?php echo $datos_a_actualizar['DESCRIPCION_CORTA']; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#descripcion_corta').summernote({
									placeholder: 'Indique la descripción corta del servicio',
									tabsize: 1,
									height: 150					
								});
							});
						</script>
					</div>
					<div class="row">
						<div class="col-md-2">
							<img src="img/<?php echo $datos_a_actualizar['FOTO_CARRUSEL']; ?>" class="rounded border border-danger" style="height: 82px; width: 95px;">
						</div>
						<div class="col-md-10">
							<div class="text-center bg">
								<span class="input-group-text mb-1">Actualize la Foto del Carrusel (en formato png y máximo 4 MegaBytes)</span>
							</div>
							<input type='file' name='foto_carrusel' id='foto_carrusel' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte la Foto (en formato .png y máximo 4 MegaBytes)">
						</div>
					</div>
					<div class="m-auto">
						<a href="CRUD_portada_serv.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_portada_serv.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Servicios existentes en el sitio:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Nombre del Servicio e Idioma">Idioma / <br>Nombre</b></th>
								<th class="align-middle"><b title="Descripción detallada del Servicio">Descripción</b></th>
								<th class="align-middle"><b title="Foto Principal y de Carrusel para el Servicio">Fotos</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_portada_serv.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><?php echo $datos['NOMBRE'][$i]; ?><br>/<br><?php echo $datos['IDIOMA'][$i]; ?></td>
								<td class="text-justify w-75"><?php echo $datos['DESCRIPCION'][$i]; ?></td>
								<td class="text-left"><img src="img/<?php echo $datos['FOTO'][$i]; ?>" width="100%" class="rounded" title="<?php echo $datos['NOMBRE'][$i]; ?>"><br><br><br><img src="img/<?php echo $datos['FOTO_CARRUSEL'][$i]; ?>" width="100%" class="rounded" title="<?php echo $datos['NOMBRE'][$i]; ?>"></td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_portada_serv.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_portada_serv.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_portada_serv?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
								<script>
									function confirmar<?php echo $i; ?>(url){
										if(confirm('¿Seguro que desea Borrar este Renglón?')){
											window.location=url;
										}else{
											return false;
										}	
									}
								</script>
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