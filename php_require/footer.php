<!---------------------------------- FOOTER ---------------------------------------->
<footer id="footer_con_ajuste" class="bg-dark pt-2 pb-1 px-5 my-0 fixed-bottom">
	<div class="row align-items-center justify-content-center">
		<div class="h6 d-inline text-center">
			<!-- Button trigger modal 1 -->
			<?php 
				require("php_require/conexion.php"); 
				$consulta="SELECT `NOMBRE`, `DESCRIPCION` FROM `portada` WHERE `TIPO`='POLITICA DE PRIVACIDAD' AND `IDIOMA`='$lang'"; 
				$resultados=mysqli_query($conexion,$consulta); 
				$fila=mysqli_fetch_array($resultados); 
				$titulo_i=$fila['NOMBRE']; 
				$descripcion_i=$fila['DESCRIPCION']; 
				mysqli_close($conexion);
			?>
			<a href="" class="text-muted mx-2" aria-hidden="true" title="<?php echo $titulo_i; ?>" data-toggle="modal" data-target="#modal_1"><?php echo $titulo_i; ?></a>
				<!-- Modal 1 -->
				<div class="modal fade bd-example-modal-lg" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle_1" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content text-justify px-4 py-1">
							<div class="modal-header">
								<h4 class="modal-title" id="exampleModalLongTitle_1"><?php echo $titulo_i; ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?php echo $descripcion_i ?>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">&times;</button>
							</div>
						</div>
					</div>
				</div>
			<!-- Button trigger modal 2 -->										
			<?php 
				require("php_require/conexion.php"); 
				$consulta="SELECT `NOMBRE`, `DESCRIPCION` FROM `portada` WHERE `TIPO`='CONDICIONES DE USO' AND `IDIOMA`='$lang'"; 
				$resultados=mysqli_query($conexion,$consulta); 
				$fila=mysqli_fetch_array($resultados); 
				$titulo_i=$fila['NOMBRE']; 
				$descripcion_i=$fila['DESCRIPCION']; 
				mysqli_close($conexion);
			?>
			<a href="" class="text-muted mx-2" aria-hidden="true" title="<?php echo $titulo_i; ?>" data-toggle="modal" data-target="#modal_2"><?php echo $titulo_i; ?></a>
				<!-- Modal 2 -->
				<div class="modal fade bd-example-modal-lg" id="modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle_2" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content text-justify px-4 py-1">
							<div class="modal-header">
								<h4 class="modal-title" id="exampleModalLongTitle_2"><?php echo $titulo_i; ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?php echo $descripcion_i; ?>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">&times;</button>
							</div>
						</div>
					</div>
				</div>					
			<!-- Button trigger modal 3 -->										
			<?php 
				require("php_require/conexion.php"); 
				$consulta="SELECT `NOMBRE`, `DESCRIPCION` FROM `portada` WHERE `TIPO`='USO DE COOKIES' AND `IDIOMA`='$lang'"; 
				$resultados=mysqli_query($conexion,$consulta); 
				$fila=mysqli_fetch_array($resultados); 
				$titulo_i=$fila['NOMBRE']; 
				$descripcion_i=$fila['DESCRIPCION']; 
				mysqli_close($conexion);
			?>
			<a href="" class="text-muted mx-2" aria-hidden="true" title="<?php echo $titulo_i; ?>" data-toggle="modal" data-target="#modal_3"><?php echo $titulo_i; ?></a>
				<!-- Modal 3 -->
				<div class="modal fade bd-example-modal-lg" id="modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle_3" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content text-justify px-4 py-1">
							<div class="modal-header">
								<h4 class="modal-title" id="exampleModalLongTitle_3"><?php echo $titulo_i; ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?php echo $descripcion_i; ?>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">&times;</button>
							</div>
						</div>
					</div>
				</div>
				<?php
					if($lang=="Español"){
				?>
				<a href="form_empleo.php" class="text-muted mx-2" aria-hidden="true" title="Trabaja con nosotros">Empleo</a>
				<?php
					}
				?>
		</div>
	</div>
	<!------ Redes Sociales ------>
	<div class="row justify-content-between align-items-center text-center">
		<div class="col text-center h4">
			<a href="http://www.facebook.com/
				<?php 
					require("php_require/conexion.php"); 
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='FACEBOOK' AND `IDIOMA`='$lang'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
					mysqli_close($conexion);
				?>
			" class="fa fa-facebook-square text-light  mr-3" aria-hidden="true" title="facebook"></a>
			<a href="http://www.twitter.com/
				<?php 
					require("php_require/conexion.php"); 
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='TWITTER' AND `IDIOMA`='$lang'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
					mysqli_close($conexion);
				?>
			" class="fa fa-twitter-square text-light mr-3" aria-hidden="true" title="twitter"></a>
			<a href="http://www.linkedin.com/
				<?php 
					require("php_require/conexion.php"); 
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='LINKEDIN' AND `IDIOMA`='$lang'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
					mysqli_close($conexion);
				?>
			" class="fa fa-linkedin-square text-light mr-3" aria-hidden="true" title="linkedin"></a>
		</div>
	</div>
	<!------ Copy right ------>
	<div class="row align-items-center">
		<div class="col text-center">
			<p class="h6 text-muted">
				<?php
					if($lang=="Español"){
						echo "República Bolivariana de Venezuela / ";
					}else{
						echo "Venezuela / ";
					}
				?>
				RIF:&nbsp;
				<?php 
					require("php_require/conexion.php"); 
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='RIF' AND `IDIOMA`='$lang'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
					mysqli_close($conexion);
				?>
				&nbsp;/ © - 2019 
			</p>
		</div>
	</div>
</footer>
<script>
	$(window).ready(function(){
		if($("body").height()<500){
			$("#footer_con_ajuste").addClass("fixed-bottom");
		}else{
			$("#footer_con_ajuste").removeClass("fixed-bottom");
		}
	});
</script>
