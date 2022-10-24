<?php
	require ("php_require/comprueba_session.php");
	require ("php_require/conexion.php");
	require("php_require/fecha_y_pagina.php");
	require("php_require/obtiene_usuario.php");
?>
<!doctype html>
<html>
<head>
	<?php require("php_require/head.php"); ?>
	<title>SIG-SSP: Instructivo</title>
</head>
<body>
	<?php require("php_require/nav_usuarios.php") ?>
	<section id="content" class="container-fluid text-justify">
		<b id="tabla_contenido"></b><br><br>
		<!--TABLA DE CONTENIDO-->
		<h2 class="mt-1 my-2 py-2 text-center">&laquo; CONTENIDO DEL INSTRUCTIVO &raquo;</h2>
		<ul class="container-fluid mb-3 pb-4 border-bottom text-left h4">
			<div class="mb-1"><a href="instructivo.php#funcinamiento_del_sitio"><span class="text-danger fa fa-cog fa-spin"></span> Sobre el funcinamiento del Sitio Web:</a></div>
			<div class="mb-1"><a href="instructivo.php#perfiles_de_usuario"><span class="text-danger fa fa-cog fa-spin"></span> Sobre los perfiles de usuario:</a></div>
			<div class="mb-1"><a href="instructivo.php#cargar_nuevo_usuario"><span class="text-danger fa fa-cog fa-spin"></span> Crear un Nuevo Usuario:</a></div>
			<div class="mb-1"><a href="instructivo.php#barra_lateral"><span class="text-danger fa fa-cog fa-spin"></span> Barra lateral de Navegación (BLN):</a></div>
			<div class="mb-1"><a href="instructivo.php#opciones_de_usuario"><span class="text-danger fa fa-cog fa-spin"></span> Opciones de Usuario (OS):</a></div>
		</ul>
		<!--FIN DE LA TABLA DE CONTENIDO-->
		<!--NUEVO INSTRUCTIVO-->
		<b id="funcinamiento_del_sitio"></b><br><br><br>
		<div class="row">
			<div class="col-11 text-justify">
				<h3><span class="text-danger fa fa-cog fa-spin"></span> Sobre el funcinamiento del Sitio Web:</h3>
			</div>
			<div class="col-1 text-right">
				<h3><a href="instructivo.php#tabla_contenido"><span class="text-danger fa fa-arrow-up"></span></a></h3>
			</div>
		</div>
		<div class="container border-bottom pb-3 ml-4 text-justify">
			<p><b>¿PARA QUÉ SIRVE?</b> Este sistema fue diseñado para empresas del sector petrolero que prestan servicios de Perforación, Rehabilitación y Reparación de pozos de petróleo y Gas, con la finalidad de controlar los principales indicadores de gestión de la empresa, así como controlar los inventarios de Materiales, Equipos y Consumibles.</p>
			<p><b>¿QUÉ CONTIENE?</b> Esta herramienta cuenta con:</p>
			<ul>
				<li>
					<p>Una <b>&laquo;Sección de Inicio&raquo;</b> donde se puede ver:</p>
					<ul>
						<li>Una puerta de acceso <b>&laquo;Sólo para empleados&raquo;</b> a la que se accesde desde la barra de navegacion superior del sitio.</li>
						<li>Los servicios que presta la empresa.</li>
						<li>Un buzón de contactos o sugerencias que puede ser utilizado por quienes visiten el sitio web.</li>
						<li>Otra información general de la empresa como Misión, Visión Valores, politicas de privacidad, condiciones de uso, entre otros.</li>
						<li>Una buzón para registrar resumen curricular que puede ser utilizado por quienes visiten el sitio web.</li>
					</ul>
					<p class="mt-2">Todas estas opciones son totalmente editables para el administrador del sitio.</p> 
				</li>
				<li>
					<p>Una <b>&laquo;Sección de Usuario&raquo;</b> donde se puede:</p>
					<ul>
						<li>Acceder a la Barra Lateral de Navegación (BLN).</li>
						<li>Opciones de Usuario (OS).</li>
					</ul>
					<p class="mt-2">Estos menus le permiten a los trabajadores de la empresa llevar un control sobre su gestión y sus inventarios. Los mismos se explican con detalle más adelante en este instructivo.</p> 
				</li>
			</ul>
			<p><b>IMPORTANE:</b> El sistema de indicadores, sólo considera actividades debidamente aprobadas por el supervisor inmediato de cada empleado.</p>
		</div>
		<!--NUEVO INSTRUCTIVO-->
		<b id="perfiles_de_usuario"></b><br><br><br>
		<div class="row">
			<div class="col-11 text-justify">
				<h3><span class="text-danger fa fa-cog fa-spin"></span> Sobre los perfiles de usuario:</h3>
			</div>
			<div class="col-1 text-right">
				<h3><a href="instructivo.php#tabla_contenido"><span class="text-danger fa fa-arrow-up"></span></a></h3>
			</div>
		</div>
		<div class="container border-bottom pb-3 ml-4 text-justify">
			<ul>
				<li>Todos los Usuarios pueden visualisar en la Barra Lateral de Navegación (BLN) la información asociada a Plan de Actividades, Actividades Reales (Asociadas al Plan), Actividades Adicionales e Inventario, para sus respectivos Departamentos.</li>
				<li>Todos los Usuarios pueden acceder a sus opciones de usuario desde la barra de navegación superior de Opciones de Usuario (OS), las cuales incluyen modificar sus datos personales, modificar sus actividades planificadas, reales y adicionales, aprobar o rechasar actividades de sus supervisados y llevar el control sobre su inventario.</li>
				<li>Sólo aquellos usuarios con cargos de Gerenciales podran visualizar adicionalmente la gestión completa de la información para todos sus departamentos y los del resto de la empresa.</li>
				<li>El administrador del sitio tendra los mismos privilegios de acceso que los Gerentes y adicionalmente podrá modificar, insertar y eleminar la información de las tablas que conienen la información del sitio.</li>
				<li>El administrador no endrá acceso a las contraseñas de usuarios.</li>
			</ul>
			<p><b>IMPORTANTE:</b> El administrador del sitio deberá realizar copias de la Base de datos periódicamente (MySQL), con la finalidad de llevar un respaldo de la información en caso de fallos.</p>
		</div>
		<!--NUEVO INSTRUCTIVO-->
		<b id="cargar_nuevo_usuario"></b><br><br><br>
		<div class="row">
			<div class="col-11 text-justify">
				<h3><span class="text-danger fa fa-cog fa-spin"></span> Crear un Nuevo Usuario:</h3>
			</div>
			<div class="col-1 text-right">
				<h3><a href="instructivo.php#tabla_contenido"><span class="text-danger fa fa-arrow-up"></span></a></h3>
			</div>
		</div>
		<div class="container border-bottom pb-3 text-justify">
			<p>Para crear un nuevo usuario en el sistema de seben seguir los siguientes pasos:</p>
			<ul>
				<li>El administrador del Sitio debe ingresar a &laquo;Otros -> Adm. del Sitio -> Usuarios&raquo; de la barra de menu lateral e ingresar todos los datos del nuevo usuario que aparecen en la opción "<b class="text-primary"><span class="fa fa-share-square-o"></span> Insertar</b>" del encabezado de la Tabla de Usuarios.</li>
				<li>El administrador de la tabla de usuarios debe Entregar al Nuevo Usuario los datos de: "Número de Empleado" y "Fecha de Ingreso".</li>
				<li>El Usuario debe ingresar al sitio y en el apartado "Ingresa" de la barra de navegación del "Inicio" marcar la opción "¿Olvidó sus datos?".</li>
				<li>Ingresa los datos de: "Número de Empleado" y "Fecha de Ingreso" además de su "Fecha de Nacimiento" y "Cédula de Identidad".</li>
				<li>El sistema generará una clave de acceso temporal que junto con su correo eléctrónico, serán los datos con los que deberá ingresar por primera vez al sitio "Solo para Empleados" en el apartado "Ingresa" de la barra de navegación de la página de "Inicio".</li>
				<li>Una vez en la pantalla principal de Usuario ir al menu de navegación superior e ingrsar en &laquo;Mis Datos&raquo; para cambiar la contraseña temporal por una definitiva.</li>
			</ul>
			<p><b>IMPORTANTE:</b> No pierda sus datos de: "Número de Empleado" y "Fecha de Ingreso", ya que son indispensables para recuparar su clave de acceso.</p>
		</div>
		<!--NUEVO INSTRUCTIVO-->
		<b id="barra_lateral"></b><br><br><br>
		<div class="row">
			<div class="col-11 text-justify">
				<h3><span class="text-danger fa fa-cog fa-spin"></span> Barra lateral de Navegación (BLN):</h3>
			</div>
			<div class="col-1 text-right">
				<h3><a href="instructivo.php#tabla_contenido"><span class="text-danger fa fa-arrow-up"></span></a></h3>
			</div>
		</div>
		<div class="container border-bottom pb-3 ml-4 text-justify">
			<p>Esta Barra aparece en la parte izquierda en la zona de usuarios y está constituida por las siguientes opciones:</p>
			<ul>
				<li><span class="fa fa-home"></span> <b>Principal:</b> Página de acceso general de bienvenida.</li>
				<li><span class="fa fa-bar-chart-o"></span> <b>Plan-Real:</b> Sólo para Gerentes. Muestra Gráficamente los indicadores de Gestión que comparan las actividades planificadas contra las reales. Permite filtrar la información por Año, Gerencia, Departamento, Unidad de Medida, Cargo, Meta y/o Empleado, lo que facilita el análisis de los datos y permite hallar los puntos críticos. Adicionalmente cuenta con una tabla donde se pueden revisar las explicaiones indicadas por los responsables de las actividades sobre los desfaces entre Plan y Real. Por último, para cada explicación se puede desplegar un detalle adicional donde se muestra el calendarizado Plan-Real de la meta y un listado con el detalle de cada actividad real aprobada hasta la fecha.</li>
				<li><span class="fa fa-line-chart"></span> <b>Real-Adic:</b> Sólo para Gerentes. Muestra Gráficamente los indicadores de Gestión que comparan las actividades planificadas contra las reales. Permite filtrar la información por Año, Gerencia, Departamento, Unidad de Medida, Cargo y/o Empleado, lo que facilita el análisis de los datos. Adicionalmente se muestra una tabla con el detalle de cada actividad adicional aprobada.</li>
				<li><span class="fa fa-cubes"></span> <b>Inventario:</b> Sólo para Gerentes. Muestra Gráficamente las cantidades de artículos existentes en el inventario de la emresa. Permite filtrar la información por Gerencia, Departamento, Empleado, Categoría y/o Artículo, lo que facilita el análisis de la situación de los invntarios. También se muestra una tabla con el balance de entrada y salida de cada artículo del que se puede desplegar el historial de movimientos de dicho artículo.</li>
				<li><b>Departamento - Plan-Real:</b> Al igual que "<span class="fa fa-bar-chart-o"></span> <b>Plan-Real</b>" muestra los datos de Gestión contenidos en el sistema pero sólo para el departamento en el que trabaja el usuario.</li>
				<li><b>Departamento - Real-Adic:</b> Al igual que "<span class="fa fa-line-chart"></span> <b>Real-Adic</b>" muestra los datos de Gestión Adicional contenidos en el sistema pero sólo para el departamento en el que trabaja el usuario.</li>
				<li><b>Departamento - Inventario:</b> Al igual que "<span class="fa fa-cubes"></span> <b>Inventario</b>" muestra los datos de Inventario contenidos en el sistema pero sólo para el departamento en el que trabaja el usuario.</li>
				<li><b>Otros - Instructivo:</b> Página de acceso general en la que se muestra el instuctivo de uso del sitio web.</li>
				<li><b>Otros - Estructura:</b> De acceso general, permite dar un vistaso a la estructura organizacional de la empresa, permitiendo hacer busqueda de personas, exportar la extructura, ver una tabla con el detalle de la misma y hacer zoom.</li>
				<li><b>Otros - Directorio:</b> Muestra a todos los empleados el directorio telefónico de la empresa, mostrando el cargo, teléfono, correo eléctronico y una imagen del trabajador.</li>
				<li><b>Otros - Mensajes:</b> De acceso general, le permite a los empleados ver los comentarios dejados por los usurios del sitio web (potenciales clientes / proveedores). Una vez ingresados los comentarios de contacto, la información sólo puede ser modificada o eliminada por el administrador del sitio.</li>
				<li><b>Otros - Postulados:</b> Permite visualizar los datos de posibles candidatos a nuevos empleados facilitando las labores de reclutamient por parte de Recursos Humanos. En esta sección se pueden ver todos los detalles del aspirante incluyendo su resumen curricular en PDF. Una vez ingresados los datos de postulación, la información sólo puede ser modificada o eliminada por el administrador del sitio. Esta página es de aceso general.</li>
				<li><b>Administración del Sitio:</b> De uso exclusivo del administrador del sitio. En esta sección se despliegan todas las tablas de la base de datos del sitema (en lenguaje MySQL). A través de esta sección el administrador del sitio web podrá visualizar, insertar, modificar o eliminar información de la base de datos la cual está compuesta por las siguientes tablas:
					<table class="table border-dark border w-50 mx-auto my-3 text-center">
						<tr>
							<th class="border-dark border-top">Usuarios</th>
							<th class="border-dark border-top" style="background-color: #ccc;">Cargos</th>
							<th class="border-dark border-top">Postulados</th>
						</tr>
						<tr>
							<th style="background-color: #ccc;">Contactos</th>
							<th>Plan</th>
							<th style="background-color: #ccc;">Real</th>
						</tr>
						<tr>
							<th>Real-Adic</th>
							<th style="background-color: #ccc;">Inv-Cat</th>
							<th>Inv-Art</th>
						</tr>
						<tr>
							<th style="background-color: #ccc;">Inv-Prov</th>
							<th>Inv-Mov</th>
							<th style="background-color: #ccc;">Port-Serv</th>
						</tr>
						<tr>
							<th>Port-Otros</th>
							<th style="background-color: #ccc;"></th>
							<th></th>
						</tr>
					</table>
					<p class="mt-2"><b>NOTA:</b> Si desea ver las <b><a href="img/RELACION.pdf" target="_blank" onclick="window.open(this.href, this.target, 'width=800,height=600'); return false;">estructuras de estas tablas</a></b> así como las relaciones entre las mismas haga <b><a href="img/RELACION.pdf" target="_blank" onclick="window.open(this.href, this.target, 'width=800,height=600'); return false;">click aquí</a></b></p>
				</li>
			</ul>
			<p class="mt-2"><b>IMPORTANTE:</b> El sistema de indicadores, sólo considera actividades debidamente aprobadas por el supervisor inmediato de cada empleado.</p> 
		</div>
		<!--NUEVO INSTRUCTIVO-->
		<b id="opciones_de_usuario"></b><br><br><br>
		<div class="row">
			<div class="col-11 text-justify">
				<h3><span class="text-danger fa fa-cog fa-spin"></span> Opciones de Usuario (OS):</h3>
			</div>
			<div class="col-1 text-right">
				<h3><a href="instructivo.php#tabla_contenido"><span class="text-danger fa fa-arrow-up"></span></a></h3>
			</div>
		</div>
		<div class="container border-bottom pb-3 ml-4 text-justify">
			<p>Esta Barra aparece en la parte superior de la zona principal de usuarios, muestra la foto de perfil y el nombre del usuario. Desde este menú se puede acceder a las siguientes opciones:</p>
			<ul>
				<li><span class="fa fa-user-circle-o"></span> <b>Mi Perfil:</b> En esta página se muestran 3 secciones. En la primera se muestran los datos permanetes del usuario. En la segunda el usuario podrá modificar su dirección de oficina, correo, teléfono y foto del perfil. Finalmente en la tercera, puede realiza cambio de contraseña. Es importante que el empleado recuerde su Número de Empleado y tu Fecha de Ingreso, ya que son indispensables para recuperar su contraseña. Adicionalmente, al final de esta sección, se muestran las responsabilidades de su cargo.</li>
				<li><span class="fa fa-bar-chart-o"></span> <b>Plan:</b> Le permite al empleado visualizar, crear, modificar y/o eliminar los renglones planificados asociados a su cargo actual (estos renglones son anuales). Los valores mensuales se deben reportar de forma puntual (no acumulativa). Una vez creada una nueva Actividad Planificada o modificada alguna existente, se debe esperar a la aprobación de su supervisor para poder visualizar este dato dentro de los indicadores de gestión. Podrá visualizar los renglónes rechasados por su jefe filtrando por "NO" en la columna "Aporbado" para ver el "Por Qué" del rechaso y corregir.</li>
				<li><span class="fa fa-tasks"></span> <b>Real:</b> Le permite al empleado visualizar, crear, modificar y/o eliminar los renglones reales asociados a la planificación de su cargo actual. Una vez creada una nueva Actividad Real o modificada alguna existente, se debe esperar a la aprobación de su supervisor para poder visualizar este dato dentro de los indicadores de gestión. Podrá visualizar los renglónes rechasados por su jefe filtrando por "NO" en la columna "Aporbado" para ver el "Por Qué" del rechaso y corregir.</li>
				<li><span class="fa fa-line-chart"></span> <b>Adiciconal:</b> Le permite al empleado visualizar, crear, modificar y/o eliminar los renglones reales asociados a la planificación de su cargo actual. Una vez creada una nueva Actividad Adicional o modificada alguna existente, se debe esperar a la aprobación de su supervisor para poder visualizar este dato dentro de los indicadores de gestión. Podrá visualizar los renglónes rechasados por su jefe filtrando por "NO" en la columna "Aporbado" para ver el "Por Qué" del rechaso y corregir.</li>
				<li><span class="fa fa-question-circle-o"></span> <b>Explicaciones:</b> Cada trabajador con actividades planificadas dentro del sistema deberá modificar mensualmente estos renglones para el año en curso, de manera de actualizar los motivos de la desviación entre el plan y el real para cada actividad que desarrolle dentro de la empresa (Esta explicación no considera las actividades adicionales realizadas por el trabajador fuera de lo planificado).</li>
				<li><span class="fa fa-thumbs-up"></span> <b>Aprobar:</b> Le Permite a los empleados que tengan personal a su cargo, aprobar o rechasar las actividades cargadas en el sistema (PLan, Real y/o Actividades Adicionales). En esta sección también podrá ver el estatus de las actividades que haya rechasado para asegurar que las mismas sean corregidas para su aprobación o eliminadas del sistema por la persona a su cargo a quién corresponda.</li>
				<li><span class="fa fa-cubes"></span> <b>Inventario:</b> Muestra las existencias de cada artículo que se encuentra bajo la custodia del empleado y permite ver un detalle con el histórico de movimientos realizados por el trabajador.</li>
				<li><span class="fa fa-mail-forward"></span> <b>Entregar:</b> Permite entregar artículos que estén bajo su custodia, a otro empleado o cliente. Se debe tener la confirmación de recibido de parte del destinatario para que el sistema considere que el articulo a dejado de ser suyo.</li>
				<li><span class="fa fa-mail-reply"></span> <b>Recibir:</b> Permite confirmar que se ha recibido algún artículo proveniente de otro empleado o proveedor. Se debe tener la confirmación de recibido para que el sistema considere que el articulo se a asignado a usted.</li>
				<li><span class="fa fa-truck"></span> <b>en Tránsito:</b> Permite visualizar los artículos en tránsito para los cuales aún no se ha registrado la confirmación de recibido.</li>
				<li><span class="fa fa-power-off"></span> <b>Salir:</b> Cierra la seción de usuario y vuelve a la página de inicio del sitio web. Para abrir unae una sección adicional desde un mismo computador con sistema operativo Windows, se debe usar otro navegador diferente.</li>
			</ul>
			<p class="mt-2"><b>IMPORTANTE:</b> Cada opción cuenta con un indicador que alertará al usuario cuando tenga información importante que revisar con el icono <span class="bg-dark text-warning fa fa-bell-o px-1"></span> seguido de la cantidad de Items asociados.</p>
		</div>
		<br><br>
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
		$('#dataTable').DataTable();
	});
</script>
<?php
mysqli_close($conexion);
?>