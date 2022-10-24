<div id="organigrama_1" class="container-fluid border mb-5" style="height: 400px;"></div>
<?php
	$consulta="SELECT 
	`descripcion_de_cargos`.`CARGO` AS CARGO,
	`descripcion_de_cargos`.`JEFE` AS JEFE,
	`usuarios`.`NOMBRE` AS NOMBRE,
	`usuarios`.`APELLIDO` AS APELLIDO,
	`usuarios`.`CORREO` AS CORREO
	FROM `descripcion_de_cargos` LEFT JOIN `usuarios` ON `descripcion_de_cargos`.`CARGO` = `usuarios`.`CARGO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos_cargos['CARGO'][$i]=$fila['CARGO'];
		$datos_cargos['JEFE'][$i]=$fila['JEFE'];
		$datos_cargos['NOMBRE_APELLIDO'][$i]=$fila['NOMBRE'] . ", " . $fila['APELLIDO'];
		$datos_cargos['CORREO_FOTO'][$i]=$fila['CORREO'];
		$i=$i+1;
	}
?>
<script>
var orgchart = new getOrgChart(document.getElementById("organigrama_1"), {					theme: "deborah",//EDITAR TEMA: 
	//annabel,sara,belinda,cassandra,deborah,lena,monica,ula,eve,tal,vivian,ada,helen
	color: "black",//COLOR DE FONDO
	enableEdit: false,//EVITAR EDICION
	enableZoom: true,//DESABILITAR ZOOM
	enableSearch: true,//DESABILITAR BUSCADOR
	enableMove: true,//DESABILITAR MOVER
	enableGridView: true,//DESABILITAR VISTA DE TABLA DE DATOS
	enableDetailsView: false,//DESABILITAR VISTA DE PERFIL DE PERSONA
	enablePrint: true,//DESABILITAR OPCION DE IMPRIMIR
	enableZoomOnNodeDoubleClick: true,//DESABILITAR OPCION DE ZOOM DOBLECLICK
	enableExportToImage: true,//DESABILITAR OPCION DE EXPORTAR IMAGEN
	scale: 0.2,//ESCALA
	linkType: "M",//LINEAS RECTAS "M" LINEAS CURVAS "B"
	orientation: getOrgChart.RO_TOP,//FORMA DE DISTRIBUCIÓN DEL ORGANIGRAMA
	primaryFields: ["name", "title"],//TEXTOS EN LA TARJETA
	idField: "Key",//IDENTIFICADOR DEL NIVEL
	parentIdField: "parentKey",//IDENTIFICADOR DEL NIVEL PADRE
	secondParentIdField: "secondManager",//JEFE INDIRECTO
	levelSeparation: 50,//SEPARACION ENTRE NIVELES (PADRES E HIJOS)
	siblingSeparation: 20,//SEPARACION ENTRE CAJAS HERMANAS HORIZONTAL
	subtreeSeparation: 40,//SEPARACION ENTRE CAJAS PRIMAS HORIZONTAL
	expandToLevel: 6,//NIVELES EXPANDIDOS POR DEFECTO
	photoFields: ["pic"],//CLAVE PARA FOTO
	dataSource: [
		<?php
			$i=0;
			while(isset($datos_cargos['CARGO'][$i])){
				$array_abreviaturas=[
					"ANALISTA DE AIT"=>"Analista AIT",
					"ASISTENCIA A LA PRESIDENCIA"=>"Asist Pdte",
					"AUDITOR INTERNO"=>"Auditor",
					"CONSULTOR JURIDICO"=>"Cons Jurídico",
					"COORDINADOR DE AIT"=>"Cord AIT",
					"COORDINADOR DE CONTRATACIÓN"=>"Cord Contratación",
					"COORDINADOR DE ESTIMACIÓN Y EVALUACIÓN DE COSTOS"=>"Cord Est Costos",
					"COORDINADOR DE FINANZAS"=>"Cord Finanzas",
					"COORDINADOR DE GESTIÓN DE CALIDAD"=>"Cord Calidad",
					"COORDINADOR DE GESTION DE HES"=>"Cord HES",
					"COORDINADOR DE INGENIERIA"=>"Cord Ingeniería",
					"COORDINADOR DE LOGÍSTICA"=>"Cord Logística",
					"COORDINADOR DE MANTENIMIENTO"=>"Cord Mtto",
					"COORDINADOR DE PCP"=>"Cord PCP",
					"COORDINADOR DE PPyG"=>"Cord PPyG",
					"COORDINADOR DE PROCURA Y ALMACEN"=>"Cord Proc/Almacén",
					"COORDINADOR DE RECURSOS HUMANOS"=>"Cord RRHH",
					"COORDINADOR DE SEGURIDAD INDUSTRIAL - HIGIENE OCUPACIONAL"=>"Cord SIAHO",
					"COORDINADOR DE SERVICIOS GENERALES"=>"Cord SSGG",
					"GERENTE ADMINISTRATIVO"=>"Gte Administrativo",
					"GERENTE DE OPERACIONES"=>"Gte Operaciones",
					"GERENTE GENERAL"=>"Gte General",
					"LIDER DE OPERACIONES CON GUAYA"=>"Lid Oper Guaya",
					"LIDER DE OPERACIONES DE CEMENTACIÓN Y BOMBEO"=>"Lid Oper Cement",
					"LIDER DE OPERACIONES DE COIED TUBING"=>"Lid Oper CT",
					"LIDER DE OPERACIONES DE SÍSMICA"=>"Lid Oper Sísmica",
					"LIDER DE OPERACIONES DE TALADRO"=>"Lid Oper Taladro",
					"LIDER DE OPERACIONES DE WELL TESTING"=>"Lid Oper WT",
					"PRESIDENTE"=>"Presidente",
					"SUPERINTENDENTE DE OPERACIONES DE SÍSMICA"=>"Spte Oper Sísmica",
					"SUPERINTENDENTE DE OPERACIONES DE TALADRO"=>"Spte Oper Taladro",
					"SUPERINTENDENTE DE OPERACIONES PARA LINEAS DE SERVICIOS A POZOS"=>"Spte Oper LSP",
					"ANALISTA MANTENIMIENTO MECANICO SISMICA"=>"Analista Mtto Sísmica",
					"TECNICO OPERADOR DE EQUIPOS DE CEMENTACIÓN Y BOMBEO"=>"Operador Cement",
					"INGENIERO MAYOR DE CEMENTACIÓN Y BOMBEO"=>"Ing. Cement",
					"TECNICO DE EQUIPO DE CEMENTACION Y BOMBEO"=>"Técnico Cement",
					"SUPERVISOR CEMENTACION Y BOMBEO"=>"Sup Cement",
					"TECNICO DE LOGISTICA CEMENTACIÓN Y BOMBEO"=>"Tec Log Cement",
					"TECNICO TUBERIA CONTINUA"=>"Tec CT",
					"OPERADOR DE NITROGENO PARA TUBERÍA CONTINUA"=>"Oper Nit CT",
					"INGENIERO DE OPERACIONES TUBERIA CONTINUA "=>"Ing CT",
					"OPERADOR DE TUBERIA CONTINUA"=>"Oper CT",
					"INGENIERO MAYOR DE TUBERIA CONTINUA"=>"Ing May CT",
					"null"=>"null"
				];
				//HACIENDO NULL LOS CAMPOS EN BLANCO
				if($datos_cargos['CARGO'][$i]==""){$datos_cargos['CARGO'][$i]="null";}
				if($datos_cargos['JEFE'][$i]==""){$datos_cargos['JEFE'][$i]="null";}
				if($datos_cargos['NOMBRE_APELLIDO'][$i]==", "){$datos_cargos['NOMBRE_APELLIDO'][$i]="Vacante";}
				if($datos_cargos['CORREO_FOTO'][$i]==""){$datos_cargos['CORREO_FOTO'][$i]="vacio";}
				//IMPRIMIENDO DATOS
				echo "{Key: '" . $datos_cargos['CARGO'][$i];
				echo "', parentKey: '" . $datos_cargos['JEFE'][$i];
				echo "', name: '" . $datos_cargos['NOMBRE_APELLIDO'][$i] . "', 
				title: '";
				if(isset($array_abreviaturas[$datos_cargos['CARGO'][$i]])){
					echo $array_abreviaturas[$datos_cargos['CARGO'][$i]];
				}else{
					echo $datos_cargos['CARGO'][$i];
				}
				echo "', pic: 'fotos_del_personal/" . $datos_cargos['CORREO_FOTO'][$i] . ".png'}";
				$e=$i+1;
				if(isset($datos_cargos['CARGO'][$e])){
					echo ",";
				}
				$i=$i+1;
			}
		?>
	],
	customize: {
		"Presidente": { color: "darkred", siblingSeparation: "100" },
		"Gte General": { color: "darkred" },
		"Gte Administrativo": { color: "darkred" },
		"Gte Operaciones": { color: "darkred" },
		"Asist Pdte": { color: "blue" },
		"Cons Jurídico": { color: "blue" },
		"Cord AIT": { color: "blue" },
		"Cord Calidad": { color: "blue" },
		"Cord PCP": { color: "blue" },
		"Auditor": { color: "blue" },
		"Analista AIT": { color: "blue" },
		"Cord Ingeniería": { color: "blue" },
		"Cord Logística": { color: "blue" },
		"Cord Mtto": { color: "blue" },
		"Cord SIAHO": { color: "blue" }
	}
});
</script>
