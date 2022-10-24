<?php
	require ("php_require/conexion.php");
	$consulta="SELECT `TIPO_DEPARTAMENTO`, `DEPARTAMENTO` FROM `descripcion_de_cargos` WHERE `DEPARTAMENTO`='$usuario_departamento' GROUP BY `TIPO_DEPARTAMENTO`, `DEPARTAMENTO` ORDER BY `TIPO_DEPARTAMENTO`, `DEPARTAMENTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		//CREANDO ARRAYS PARA LOS DATOS
		$tipo_departamentos_i[$i]=$fila['TIPO_DEPARTAMENTO'];
		$departamentos_i[$i]=$fila['DEPARTAMENTO'];
		$i=$i+1;
	}
?>
<ul class="list-unstyled components">
	<li class="text-center h6 mt-2">
		<a href="zona_principal.php" class="text-light" title="Ir al Inicio"><b class="text-light fa fa-home"></b> Principal</a>&nbsp;&nbsp;&nbsp;
	</li>
	<!-- SOLO PARA GERENTES -->
	<?php 
		$cargo_partes1=explode(" ",$usuario_cargo);
		if($usuario_correo=="ortizjx@pdvsa.com" or 
		   $cargo_partes1[0]=="GERENTE" or 
		   $cargo_partes1[0]=="GTE" or 
		   $cargo_partes1[0]=="Gerente" or 
		   $cargo_partes1[0]=="gerente" or 
		   $cargo_partes1[0]=="Gte" or 
		   $cargo_partes1[0]=="GERENTE." or 
		   $cargo_partes1[0]=="GTE." or 
		   $cargo_partes1[0]=="Gerente." or 
		   $cargo_partes1[0]=="gerente." or 
		   $cargo_partes1[0]=="Gte."){
	?>
	<li class="text-center h6 mt-2">
		<a href='rdc_general.php' class='text-light' title="Ir al Resumen General de Gestión"><b class='text-light fa fa-bar-chart-o'></b> Plan-Real</a>&nbsp;
	</li>
	<li class="text-center h6 mt-2">
		<a href='rdc_adicional_general.php' class='text-light' title="Ir al Resumen General de Actividades Adicionales Ejecutadas"><b class='text-light fa fa-line-chart'></b> Real-Adic</a>&nbsp;
	</li>
	<li class="text-center h6 pb-2 mt-2">
		<a href='inventario_general.php' class='text-light' title="Ir al Reumen General de Inventario"><b class='text-light fa fa-cubes'></b> Inventario</a>
	</li>
	<?php 
		}
	?>
	<!-- DEPARTAMENTO -->
	<li class="text-center h6 border-bottom border-top border-danger py-1 mt-1">
		<a href='#submenudepartamento' data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-light" title="Mostrar opciones por departamnto"><?php echo $departamentos_i[0]; ?></a>
	</li>
	<ul class="collapse list-unstyled" id="submenudepartamento">
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href='rdc_departamentos.php?departamento=<?php echo $departamentos_i[0]; ?>' class='text-light' title="Ver el Resumen de Gestión del Departamento">Plan-Real</a></li>
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href='rdc_adicional_departamento.php?departamento=<?php echo $departamentos_i[0]; ?>' class='text-light' title="Ver el Resumen de Actividades Adicionales">Real-Adic</a></li>
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href='inventario_departamentos.php?departamento=<?php echo $departamentos_i[0]; ?>' class='text-light' title="Ver el Resumen de Inventario del Departamento">Inventario</a></li>
	</ul>
	<!-- OTROS SERVICIOS -->
	<li class="text-center h6 border-bottom border-top border-danger py-1 mt-1">
		<a href="#submenuprincipalOtros" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-light" title="Mostrar otras opciones del sitio">Otros</a>
	</li>
	<!-- TOOGLE ADMINISTRATIVAS -->
	<ul class="collapse list-unstyled" id="submenuprincipalOtros">
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href="instructivo.php" class="text-light" title="Ver Instructivo del Sitio">Instructivo</a></li>
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href="ver_organigrama.php" class="text-light" title="Ver Organigrama de la Empresa">Estructura</a></li>
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href="ver_directorio.php" class="text-light" title="Ver Directorio telefónico de la Empresa">Directorio</a></li>
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href="ver_comentarios.php" class="text-light" title="Ver Comentarios recibidos a través del portal del Sitio">Mensajes</a></li>
		<li><span class='text-muted fa fa-cog fa-spin'></span> <a href="ver_candidatos.php" class="text-light" title="Ver Resumen Curricular de los Postulados a través del portal del Sitio">Postulados</a></li>
	</ul>
		<?php 
			if($usuario_correo=="ortizjx@pdvsa.com" or $usuario_cargo=="COORDINADOR DE PPyG"){
		?>
	<!-- ADMINISTRACIÓN DEL SITIO -->
	<li class="text-center h6 border-bottom border-top border-danger py-1 mt-1">
		<a href="#submenuAdm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-light" title="Mostrar tablas de la Base de Datos">Adm - Sitio</a>
	</li>
	<ul class="collapse list-unstyled" id="submenuAdm">
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_usuarios.php" class="text-light" title="CRUD para la tabla de &laquo;usuarios&raquo;">Usuarios</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_cargos.php" class="text-light" title="CRUD para la tabla de &laquo;descripcion_de_cargos&raquo;">Cargos</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_postulados.php" class="text-light" title="CRUD para la tabla de &laquo;postulados&raquo;">Postulados</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_comentarios.php" class="text-light" title="CRUD para la tabla de &laquo;concatactanos&raquo;">Contactos</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_planes.php" class="text-light" title="CRUD para la tabla de &laquo;planes&raquo;">Plan</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_reales.php" class="text-light" title="CRUD para la tabla de &laquo;reales&raquo;">Real</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_reales_adicional.php" class="text-light" title="CRUD para la tabla de &laquo;reales_adicionales&raquo;">Real-Adic</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_inv_categorias.php" class="text-light" title="CRUD para la tabla de &laquo;inventario_categorias&raquo;">Inv-Cat</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_inv_articulos.php" class="text-light" title="CRUD para la tabla de &laquo;inventario_acticulos&raquo;">Inv-Art</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_inv_clientes.php" class="text-light" title="CRUD para la tabla de &laquo;inventario_cliente/proveedor&raquo;">Inv-Prov</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_inv_traspasos.php" class="text-light" title="CRUD para la tabla de &laquo;inventario_operaciones&raquo;">Inv-Mov</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="CRUD_portada_serv.php" class="text-light" title="CRUD para la tabla &laquo;portada: Servicios&raquo;">Port-Serv</a>
		</li>
		<li>
			<span class="text-muted fa fa-cog fa-spin"></span> <a href="RU_portada_otros.php" class="text-light" title="RU para la tabla &laquo;portada: Otros&raquo;">Port-Otros</a>
		</li>
	</ul>
		<?php	
			}
		?>
</ul>
