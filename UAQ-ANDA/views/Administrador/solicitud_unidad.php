	<title>Solicitudes de unidad</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>SolUsuario.css">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<body onload="mostrarSolicitudes();">
	<header>
		<button class="casa" onclick="menu()">	<img class="icono" src="<?=IMG?>school-bus.png"></button>
		<h1>UAQ-ANDA</h1>
		<button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
	</header>

	<div class="solicitud">
		<h2 id="num"></h2><h2> Solicitudes de unidad pendientes</h2>
	</div>
	<div id="solicitudes"></div>

	<div class="fondo"></div>
	<div class="mensaje"></div>
	<script type="text/javascript" src="<?=JS?>funciones.js"></script>
	<script type="text/javascript" src="<?=JS?>config.js"></script>
	<script type="text/javascript" src="<?=JS?>index.js"></script>
</body>
