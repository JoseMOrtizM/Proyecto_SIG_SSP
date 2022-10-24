<!doctype html>
<html lang="es">
	<head>
		<?php require("php_require/seo_meta.php") ?>
		<?php require("php_require/head.php") ?>
		<title>SSP-Contactanos</title>
	</head>
	<body>
		<?php require("php_require/nav_index.php") ?>
		<section class="container-fluid px-5 pt-4 mt-5 mb-4">
			<div class="col-md-10 col-lg-7 mx-auto">
				<?php
					if($lang=="Ruso"){
						echo "<h3><span class='text-danger fa fa-cog fa-spin'></span> НАШ АДРЕС:</h3>";
					}else if($lang=="Ingles"){
						echo "<h3><span class='text-danger fa fa-cog fa-spin'></span> OUR ADDRESS:</h3>";
					}else{
						echo "<h3><span class='text-danger fa fa-cog fa-spin'></span> NUESTRA DIRECCIÓN:</h3>";
					}
				?>
				<address class='text-justify'>
				<?php
					require("php_require/conexion.php");
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='DIRECCION' AND `IDIOMA`='$lang'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
					mysqli_close($conexion);
				?>
				</address>
				<?php
					if($lang=="Ruso"){
						echo "<h3 class='mt-4'><span class='text-danger fa fa-cog fa-spin'></span> Свяжитесь с нами:</h3><br>";
					}else if($lang=="Ingles"){
						echo "<h3 class='mt-4'><span class='text-danger fa fa-cog fa-spin'></span> CONTACT US:</h3><br>";
					}else{
						echo "<h3 class='mt-4'><span class='text-danger fa fa-cog fa-spin'></span> TELÉFONOS DE CONTACTO:</h3><br>";
					}
				?>
				<table class="table table-hover text-center m-auto">
					<?php
						require("php_require/conexion.php");
						$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='PERSONAS DE CONTACTO' AND `IDIOMA`='$lang'"; 
						$resultados=mysqli_query($conexion,$consulta); 
						$fila=mysqli_fetch_array($resultados); 
						$contactos=explode(",",$fila['DESCRIPCION']); 
						$cta_contactos=0;
						while(isset($contactos[$cta_contactos])){
							$consulta_i="SELECT `NOMBRE`, `APELLIDO`, `CARGO`, `TELEFONO` FROM `usuarios` WHERE `CORREO`='$contactos[$cta_contactos]'"; 
							$resultados_i=mysqli_query($conexion,$consulta_i); 
							$fila_i=mysqli_fetch_array($resultados_i); 
							echo "
								<tr>
									<td><img src='fotos_del_personal/" . $contactos[$cta_contactos] . ".png' alt='" . $fila_i['CARGO'] . "' title='" . $fila_i['CARGO'] . "' width='60px' height='60px' class='m-auto rounded'></td>
									<td>";
							if($lang=="Español"){
								echo "<strong>" . $fila_i['CARGO'] . ":</strong><br>";
							}
							echo 
								$fila_i['NOMBRE'] . " " . $fila_i['APELLIDO'] . "</td>
									<td>" . $contactos[$cta_contactos] . "<br>" . $fila_i['TELEFONO'] . "</td>
								</tr>
							";
							$cta_contactos=$cta_contactos+1;
						}
						mysqli_close($conexion);
					?>
				</table>
				<?php
					if($lang=="Ruso"){
				?>
					<h3 class='mt-4'><span class='text-danger fa fa-cog fa-spin'></span> Оставьте нам свои комментарии:</h3>
					<form action="form_contactanos.php#confirmacion" method="post" class="text-center bg-dark p-2 rounded">
						<div class="row">
							<div class="col-md-6 mb-2">
								<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required autocomplete="off">
							</div>
							<div class="col-md-6 mb-2">
								<input type="email" class="form-control" name="email" id="email" placeholder="Отправить по электронной почте" required autocomplete="off">
							</div>
						</div>
						<textarea rows="4" name="comentario" id="comentario" class="form-control mb-2" required></textarea>
						<script>
							$(document).ready(function() {
								$('#comentario').summernote({
									placeholder: 'Оставьте нам свои комментарии',
									tabsize: 1,
									height: 100								
								});
							});
						</script>
						<input type="submit" value="Enviar &raquo;" class="btn btn-danger mt-2">
					</form>
				<?php
					}else if($lang=="Ingles"){
				?>
					<h3 class='mt-4'><span class='text-danger fa fa-cog fa-spin'></span> LEAVE US YOUR COMMENTS:</h3>
					<form action="form_contactanos.php#confirmacion" method="post" class="text-center bg-dark p-2 rounded">
						<div class="row">
							<div class="col-md-6 mb-2">
								<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Name" required autocomplete="off">
							</div>
							<div class="col-md-6 mb-2">
								<input type="email" class="form-control" name="email" id="email" placeholder="Email" required autocomplete="off">
							</div>
						</div>
						<textarea rows="4" name="comentario" id="comentario" class="form-control mb-2" required></textarea>
						<script>
							$(document).ready(function() {
								$('#comentario').summernote({
									placeholder: 'Comment',
									tabsize: 1,
									height: 100								
								});
							});
						</script>
						<input type="submit" value="Send &raquo;" class="btn btn-danger mt-2">
					</form>
				<?php
					}else{
				?>
					<h3 class='mt-4'><span class='text-danger fa fa-cog fa-spin'></span> CONTÁCTANOS:</h3>
					<form action="form_contactanos.php#confirmacion" method="post" class="text-center bg-dark p-2 rounded">
						<div class="row">
							<div class="col-md-6 mb-2">
								<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required autocomplete="off">
							</div>
							<div class="col-md-6 mb-2">
								<input type="email" class="form-control" name="email" id="email" placeholder="Correo" required autocomplete="off">
							</div>
						</div>
						<textarea rows="4" name="comentario" id="comentario" class="form-control mb-2" required></textarea>
						<script>
							$(document).ready(function() {
								$('#comentario').summernote({
									placeholder: 'Comentario',
									tabsize: 1,
									height: 100								
								});
							});
						</script>
						<input type="submit" value="Enviar &raquo;" class="btn btn-danger mt-2">
					</form>
				<?php
					}
				?>
