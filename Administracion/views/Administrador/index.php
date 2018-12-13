	<!-- <link rel="stylesheet" type="text/css" href="<?=CSS?>.css"> -->
	<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?=CSS?>menu.css">
		<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

		<!--En el header se encuentra el boton que dirige al menu principal-->
		<header>
	  		<button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
	  		<p>Menu principal</p>
	  		<button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
	  	</header>

	<!--Cada div contiene un ícono que redirige a las diferentes pantallas del administrador-->
	<div class="superior">
		<div class="supe" onclick="usuarios()">
			<img src="<?=IMG?>team.png">
			<p>Usuarios</p>
		</div>

		<div class="supe" onclick="choferes()">
			<img src="<?=IMG?>driver.png">
			<p>Choferes</p>
		</div>

		<div class="supe" onclick="unidades()">
			<img src="<?=IMG?>logo2.png">
			<p>Unidades</p>
		</div>
	</div>

	<div class="inferior">
		<div class="infe" onclick="viajes()">
			<img src="<?=IMG?>pin.png"></a>
			<p>Viajes</p>
		</div>

		<div class="infe" onclick="rutas()">
			<img src="<?=IMG?>destination.png">
			<p>Rutas</p>
		</div>

		<div class="infe" onclick="retroalimentaciones()">
			<img src="<?=IMG?>feed.png">
			<p>Retroalimentaciones</p>
		</div>
	</div>

	<!--Estos divs sirven para el modal-->
	<div class="fondo"></div>
	<div class="mensaje">
	</div>

	<footer>UAQ-ANDA</footer>
<script type="text/javascript" src="<?=JS?>funciones.js"></script>
<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
