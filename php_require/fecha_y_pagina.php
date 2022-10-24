<?php
//OBTENIENDO FECHA ACTUAL
$dia_sem=date("N");
if($dia_sem=='1'){$dia_sem='Lunes';}
if($dia_sem=='2'){$dia_sem='Martes';}
if($dia_sem=='3'){$dia_sem='Miércoles';}
if($dia_sem=='4'){$dia_sem='Jueves';}
if($dia_sem=='5'){$dia_sem='Viernes';}
if($dia_sem=='6'){$dia_sem='Sábado';}
if($dia_sem=='7'){$dia_sem='Domingo';}
$dia=date("d");
$mes=date("m");
if($mes=='01'){$mes='Enero';}
if($mes=='02'){$mes='Febrero';}
if($mes=='03'){$mes='Marzo';}
if($mes=='04'){$mes='Abril';}
if($mes=='05'){$mes='Mayo';}
if($mes=='06'){$mes='Junio';}
if($mes=='07'){$mes='Julio';}
if($mes=='08'){$mes='Agosto';}
if($mes=='09'){$mes='Septiembre';}
if($mes=='10'){$mes='Octubre';}
if($mes=='11'){$mes='Noviembre';}
if($mes=='12'){$mes='Diciembre';}
$ano=date("Y");
$hoy=$dia_sem . ", " . $dia . " de " . $mes . " del " . $ano;
//OBTENIENDO NOMBRE DEL ARCHIVO PHP ACTUAL
$ruta_actual=$_SERVER["REQUEST_URI"];
$partes1=explode("/",$ruta_actual);
$i=0;
while(isset($partes1[$i])==true){
	$ruta_actual=$partes1[$i];
	$i=$i+1;
}
$partes2=explode("?",$ruta_actual);
$ruta_actual=$partes2[0];
?>
