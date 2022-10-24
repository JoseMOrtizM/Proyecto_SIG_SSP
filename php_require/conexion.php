<?php
//DATOS PARA CONFIGURAR LA CONEXXION
$url_sitio=$_SERVER['DOCUMENT_ROOT'] . '/mis_sitios/SIG_SSP/';
$servidor_nombre="localhost";
$servidor_usuario="root";
$servidor_contrasena="";
$base_de_datos_nombre="SIG_SSP";
//conectando
$conexion=mysqli_connect($servidor_nombre,$servidor_usuario,$servidor_contrasena);
if(mysqli_connect_errno()){echo "Fallo al conectar con la BBDD";exit();}
mysqli_select_db($conexion,$base_de_datos_nombre) or die ("No se encuentra la BBDD");
mysqli_set_charset($conexion,"utf8");
?>
