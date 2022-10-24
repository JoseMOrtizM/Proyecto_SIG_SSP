<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST["CRUD"])){
		//SI SE MANDÓ A INSERTAR UN NUEVO REGISTRO
		if($_POST["CRUD"]=="C"){
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$departamento=mysqli_real_escape_string($conexion, $_POST['departamento']);
			$tipo_departamento=mysqli_real_escape_string($conexion, $_POST['tipo_departamento']);
			$jefe=mysqli_real_escape_string($conexion, $_POST['jefe']);
			$supervisado=mysqli_real_escape_string($conexion, $_POST['supervisado']);
			$formacion=mysqli_real_escape_string($conexion, $_POST['formacion']);
			$experiencia=mysqli_real_escape_string($conexion, $_POST['experiencia']);
			$idioma=mysqli_real_escape_string($conexion, $_POST['idioma']);
			$objetivos=mysqli_real_escape_string($conexion, $_POST['objetivos']);
			$competencias=mysqli_real_escape_string($conexion, $_POST['competencias']);
			$habilidades=mysqli_real_escape_string($conexion, $_POST['habilidades']);
			$func_principales=mysqli_real_escape_string($conexion, $_POST['func_principales']);
			$func_adicionales=mysqli_real_escape_string($conexion, $_POST['func_adicionales']);
			$consulta="INSERT INTO `descripcion_de_cargos` (`CARGO`, `TIPO_DEPARTAMENTO`, `DEPARTAMENTO`, `JEFE`, `SUPERVISADO`, `FORMACION`, `EXPERIENCIA`, `IDIOMA`, `OBJETIVOS`, `COMPETENCIAS`, `HABILIDADES`, `FUNCIONES_PRINCIPALES`, `FUNCIONES_ADICIONALES`) VALUES ('$cargo','$tipo_departamento','$departamento','$jefe','$supervisado', '$formacion','$experiencia','$idioma','$objetivos','$competencias', '$habilidades','$func_principales','$func_adicionales')";
			$resultados=mysqli_query($conexion,$consulta);
		//SI SE MANDÓ A MODIFICAR UN REGISTRO EXISTENTE
		}else if($_POST["CRUD"]=="U"){
			$crud_id=mysqli_real_escape_string($conexion, $_POST['CRUD_ID']);
			$cargo=mysqli_real_escape_string($conexion, $_POST['cargo']);
			$tipo_departamento=mysqli_real_escape_string($conexion, $_POST['tipo_departamento']);
			$departamento=mysqli_real_escape_string($conexion, $_POST['departamento']);
			$jefe=mysqli_real_escape_string($conexion, $_POST['jefe']);
			$supervisado=mysqli_real_escape_string($conexion, $_POST['supervisado']);
			$formacion=mysqli_real_escape_string($conexion, $_POST['formacion']);
			$experiencia=mysqli_real_escape_string($conexion, $_POST['experiencia']);
			$idioma=mysqli_real_escape_string($conexion, $_POST['idioma']);
			$objetivos=mysqli_real_escape_string($conexion, $_POST['objetivos']);
			$competencias=mysqli_real_escape_string($conexion, $_POST['competencias']);
			$habilidades=mysqli_real_escape_string($conexion, $_POST['habilidades']);
			$func_principales=mysqli_real_escape_string($conexion, $_POST['func_principales']);
			$func_adicionales=mysqli_real_escape_string($conexion, $_POST['func_adicionales']);
			$consulta="UPDATE `descripcion_de_cargos` SET 
			`CARGO`='$cargo',
			`TIPO_DEPARTAMENTO`='$tipo_departamento',
			`DEPARTAMENTO`='$departamento',
			`JEFE`='$jefe',
			`SUPERVISADO`='$supervisado',
			`FORMACION`='$formacion',
			`EXPERIENCIA`='$experiencia',
			`IDIOMA`='$idioma',
			`OBJETIVOS`='$objetivos',
			`COMPETENCIAS`='$competencias',
			`HABILIDADES`='$habilidades',
			`FUNCIONES_PRINCIPALES`='$func_principales',
			`FUNCIONES_ADICIONALES`='$func_adicionales'
			WHERE `ID`='$crud_id'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	//SI POR MEDIO DE $_GET[] SE MANDÓ A BORRAR UN REGISTRO EXISTENTE
	}else if(isset($_GET["NA_Accion"])){
		if($_GET["NA_Accion"]=="borrar"){
			$id_a_borrar=$_GET["NA_Id"];
			$consulta="DELETE FROM `descripcion_de_cargos` WHERE `ID`='$id_a_borrar'";
			$resultados=mysqli_query($conexion,$consulta);
		}
	}
	//LUEGO DE REALIZADAS LAS ACCIONES QUE MODIFICAN LA BASE DE DATOS... SE OBTIENEN LOS DATOS DEL CRUD DE LA MISMA
	$consulta="SELECT * FROM `descripcion_de_cargos` ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREAR UN ARRAY DE DOS DIMENSIONES PARA LOS DATOS
		$datos['ID'][$i]=$fila['ID'];//********
		$datos['CARGO'][$i]=$fila['CARGO'];//********
		$datos['TIPO_DEPARTAMENTO'][$i]=$fila['TIPO_DEPARTAMENTO'];
		$datos['DEPARTAMENTO'][$i]=$fila['DEPARTAMENTO'];
		$datos['JEFE'][$i]=$fila['JEFE'];//********
		$datos['SUPERVISADO'][$i]=$fila['SUPERVISADO'];//********
		$datos['FORMACION'][$i]=$fila['FORMACION'];
		$datos['EXPERIENCIA'][$i]=$fila['EXPERIENCIA'];
		$datos['IDIOMA'][$i]=$fila['IDIOMA'];
		$datos['OBJETIVOS'][$i]=$fila['OBJETIVOS'];
		$datos['COMPETENCIAS'][$i]=$fila['COMPETENCIAS'];
		$datos['HABILIDADES'][$i]=$fila['HABILIDADES'];
		$datos['FUNCIONES_PRINCIPALES'][$i]=$fila['FUNCIONES_PRINCIPALES'];
		$datos['FUNCIONES_ADICIONALES'][$i]=$fila['FUNCIONES_ADICIONALES'];
		$i=$i+1;
	}
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: BD-Cargos</title>
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
						<h3 class="text-center text-md-left" title="Insertar nuevo Cargo en la Empresa"><span class="text-danger fa fa-cog fa-spin "></span> Insertar Cargo:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_cargos.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_cargos.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="C">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="cargo" id="cargo" placeholder="introduzca el cargo nuevo" required autocomplete="off" title="introduzca el cargo nuevo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Tipo-Depart:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="tipo_departamento" id="tipo_departamento" placeholder="introduzca el tipo de departamento del nuevo cargo" required autocomplete="off" title="introduzca el tipo de departamento del nuevo cargo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Departamento:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="departamento" id="departamento" placeholder="introduzca el departamento del nuevo cargo" required autocomplete="off" title="introduzca el departamento del nuevo cargo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Jefe:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="jefe" id="jefe" placeholder="introduzca el cargo del Jefe inmediato para el nuevo cargo" required autocomplete="off" title="introduzca el cargo del Jefe inmediato para el nuevo cargo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Supervisados:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="supervisado" id="supervisado" placeholder="introduzca el cargo del personal a cargo para el nuevo cargo" required autocomplete="off" title="introduzca el cargo del personal a cargo para el nuevo cargo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Formacion:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="formacion" id="formacion" placeholder="introduzca la Formación requerida para el nuevo cargo" required autocomplete="off" title="introduzca la Formación requerida para el nuevo cargo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Experiencia:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="experiencia" id="experiencia" placeholder="introduzca los Años de experiencia requerida para el nuevo cargo" required autocomplete="off" title="introduzca los Años de experiencia requerida para el nuevo cargo">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Idiomas:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="idioma" id="idioma" placeholder="introduzca idioma y nivel requerido para el nuevo cargo" required autocomplete="off" title="introduzca idioma y nivel requerido para el nuevo cargo">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Objetivos:</span>
						<textarea class="form-control col mb-2" name="objetivos" id="objetivos" required></textarea>
						<script>
							$(document).ready(function() {
								$('#objetivos').summernote({
									placeholder: 'introduzca los objetivos del nuevo cargo',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Competencias:</span>
						</div>
						<textarea class="form-control col mb-2" name="competencias" id="competencias" placeholder="introduzca las competencias del nuevo cargo" required autocomplete="off" title="introduzca las competencias del nuevo cargo"></textarea>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Habilidades:</span>
						</div>
						<textarea class="form-control col mb-2" name="habilidades" id="habilidades" placeholder="introduzca las habilidades del nuevo cargo" required autocomplete="off" title="introduzca las habilidades del nuevo cargo"></textarea>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Funciones:</span>
						<textarea class="form-control col mb-2" name="func_principales" id="func_principales" required></textarea>
						<script>
							$(document).ready(function() {
								$('#func_principales').summernote({
									placeholder: 'introduzca las funciones principales del nuevo cargo',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Adicionales:</span>
						</div>
						<textarea class="form-control col mb-2" name="func_adicionales" id="func_adicionales" placeholder="introduzca las funciones adicionales del nuevo cargo" required autocomplete="off" title="introduzca las funciones adicionales del nuevo cargo"></textarea>
					</div>
					<div class="m-auto">
						<a href="CRUD_cargos.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
			}else if($_GET["NA_Accion"]=="actualizar"){
				//OBTENIENDO LOS DATOS DE LA BASE DE DATOS PARA EL ID A ACTUALIZAR
				$id_a_actualizar=$_GET["NA_Id"];
				$consulta="SELECT * FROM `descripcion_de_cargos` WHERE `ID`='$id_a_actualizar'";
				$resultados=mysqli_query($conexion,$consulta);
				$i=0;
				while(($fila=mysqli_fetch_array($resultados))==true){
					//CREAR UN ARRAY DE UNA DIMENSION PARA IMPRIMIR LOS DATOS QUE SE VAN A ACTUALIZAR
					$datos_a_actualizar['ID']=$fila['ID'];
					$datos_a_actualizar['CARGO']=$fila['CARGO'];
					$datos_a_actualizar['TIPO_DEPARTAMENTO']=$fila['TIPO_DEPARTAMENTO'];
					$datos_a_actualizar['DEPARTAMENTO']=$fila['DEPARTAMENTO'];
					$datos_a_actualizar['JEFE']=$fila['JEFE'];
					$datos_a_actualizar['SUPERVISADO']=$fila['SUPERVISADO'];
					$datos_a_actualizar['FORMACION']=$fila['FORMACION'];
					$datos_a_actualizar['EXPERIENCIA']=$fila['EXPERIENCIA'];
					$datos_a_actualizar['IDIOMA']=$fila['IDIOMA'];
					$datos_a_actualizar['OBJETIVOS']=$fila['OBJETIVOS'];
					$datos_a_actualizar['COMPETENCIAS']=$fila['COMPETENCIAS'];
					$datos_a_actualizar['HABILIDADES']=$fila['HABILIDADES'];
					$datos_a_actualizar['FUNCIONES_PRINCIPALES']=$fila['FUNCIONES_PRINCIPALES'];
					$datos_a_actualizar['FUNCIONES_ADICIONALES']=$fila['FUNCIONES_ADICIONALES'];
					$i=$i+1;
				}
		?>
			<div class="col-md-12 col-lg-9 mx-auto">
				<div class="row mt-4 align-items-center">
					<div class="col-md-9 mb-1">
						<h3 class="text-center text-md-left" title="Modificar un Cargo existente en la Empresa"><span class="text-danger fa fa-cog fa-spin "></span> Modificar Cargo:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1">
						<a href="CRUD_cargos.php" class="btn btn-danger text-light p-1"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_cargos.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="CRUD" id="CRUD" value="U">
					<input type="hidden" name="CRUD_ID" id="CRUD_ID" value="<?php echo $datos_a_actualizar['ID']; ?>">
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Cargo:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="cargo" id="cargo" placeholder="Modifique el cargo nuevo" required autocomplete="off" title="Modifique el cargo nuevo" value="<?php echo $datos_a_actualizar['CARGO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Tipo-Depart:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="tipo_departamento" id="tipo_departamento" placeholder="Modifique el tipo de departamento del cargo" required autocomplete="off" title="Modifique el tipo de departamento del cargo" value="<?php echo $datos_a_actualizar['TIPO_DEPARTAMENTO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Departamento:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="departamento" id="departamento" placeholder="Modifique el departamento del cargo" required autocomplete="off" title="Modifique el departamento del cargo" value="<?php echo $datos_a_actualizar['DEPARTAMENTO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Jefe:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="jefe" id="jefe" placeholder="Modifique el cargo del Jefe inmediato para el cargo" required autocomplete="off" title="Modifique el cargo del Jefe inmediato para el cargo" value="<?php echo $datos_a_actualizar['JEFE']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Supervisados:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="supervisado" id="supervisado" placeholder="Modifique el cargo del personal a cargo para el cargo" required autocomplete="off" title="Modifique el cargo del personal a cargo para el cargo" value="<?php echo $datos_a_actualizar['SUPERVISADO']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Formacion:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="formacion" id="formacion" placeholder="Modifique la Formación requerida para el cargo" required autocomplete="off" title="Modifique la Formación requerida para el cargo" value="<?php echo $datos_a_actualizar['FORMACION']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Experiencia:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="experiencia" id="experiencia" placeholder="Modifique los Años de experiencia requerida para el cargo" required autocomplete="off" title="Modifique los Años de experiencia requerida para el cargo" value="<?php echo $datos_a_actualizar['EXPERIENCIA']; ?>">
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Idiomas:</span>
						</div>
						<input type="text" class="form-control col mb-2" name="idioma" id="idioma" placeholder="Modifique idioma y nivel requerido para el cargo" required autocomplete="off" title="Modifique idioma y nivel requerido para el cargo" value="<?php echo $datos_a_actualizar['IDIOMA']; ?>">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Objetivos:</span>
						<textarea class="form-control col mb-2" name="objetivos" id="objetivos" required><?php echo $datos_a_actualizar['OBJETIVOS']; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#objetivos').summernote({
									placeholder: 'Modifique los objetivos del cargo',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Competencias:</span>
						</div>
						<textarea class="form-control col mb-2" name="competencias" id="competencias" placeholder="Modifique las competencias del cargo" required autocomplete="off" title="Modifique las competencias del cargo"><?php echo $datos_a_actualizar['COMPETENCIAS']; ?></textarea>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Habilidades:</span>
						</div>
						<textarea class="form-control col mb-2" name="habilidades" id="habilidades" placeholder="Modifique las habilidades del cargo" required autocomplete="off" title="Modifique las habilidades del cargo"><?php echo $datos_a_actualizar['HABILIDADES']; ?></textarea>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text w-100">Funciones:</span>
						<textarea class="form-control col mb-2" name="func_principales" id="func_principales" required><?php echo $datos_a_actualizar['FUNCIONES_PRINCIPALES']; ?></textarea>
						<script>
							$(document).ready(function() {
								$('#func_principales').summernote({
									placeholder: 'Modifique las funciones principales del cargo',
									tabsize: 1,
									height: 250								
								});
							});
						</script>
					</div>
					<div class="input-group">
						<div class="input-group-prepend mb-2 w-25">
							<span class="input-group-text w-100">Adicionales:</span>
						</div>
						<textarea class="form-control col mb-2" name="func_adicionales" id="func_adicionales" placeholder="Modifique las funciones adicionales del cargo" required autocomplete="off" title="Modifique las funciones adicionales del cargo"><?php echo $datos_a_actualizar['FUNCIONES_ADICIONALES']; ?></textarea>
					</div>
					<div class="m-auto">
						<a href="CRUD_cargos.php" class="btn btn-danger text-light"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-danger">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES LA HOJA YA LO DETECTÓ MAS ARRIBA Y SOLO QUEDA REDIRECIONAR A LA VISTA PRINCIPAL (R) DEL CRUD --- ENTONCES:
			}else{
		?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_cargos.php">
		<?php
			}
		//SI NO SE REALIZA NINGUNA ACCIÓN EL EL CRUD SE MUESTRA LA TABLA COMO ESTÁ QUEDANDO EN LA BASE DE DATOS:
		}else{
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header text-center bg-transparent">
				<h3 class='text-center'><span class="text-danger fa fa-cog fa-spin"></span> Estos son los Cargos existentes en el sitio:</h3>
			</div>
			<div class="card-body px-1">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="dataTable01">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Cargo a ejercer">Cargo</b></th>
								<th class="align-middle"><b title="Jefe inmediato">Jefe</b></th>
								<th class="align-middle"><b title="Estado del cargo">¿Vacante?</b></th>
								<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_cargos.php?NA_Accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								while(isset($datos['ID'][$i])){
							?>
							<tr>
								<td class="text-left"><input type="hidden" value="<?php echo $datos['ID'][$i]; ?>"><?php echo $datos['CARGO'][$i]; ?></td>
								<td class="text-justify"><?php echo $datos['JEFE'][$i]; ?></td>
								<td class="text-center">
									<?php 
										$consulta2="SELECT * FROM `usuarios` WHERE `CARGO`='" . $datos['CARGO'][$i] . "'";
										$resultados2=mysqli_query($conexion,$consulta2);
										$e=0;
										while(($fila2=mysqli_fetch_array($resultados2))==true){
											$e=1;
										}
										if($e==0){
											echo "SI";
										}else{
											echo "NO";
										}
									?>
								</td>
								<td class="text-center h5"><a title="Modificar" href="CRUD_cargos.php?NA_Accion=actualizar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="h3 btn btn-transparent text-success fa fa-edit d-inline"></a>&nbsp;&nbsp;<a title="Eliminar" href="CRUD_cargos.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>" class="btn btn-transparent text-danger fa fa-trash-o d-inline" onclick="return confirmar<?php echo $i; ?>('CRUD_cargos.php?NA_Accion=borrar&NA_Id=<?php echo $datos['ID'][$i]; ?>')"></a></td>
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
		<br><br><br><br><br><br>
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
	  $('#dataTable01').DataTable();
	});
</script>
<?php
mysqli_close($conexion);
?>