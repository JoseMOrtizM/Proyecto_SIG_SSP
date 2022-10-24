<!------------------ NAV BAR PARA INDEX---------------------------------->
<?php 
	require("php_require/conexion.php");
	//VERIFICANDO NOTIFICACIONES PLAN
	$consulta="SELECT `ID` FROM `planes` 
		WHERE `CARGO`='$usuario_cargo' 
		AND `APROBADO`='NO' 
		AND `COMENTARIO_RECHASADO`<>'' 
		ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_user_plan=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_user_plan=$verf_user_plan+1;
	}
	//VERIFICANDO NOTIFICACIONES REAL
	$consulta="SELECT `reales`.`ID` AS ID FROM `reales` 
	INNER JOIN `planes` ON `planes`.`ID`=`reales`.`ID_PLAN` 
	WHERE `planes`.`CARGO`='$usuario_cargo' 
	AND `reales`.`APROBADO`='NO' 
	AND `reales`.`COMENTARIO_RECHASADO`<>'' 
	ORDER BY `reales`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_user_real=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_user_real=$verf_user_real+1;
	}
	//VERIFICANDO NOTIFICACIONES REAL-ADC
	$consulta="SELECT `ID` FROM `reales_adicional` 
		WHERE `CARGO`='$usuario_cargo' 
		AND `APROBADO`='NO' 
		AND `COMENTARIO_RECHASADO`<>'' 
		ORDER BY `ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_user_real_adc=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_user_real_adc=$verf_user_real_adc+1;
	}
	//VERIFICANDO NOTIFICACIONES APROBAR
	$verf_aprobar=0;
	$consulta="SELECT `planes`.`ID` FROM `planes` 
		INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`planes`.`CARGO` 
		INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
		WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
		AND `planes`.`APROBADO`='NO' 
		AND `planes`.`COMENTARIO_RECHASADO`='' 
		ORDER BY `planes`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_aprobar_plan=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_aprobar_plan=$verf_aprobar_plan+1;
	}
	$consulta="SELECT `reales`.`ID` FROM `reales` 
		INNER JOIN `planes` ON `reales`.`ID_PLAN`=`planes`.`ID` 
		INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`planes`.`CARGO` 
		INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
		WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
		AND `reales`.`APROBADO`='NO' 
		AND `reales`.`COMENTARIO_RECHASADO`='' 
		ORDER BY `reales`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_aprobar_real=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_aprobar_real=$verf_aprobar_real+1;
	}
	$consulta="SELECT `reales_adicional`.`ID` 
		FROM `reales_adicional` 
		INNER JOIN `descripcion_de_cargos` ON `descripcion_de_cargos`.`CARGO`=`reales_adicional`.`CARGO` 
		INNER JOIN `usuarios` ON `usuarios`.`CARGO`=`descripcion_de_cargos`.`CARGO` 
		WHERE `descripcion_de_cargos`.`JEFE`='$usuario_cargo' 
		AND `reales_adicional`.`APROBADO`='NO' 
		AND `reales_adicional`.`COMENTARIO_RECHASADO`='' 
		ORDER BY `reales_adicional`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_aprobar_real_adc=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_aprobar_real_adc=$verf_aprobar_real_adc+1;
	}
	$verf_aprobar=$verf_aprobar_plan+$verf_aprobar_real+$verf_aprobar_real_adc;
	//VERIFICANDO NOTIFICACIONES ARTICULOS EN TRANSITO
	$consulta="SELECT 
	`inv_operacion`.`ID` AS ID
	FROM `inv_operacion` 
	INNER JOIN `inv_articulos` ON `inv_operacion`.`NOMBRE_ARTICULO`=`inv_articulos`.`NOMBRE_ART` 
	INNER JOIN `usuarios` ON `inv_operacion`.`CORREO_HACIA`=`usuarios`.`CORREO` 
	WHERE `inv_operacion`.`CORREO_DESDE`='$usuario_correo' 
	AND `inv_operacion`.`FECHA_RECIBIDO`='0000-00-00' 
	ORDER BY 
	`inv_operacion`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_user_transito=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_user_transito=$verf_user_transito+1;
	}
	//VERIFICANDO NOTIFICACIONES ARTICULOS PENDIENTES POR RECIBIR
	$consulta="SELECT 
	`inv_operacion`.`ID` AS ID 
	FROM `inv_operacion` 
	INNER JOIN `inv_articulos` ON `inv_operacion`.`NOMBRE_ARTICULO`=`inv_articulos`.`NOMBRE_ART` 
	INNER JOIN `usuarios` ON `inv_operacion`.`CORREO_DESDE`=`usuarios`.`CORREO` 
	WHERE `inv_operacion`.`CORREO_HACIA`='$usuario_correo' 
	AND `inv_operacion`.`FECHA_RECIBIDO`='0000-00-00' 
	ORDER BY 
	`inv_operacion`.`ID`";
	$resultados=mysqli_query($conexion,$consulta);
	$verf_user_recibir=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$verf_user_recibir=$verf_user_recibir+1;
	}
	$verf_todas_las_notificaciones=$verf_user_plan+$verf_user_real+$verf_user_real_adc+ $verf_aprobar+$verf_user_transito+$verf_user_recibir;
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top py-0 pl-1 pr-2 my-0">
	<a class="navbar-text" style="width: 150px; margin-left: 2%;" href="zona_principal.php">
		<!-- LOGO ANIMADO COM "amazingslider"-->
		<div id="amazingslider-wrapper-1" style="max-width:140px; height:38px; margin:0px auto 0px; border:#000 0px solid; overflow:hidden; background-color:transparent">
			<div id="amazingslider-1" style="margin:0 auto;">
				<ul class="amazingslider-slides" style="display:none;">
					<li><img src="img/<?php $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='LOGO'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; ?>"/>
					</li>
					<li><img src="img/<?php $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='LOGO'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; ?>"/>
					</li>
				</ul>
			</div>
		</div>
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="true" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarsExample04">
		<ul class="navbar-nav ml-auto mr-1 py-2">
			<li class="nav-item dropdown">
				<?php
					if($verf_todas_las_notificaciones>0){
						echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_todas_las_notificaciones</b></span>";
					}
				?>
				<a class="dropdown-toggle text-light" href="" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Mostrar opciones de usuario">
					<?php echo "Bienvenido: $usuario_nombre"; ?></span>
				</a>
				<div class="d-none d-md-inline">
					<img src="fotos_del_personal/<?php echo $usuario_correo; ?>.png" class="imgFit border border-light rounded-circle" style="height: 41px; width: 45px;" title="<?php echo $usuario_nombre; ?>">
				</div>
				<div class="dropdown-menu px-3 py-0 bg-dark w-100" aria-labelledby="dropdown05">
					<div class="d-none d-md-block">
						<div class="w-100 border-bottom border-danger">
							<a class="d-block text-light text-left" href="perfil_de_usuario.php" title="Ver o modificar tus datos personales"><span class="fa fa-user-circle-o d-inline"></span>&nbsp;&nbsp;Mi Perfil</a>
						</div>
						<div class="w-100">
							<a class="d-block text-light text-left" href="usuario_plan.php" title="Ver, cargar, modificar o eliminar los planes asociados a tu cargo actual">
								<span class="fa fa-bar-chart-o d-inline">&nbsp;&nbsp;Plan</span>
								<?php
									if($verf_user_plan>0){
										echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_plan</b></span>";
									}
								?>
							</a>
						</div>
						<div class="w-100">
							<a class="d-block text-light text-left" href="usuario_real.php" title="Ver, cargar, modificar o eliminar los actividades reales asociados a tu cargo actual">
								<span class="fa fa-tasks d-inline">&nbsp;&nbsp;Real</span>
								<?php
									if($verf_user_real>0){
										echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_real</b></span>";
									}
								?>
							</a>
						</div>
						<div class="w-100">
							<a class="d-block text-light text-left" href="usuario_real_adic.php" title="Ver, cargar, modificar o eliminar tus actividades adicionales">
								<span class="fa fa-line-chart d-inline">&nbsp;Adicional</span>
								<?php
									if($verf_user_real_adc>0){
										echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_real_adc</b></span>";
									}
								?>
							</a>
						</div>
						<div class="w-100 border-bottom border-danger">
							<a class="d-block text-light text-left" href="usuario_explicaciones.php" title="Ver o modificar las explicaciones de la desviación Plan vs Real"><span class="fa fa fa-question-circle-o d-inline">&nbsp;&nbsp;Explicaciones<span></a>
						</div>
						<div class="w-100 border-bottom border-danger">
							<a class="d-block text-light text-left" href="usuario_aprobar.php" title="Ver Planes y Actividades pendientes por aprobar y rechasadas para tus supervisados">
								<span class="fa fa-thumbs-up d-inline"></span>&nbsp;&nbsp;Aprobar
								<?php
									if($verf_aprobar>0){
										echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_aprobar</b></span>";
									}
								?>
							</a>
						</div>
						<div class="w-100">
							<a class="d-block text-light text-left" href="usuario_inventario_general.php" title="Ver resumen de tu inventario actual"><span class="fa fa-cubes d-inline">&nbsp;Inventario</span></a>
						</div>
						<div class="w-100">
							<a class="d-block text-light text-left" href="usuario_inventario_entregar.php" title="Entregar artículos de tu inventario a otro empleado o cliente"><span class="fa fa-mail-forward d-inline">&nbsp;&nbsp;Entregar</span></a>
						</div>
						<div class="w-100">
							<a class="d-block text-light text-left" title="Confirmar la recepción de artículos de otro empleado o proveedor" href="usuario_inventario_recibir.php">
								<span class="fa fa-mail-reply d-inline">&nbsp;&nbsp;Recibir</span>
								<?php
									if($verf_user_recibir>0){
										echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_recibir</b></span>";
									}
								?>
							</a>
						</div>
						<div class="w-100 border-bottom border-danger">
							<a class="d-block text-light text-left" href="usuario_inventario_en_transito.php" title="Ver envios que están pendientes por confirmación de quién recibe">
								<span class="fa fa-truck d-inline">&nbsp;&nbsp;en Tránsito</span>
								<?php
									if($verf_user_transito>0){
										echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_transito</b></span>";
									}
								?>
							</a>
						</div>
						<div class="pb-1 w-100">
							<a class="d-block text-light text-left" href="salir.php" title="Salir del sistema" onclick="return confirmar1('salir.php')">
								<span class="fa fa-power-off d-inline"></span>&nbsp;&nbsp;Salir
							</a>
							<script>
								function confirmar1(url){
									if(confirm('¿Seguro que deseas Salir del Sistema?')){
										window.location=url;
									}else{
										return false;
									}	
								}
							</script>
						</div>
					</div>
					<div class="d-inline d-md-none p-0 m-0">
						<div class="container-fluid w-100 p-0 m-0">
							<div class="row w-100 border-bottom border-danger">
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="perfil_de_usuario.php" title="Ver o modificar tus datos personales"><span class="fa fa-user-circle-o d-inline"></span>&nbsp;Perfil</a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="instructivo.php" title="Ver Instructivo del Sitio"><span class="fa fa-book d-inline"></span>&nbsp;Instruc</a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="salir.php" title="Salir del sistema" onclick="return confirmar2('salir.php')">
										<span class="fa fa-power-off d-inline"></span>&nbsp;Salir
									</a>
									<script>
										function confirmar2(url){
											if(confirm('¿Seguro que deseas Salir del Sistema?')){
												window.location=url;
											}else{
												return false;
											}	
										}
									</script>
								</div>
							</div>
							<div class="row w-100 border-bottom border-danger">
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_plan.php" title="Ver, cargar, modificar o eliminar los planes asociados a tu cargo actual">
										<span class="fa fa-bar-chart-o d-inline">&nbsp;Plan</span>
										<?php
											if($verf_user_plan>0){
												echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_plan</b></span>";
											}
										?>
									</a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_real.php" title="Ver, cargar, modificar o eliminar los actividades reales asociados a tu cargo actual">
										<span class="fa fa-tasks d-inline">&nbsp;Real</span>
										<?php
											if($verf_user_real>0){
												echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_real</b></span>";
											}
										?>
									</a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_real_adic.php" title="Ver, cargar, modificar o eliminar tus actividades adicionales">
										<span class="fa fa-line-chart d-inline">&nbsp;Adic</span>
										<?php
											if($verf_user_real_adc>0){
												echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_real_adc</b></span>";
											}
										?>
									</a>
								</div>
							</div>
							<div class="row w-100 border-bottom border-danger">
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_inventario_general.php" title="Ver resumen de tu inventario actual"><span class="fa fa-cubes d-inline">&nbsp;Inv</span></a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_inventario_entregar.php" title="Entregar artículos de tu inventario a otro empleado o cliente"><span class="fa fa-mail-forward d-inline">&nbsp;Ent</span></a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" title="Confirmar la recepción de artículos de otro empleado o proveedor" href="usuario_inventario_recibir.php">
										<span class="fa fa-mail-reply d-inline">&nbsp;Rec</span>
										<?php
											if($verf_user_recibir>0){
												echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_recibir</b></span>";
											}
										?>
									</a>
								</div>
							</div>
							<div class="row w-100">
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_explicaciones.php" title="Ver o modificar las explicaciones de la desviación Plan vs Real"><span class="fa fa fa-question-circle-o d-inline">&nbsp;Expl<span></a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_inventario_en_transito.php" title="Ver envios que están pendientes por confirmación de quién recibe">
										<span class="fa fa-truck d-inline">&nbsp;Trán</span>
										<?php
											if($verf_user_transito>0){
												echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_user_transito</b></span>";
											}
										?>
									</a>
								</div>
								<div class="col-4 w-100">
									<a class="d-block text-light text-left" href="usuario_aprobar.php" title="Ver Planes y Actividades pendientes por aprobar y rechasadas para tus supervisados">
										<span class="fa fa-thumbs-up d-inline"></span>&nbsp;Aprb
										<?php
											if($verf_aprobar>0){
												echo "<span class='text-warning fa fa-bell-o'><b class='small'>$verf_aprobar</b></span>";
											}
										?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>
<!-------------------- BARRA ASIDE ------------------------------------>
<section class="container-fluid pt-2 mt-5 mb-5 bg-dark">
	<div class="row">
		<!-- Sidebar  -->
		<aside class="col-0 col-md-2 d-none d-md-inline-block bg-dark pre-scrollable">
			<?php require("php_require/menu_lateral.php") ?>
		</aside>
		<!------------ INICIO DE LA SECCION DE CONTENIDO DE LA PAGINA -------------------->
		<!-- Page Content  -->
		<div class="col-12 col-md-10 border-left border-dark bg-light pre-scrollable">
		