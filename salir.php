<?php
require ("php_require/comprueba_session.php");
require ("php_require/conexion.php");
require("php_require/fecha_y_pagina.php");
require("php_require/obtiene_usuario.php");
if(isset($usuario_correo)){
	//PONIENDO AL USUARIO NO CONECTADO
	$consulta="UPDATE `usuarios` SET `CONECTADO`='NO' WHERE `CORREO`='" . $usuario_correo . "'";
	$resultados=mysqli_query($conexion,$consulta);
}
session_start();
session_destroy();
header("location:index.php");
?>