<?php
	//CONECTANDO
	require("php_require/conexion.php");
	//RESCATANDO USUARIO
	if(isset($_POST['nombre'])){
		$nombre_ii=mysqli_real_escape_string($conexion,$_POST['nombre']);
	}else{
		$nombre_ii="0";
	}
	if(isset($_POST['email'])){
		$email_ii=mysqli_real_escape_string($conexion,$_POST["email"]);
	}else{
		$email_ii="0";
	}
	if(isset($_POST['comentario'])){
		$comentario_ii=mysqli_real_escape_string($conexion,$_POST["comentario"]);
	}else{
		$comentario_ii="0";
	}
	if($nombre_ii=="0" or $email_ii=="0" or $comentario_ii=="0"){
		//NO SE HAN ESCRITO COMENTARIOS AÚN... 
	}else{
		$fecha_ii=date("Y-m-d");
		$consulta="INSERT INTO `contactanos` (`NOMBRE`, `CORREO`, `FECHA_RECIBIDO`, `COMENTARIO`) VALUES ('$nombre_ii', '$email_ii', '$fecha_ii', '$comentario_ii')";
		$resultados=mysqli_query($conexion,$consulta);
		mysqli_close($conexion);
		
		if($lang=="Ruso"){
			echo "<h3 class='mt-4 mb-2 text-success' id='confirmacion'><span class='text-danger fa fa-cog fa-spin'></span> Мы получили ваше сообщение</h3><p class='text-justify text-success'>Спасибо, что связались с нами, мы скоро ответим на ваш запрос.</p>";
		}else if($lang=="Ingles"){
			echo "<h3 class='mt-4 mb-2 text-success' id='confirmacion'><span class='text-danger fa fa-cog fa-spin'></span> We've received your message</h3><p class='text-justify text-success'>Thank you for contacting us, we will soon be responding to your request.</p>";
		}else{
			echo "<h3 class='mt-4 mb-2 text-success' id='confirmacion'><span class='text-danger fa fa-cog fa-spin'></span> Hemos recibido tu comentario</h3><p class='text-justify text-success'>Gracias por contactarnos, en breve estaremos dando respuesta a su solicitud.</p>";
		}
	}
?>
			</div>
		</section>
		<?php require("php_require/footer.php") ?>
	</body>
</html>