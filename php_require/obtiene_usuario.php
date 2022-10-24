<?php
// RESCATANDO USUARIO
$usuario_correo=$_SESSION["usuario"];
//CONASULTANDO NIVEL DE ACCESO DEL USUARIO
$consulta="SELECT 
			`usuarios`.`CARGO` AS CARGO, 
			`usuarios`.`NOMBRE` AS NOMBRE, 
			`usuarios`.`APELLIDO` AS APELLIDO, 
			`descripcion_de_cargos`.`TIPO_DEPARTAMENTO` AS TIPO_DEPARTAMENTO, 
			`descripcion_de_cargos`.`SUPERVISADO` AS SUPERVISADO, 
			`descripcion_de_cargos`.`DEPARTAMENTO` AS DEPARTAMENTO 
			FROM `descripcion_de_cargos` INNER JOIN `usuarios` ON
			`descripcion_de_cargos`.`CARGO`=`usuarios`.`CARGO` 
			WHERE `usuarios`.`CORREO`='$usuario_correo'";
$resultado=mysqli_query($conexion,$consulta);
while(($fila=mysqli_fetch_array($resultado))==true){
	$usuario_cargo=$fila['CARGO'];
	$usuario_nombre=$fila["NOMBRE"] . " " . $fila["APELLIDO"];
	$usuario_gerencia=$fila['TIPO_DEPARTAMENTO'];
	$usuario_departamento=$fila['DEPARTAMENTO'];
	$usuario_supervisados=$fila['SUPERVISADO'];
}
//AQUI DEBEN IR LAS EXCLUSIONES PARA LOS USUARIOS NO AUTORIZADOS SEGÚN EL NOBRE DE LA PÁGINA
if($ruta_actual=='rdc_general.php' or 
   $ruta_actual=='rdc_adicional_general.php' or 
   $ruta_actual=='inventario_general.php'){
	$cargo_partes_i=explode(" ",$usuario_cargo);
	if($usuario_correo<>"ortizjx@pdvsa.com" and 
	   $cargo_partes_i[0]<>"GERENTE" and 
	   $cargo_partes_i[0]<>"GTE" and 
	   $cargo_partes_i[0]<>"Gerente" and 
	   $cargo_partes_i[0]<>"gerente" and 
	   $cargo_partes_i[0]<>"Gte" and 
	   $cargo_partes_i[0]<>"GERENTE." and 
	   $cargo_partes_i[0]<>"GTE." and 
	   $cargo_partes_i[0]<>"Gerente." and 
	   $cargo_partes_i[0]<>"gerente." and 
	   $cargo_partes_i[0]<>"Gte."){
		header("location:zona_principal.php");
	}
}
if($ruta_actual=='CRUD_usuarios.php' or 
   $ruta_actual=='CRUD_cargos.php' or 
   $ruta_actual=='CRUD_postulados.php' or 
   $ruta_actual=='CRUD_comentarios.php' or 
   $ruta_actual=='CRUD_planes.php' or 
   $ruta_actual=='CRUD_reales.php' or 
   $ruta_actual=='CRUD_reales_adicional.php' or 
   $ruta_actual=='CRUD_inv_categorias.php' or 
   $ruta_actual=='CRUD_inv_articulos.php' or 
   $ruta_actual=='CRUD_inv_clientes.php' or 
   $ruta_actual=='CRUD_inv_traspasos.php' or 
   $ruta_actual=='RU_portada_serv.php' or 
   $ruta_actual=='RU_portada_otros.php'){
	if($usuario_correo<>'ortizjx@pdvsa.com' and $usuario_cargo<>'COORDINADOR DE PPyG'){
		header("location:zona_principal.php");
	}
}
?>
