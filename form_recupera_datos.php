<?php
	//CONECTANDO
	require("php_require/conexion.php");
	//RESCATANDO DATOS DEL FORMULARIO PARA OBTENER CORREO Y CONTRASEÑA
	$correo='';
	$contrasena='';
	if(isset($_POST['cedula']) and isset($_POST['n_empleado']) and isset($_POST['fecha_nac']) and isset($_POST['fecha_ing'])){
		$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
		$n_empleado=mysqli_real_escape_string($conexion,$_POST["n_empleado"]);
		$fecha_nac=mysqli_real_escape_string($conexion,$_POST["fecha_nac"]);
		$fecha_ing=mysqli_real_escape_string($conexion,$_POST["fecha_ing"]);
		$consulta="SELECT * FROM `usuarios` WHERE
		`CEDULA`='$cedula' AND 
		`NUMERO_DE_EMPLEADO`='$n_empleado' AND 
		`FECHA_NACIMIENTO`='$fecha_nac' AND
		`FECHA_INGRESO`='$fecha_ing'";
		$resultados=mysqli_query($conexion,$consulta);
		$verf_correo="no";
		while(($fila=mysqli_fetch_array($resultados))==true){
			$correo=$fila['CORREO'];
			$verf_correo="si";
		}
		if($verf_correo=="si"){
			//ACTUALIZANDO CONTRASEÑA AL AZAR
			$letras_y_numeros[0]="a";
			$letras_y_numeros[1]="b";
			$letras_y_numeros[2]="c";
			$letras_y_numeros[3]="d";
			$letras_y_numeros[4]="e";
			$letras_y_numeros[5]="f";
			$letras_y_numeros[6]="g";
			$letras_y_numeros[7]="h";
			$letras_y_numeros[8]="i";
			$letras_y_numeros[9]="j";
			$letras_y_numeros[10]="k";
			$letras_y_numeros[11]="l";
			$letras_y_numeros[12]="m";
			$letras_y_numeros[13]="n";
			$letras_y_numeros[14]="o";
			$letras_y_numeros[15]="p";
			$letras_y_numeros[16]="q";
			$letras_y_numeros[17]="r";
			$letras_y_numeros[18]="s";
			$letras_y_numeros[19]="t";
			$letras_y_numeros[20]="u";
			$letras_y_numeros[21]="v";
			$letras_y_numeros[22]="w";
			$letras_y_numeros[23]="x";
			$letras_y_numeros[24]="y";
			$letras_y_numeros[25]="z";
			$letras_y_numeros[26]="0";
			$letras_y_numeros[27]="1";
			$letras_y_numeros[28]="2";
			$letras_y_numeros[29]="3";
			$letras_y_numeros[30]="4";
			$letras_y_numeros[31]="5";
			$letras_y_numeros[32]="6";
			$letras_y_numeros[33]="7";
			$letras_y_numeros[34]="8";
			$letras_y_numeros[35]="9";
			$contrasena=$letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)];
			$nueva_contrasena_encryptada=password_hash($contrasena,PASSWORD_DEFAULT);
			$consulta="UPDATE `usuarios` SET `CONTRASENA`='$nueva_contrasena_encryptada' WHERE `CORREO`='$correo'";
			$resultados=mysqli_query($conexion,$consulta);
		}
		if($correo=='' or $contrasena==''){
			$correo='INVALIDO';
			$contrasena='INVALIDO';
		}
		mysqli_close($conexion);
	}else{
		$correo='';
		$contrasena='';
	}
