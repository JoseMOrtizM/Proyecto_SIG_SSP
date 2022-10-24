<?php
//CONECTANDO
require("php_require/conexion.php");
//COMPROBANDO USUARIO
try{
	$login=mysqli_real_escape_string($conexion,$_POST['correo']);
	$password=mysqli_real_escape_string($conexion,$_POST["contrasena"]);
	$consulta="SELECT `CONTRASENA` FROM `usuarios` WHERE `CORREO`='$login'";
	$resultados=mysqli_query($conexion,$consulta);
	$cuenta=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$contrasena_encryptada=$fila["CONTRASENA"];
		$cuenta=1;
	}
	if(password_verify($password,$contrasena_encryptada)){
		if($cuenta==1){
			//PONIENDO AL USUARIO CONECTADO
			$consulta="UPDATE `usuarios` SET `CONECTADO`='SI' WHERE `CORREO`='$login'";
			$resultados=mysqli_query($conexion,$consulta);
			session_start();
			$_SESSION["usuario"]=$login;
			header("location:zona_principal.php");
		}else{
			header("location:index.php?user=invalido");
		}
	}else{
		header("location:index.php?user=invalido");
	}
	mysqli_close($conexion);
}catch(Exeption $e){die("Error: " . $e->getMessage()) . $e->getCode() . $e->getLine();}
?>