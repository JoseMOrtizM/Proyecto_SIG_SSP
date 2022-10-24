<?php
	//INICIANDO SESSION
	session_start();
	//VERIFICANDO SESSION
	if(!isset($_SESSION["usuario"])){
		header("location:salir.php");
	}
	//CERRANDO SESSION POR TIEMPO DE INACTIVIDAD
	$tiempo_maximo_de_inactividad=300;
	if (!isset($_SESSION['tiempo'])) {
		$_SESSION['tiempo']=time();
	}
	else if (time()-$_SESSION['tiempo']>$tiempo_maximo_de_inactividad) {
		//PONIENDO AL USUARIO NO CONECTADO
		require ("php_require/conexion.php");
		$consulta="UPDATE `usuarios` SET `CONECTADO`='NO' WHERE `CORREO`='" . $_SESSION["usuario"] . "'";
		$resultados=mysqli_query($conexion,$consulta);
		session_destroy();
		//Aquí redireccionas a la url especifica
		header("Location: index.php?inactividad=si");
		die();
	}
	$_SESSION['tiempo']=time(); //Si hay actividad seteamos el valor al tiempo actual
?>