?>
<!doctype html>
<html lang="es">
	<head>
		<?php require("php_require/seo_meta.php") ?>
		<?php require("php_require/head.php") ?>
		<title>SSP-Olvidó sus datos</title>
	</head>
	<body>
		<?php require("php_require/nav_index.php") ?>
		<section class="container-fluid px-5 pt-4 mt-5 mb-4">
			<?php if($correo==""){ ?>
				<div class="col-md-10 col-lg-7 mx-auto">
					<h3 class="mt-4"><span class="text-danger fa fa-cog fa-spin"></span> FORMULARIO PARA RECUPERACIÓN DE DATOS</h3>
					<p>Para recuperar su Correo y Contraseña, por favor, complete la siguiente información con sus datos personales:</p>
					<form action="form_recupera_datos.php" method="post" class="text-center bg-dark p-3 rounded">
						<div class="row">
							<div class="col-md-6 mb-2">
								<input type="number" class="form-control" name="cedula" id="cedula" placeholder="Cédula de Identidad" autofocus required autocomplete="off" title="introduzca su Cédula de Identidad" min="0">
							</div>
							<div class="col-md-6 mb-2">
								<input type="number" class="form-control" name="n_empleado" id="n_empleado" placeholder="Número de Empleado" required autocomplete="off" title="introduzca su Número de Empleado" min="0">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-2">
								<div id="click01" class="input-group date pickers">
									<input id="datepicker01" type='text' class="form-control" name="fecha_nac" id="fecha_nac" placeholder="Fecha de Nacimiento (Y-m-d)" required autocomplete="off" title="introduzca su Fecha de Nacimiento (Y-m-d)">
									<div class="input-group-append">
										<span class="input-group-text fa fa-calendar"></span>
									</div>
								</div>
 								<script type="text/javascript">
									$('#datepicker01').click(function(){
										Calendar.setup({
											inputField     :    "datepicker01",     // id of the input field
											ifFormat       :    "%Y-%m-%d",      // format of the input field
											button         :    "click01",  // trigger for the calendar (button ID)
											align          :    "Tl",           // alignment (defaults to "Bl")
											singleClick    :    true
										});
									});
								</script>
							</div>
							<div class="col-md-6 mb-2">
								<div id="click02" class="input-group date pickers">
									<input id="datepicker02" type='text' class="form-control" name="fecha_ing" id="fecha_ing" placeholder="Fecha de Ingreso (Y-m-d)" required autocomplete="off" title="introduzca su Fecha de Ingreso (Y-m-d)">
									<div class="input-group-append">
										<span class="input-group-text fa fa-calendar"></span>
									</div>
								</div>
								<script type="text/javascript">
									$('#datepicker02').click(function(){
										Calendar.setup({
											inputField     :    "datepicker02",     // id of the input field
											ifFormat       :    "%Y-%m-%d",      // format of the input field
											button         :    "click02",  // trigger for the calendar (button ID)
											align          :    "Tl",           // alignment (defaults to "Bl")
											singleClick    :    true
										});
									});
								</script>
							</div>
						</div>
						<input type="submit" value="Recuperar datos &raquo;" class="btn btn-danger">
					</form>
				</div>
			<?php }else if($correo=="INVALIDO"){ ?>
				<div class="col-md-10 col-lg-7 mx-auto">
					<h3 class="mt-4"><span class="text-danger fa fa-cog fa-spin"></span> FORMULARIO PARA RECUPARACIÓN DE DATOS</h3>
					<p>Para recuperar su Correo y Contraseña, por favor, complete la siguiente información con sus datos personales:</p>
					<form action="form_recupera_datos.php" method="post" class="text-center bg-dark p-3 rounded">
						<div class="row">
							<div class="col-md-6 mb-2">
								<input type="number" class="form-control" name="cedula" id="cedula" placeholder="Cédula" autofocus required autocomplete="off">
							</div>
							<div class="col-md-6 mb-2">
								<input type="number" class="form-control" name="n_empleado" id="n_empleado" placeholder="Número de Empleado" required autocomplete="off">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-2">
								<div id="click01" class="input-group date pickers">
									<input id="datepicker01" type='text' class="form-control" name="fecha_nac" id="fecha_nac" placeholder="Fecha de Nacimiento (Y-m-d)" required autocomplete="off">
									<div class="input-group-append">
										<span class="input-group-text fa fa-calendar"></span>
									</div>
								</div>
								<script type="text/javascript">
									$('#datepicker01').click(function(){
										Calendar.setup({
											inputField     :    "datepicker01",     // id of the input field
											ifFormat       :    "%Y-%m-%d",      // format of the input field
											button         :    "click01",  // trigger for the calendar (button ID)
											align          :    "Tl",           // alignment (defaults to "Bl")
											singleClick    :    true
										});
									});
								</script>
							</div>
							<div class="col-md-6 mb-2">
								<div id="click02" class="input-group date pickers">
									<input id="datepicker02" type='text' class="form-control" name="fecha_ing" id="fecha_ing" placeholder="Fecha de Ingreso (Y-m-d)" required autocomplete="off">
									<div class="input-group-append">
										<span class="input-group-text fa fa-calendar"></span>
									</div>
								</div>
								<script type="text/javascript">
									$('#datepicker02').click(function(){
										Calendar.setup({
											inputField     :    "datepicker02",     // id of the input field
											ifFormat       :    "%Y-%m-%d",      // format of the input field
											button         :    "click02",  // trigger for the calendar (button ID)
											align          :    "Tl",           // alignment (defaults to "Bl")
											singleClick    :    true
										});
									});
								</script>
							</div>
						</div>
						<input type="submit" value="Recuperar datos &raquo;" class="btn btn-danger">
					</form>
					<h4 class="text-center text-danger w-auto mx-auto"><strong>DATOS INVÁLIDOS:</strong> Por Favor vuelva a intentarlo.</h4>
				</div>
			<?php }else if($correo<>"" and $correo<>"INVALIDO"){ ?>
				<div class="col-md-8 col-lg-5 mx-auto text-center">
					<br><br><br>
					<h3 class="mt-4"><span class="text-danger fa fa-cog fa-spin"></span> RECUPARACIÓN DE DATOS:</h3>
					<p>Se ha recuperdo su información de usuario con éxito:</p>
					<h4>Correo: <strong class="text-danger"><?php echo $correo; ?></strong></h4>
					<h4>Contraseña Provisional: <strong class="text-danger"><?php echo $contrasena; ?></strong></h4>
					<p>Ingresa con estos datos desde "Ingresa" en la Barra de menú y cambie su contraseña provisional en su perfil.</p>
				</div>
			<?php } ?>
		</section>
		<?php require("php_require/footer2.php") ?>
	</body>
</html>