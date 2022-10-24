<!-------------------- HEAD SIN INCLUIR <title>------------------------------------>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php require("php_require/conexion.php"); ?>
<!---------------- ENLACES DE FAVICON ---------------------------------------------->
<link type="image/x-icon" href="img/<?php $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='ICONO'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; ?>" rel="icon" /> 
<link type="image/x-icon" href="img/<?php $consulta="SELECT `FOTO` FROM `portada` WHERE `TIPO`='ICONO'"; $resultados=mysqli_query($conexion,$consulta); $fila=mysqli_fetch_array($resultados); echo $fila['FOTO']; ?>" rel="shortcut icon" />
<?php mysqli_close($conexion); ?>

<!------------------------------- ENLACES DE CSS ----------------------------------->
<!-- ENLACES DE BOOTSTRAP-->
<link rel="stylesheet" href="css/bootstrap.css">
<!-- ESTILO PERSONALIZADO -->
<link rel="stylesheet" href="css/estilo_principal.css">
<!-- ENLACES PARA EL LOGO ANIMADO -->
<link rel="stylesheet" href="sliderengine/amazingslider-1.css">
<!-- ENLACES PARA ICONOS -->
<link rel="stylesheet" href="css/font-awesome.css">
<!-- ENLACES PARA DATEPICKER -->
<link rel="stylesheet" href="css/calendar-system.css">
<!-- ENLACES PARA DATATABLE -->
<link rel="stylesheet" href="css/dataTables.bootstrap4.css">
<!-- ENLACES PARA EDITOR DE TEXTO SUMMERNOTE-->
<link rel="stylesheet" href="summernote/summernote-lite.css">
<!-- ENLACES PARA EDITOR DE ORGANIGRAMA GETORGCHART-->
<link rel="stylesheet" href="getorgchart/getorgchart.css">

<!------------------------------- ENLACES DE JS ----------------------------------->
<!-- ENLACES DE BOOTSTRAP-->
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- ENLACES PARA EL LOGO ANIMADO -->
<script type="text/javascript" src="sliderengine/amazingslider.js"></script>
<script type="text/javascript" src="sliderengine/initslider-1.js"></script>
<!-- ENLACES PARA DATEPICKER -->
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/calendar-es.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>
<!-- ENLACES PARA EDITOR DE TEXTO SUMMERNOTE -->
<script type="text/javascript" src="summernote/summernote-lite.js"></script>
<!-- ENLACES PARA EDITOR DE ORGANIGRAMA GETORGCHART-->
<script type="text/javascript" src="getorgchart/getorgchart.js"></script>
<!-- ENLACES PARA EDITOR DE GRAFICAS CHARTJS-->
<script type="text/javascript" src="js/Chart.min_2.4.0.js"></script>

<!------------------------------ EFECTO DE ENTRADA ---------------------------------->
<script type="text/javascript">
	$(document).ready(function(){
		$('section').hide();
		$('section').fadeIn(1500);
		var alto=screen.height;
		var ajuste=Math.round(alto*0.8145-103.84,0);
		$('.pre-scrollable').css("max-height",ajuste+"px");
	});
	$(window).resize(function() {
		var alto=screen.height;
		var ajuste=Math.round(alto*0.8145-103.84,0);
		$('.pre-scrollable').css("max-height",ajuste+"px");
		//alert('Resolucion: '+screen.height+' Ajuste: '+$('.pre-scrollable').css("max-height"));
	});
</script>
