	<!------------------------MENU DESPLGABLE EN PANTALLAS PEQUEÑAS-------------->
			<div class="d-inline d-md-none">
				<div class="bg-dark px-5 py-1">
					<?php require("php_require/menu_lateral.php") ?>
				</div>
			</div>
	<!------------------ FINAL DEL ARREGLO PARA ASIDE Y SECCIÓN------------------>
		</div>
	</div>
</section>
<!------------------------------- FOOTER ------------------------------------->
<footer id="footer_con_ajuste" class=" bg-dark pt-2 pb-1 pr-2 pl-5 my-0 fixed-bottom">
	<div class="row justify-content-around align-items-center">
		<!------ Redes Sociales ------>
		<div class="col-6 h4"> 
			<a href="#" class="fa fa-facebook-square text-light  mr-3" aria-hidden="true" title="facebook"></a>
			<a href="#" class="fa fa-twitter-square text-light mr-3" aria-hidden="true" title="twitter"></a>
			<a href="#" class="fa fa-linkedin-square text-light mr-3" aria-hidden="true" title="linkedin"></a>
		</div>
		<!------ Copy right ------>
		<div class="col-6">
			<p class="h6 text-muted text-right">
				RIF:&nbsp;
				<?php 
					require("php_require/conexion.php");
					$consulta="SELECT `DESCRIPCION` FROM `portada` WHERE `TIPO`='RIF'"; 
					$resultados=mysqli_query($conexion,$consulta); 
					$fila=mysqli_fetch_array($resultados); 
					echo $fila['DESCRIPCION']; 
				?>
				&nbsp;©2019
			</p>
		</div>
	</div>
</footer>
<script>
	$(window).change(function(){
		if($("body").height()<400){
			$("#footer_con_ajuste").addClass("fixed-bottom");
		}else{
			$("#footer_con_ajuste").removeClass("fixed-bottom");
		}
	});
	function recargar(){
		location.reload();
	}
	setTimeout ("recargar()", 300001);
</script>
