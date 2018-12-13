	<title>Registrar Unidad</title>
	<link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<header>
		<button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
		<h1>UAQ-ANDA</h1>
		<button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
	</header>

	<form class="" id="datos" onsubmit="return false">
		<div class="inicio">
			
				<div class="campo">
					<p>Capacidad:</p>
					<div class="dato">
						<img src="<?=IMG?>chair.png">
						<input id="cap" type="" name="cap">
					</div>
				</div>
				<div class="campo">
					<p>Placa:</p>
					<div class="dato">
						<img src="<?=IMG?>license-plate.png">
						<input id="pl" type="" name="pl">
					</div>
				</div>
				<div class="campo">
					<p>Campus:</p>
					<div class="dato">
						<img src="<?=IMG?>maps.png">
						<input id="cam" type="" name="cam">
					</div>
				</div>
				<div class="campo">
					<p>Modelo:</p>
					<div class="dato">
						<img src="<?=IMG?>bus.png">
						<input id="mod" type="" name="mod">
					</div>
				</div>
			</div>
			<button onclick="registrarUnidad();">Aceptar</button>
		</div>
	</form>

	<div class="fondo"></div>
	<div class="mensaje" id="mensaje"></div>
	<script type="text/javascript" src ="<?=JS?>funciones.js"></script>
	<script type="text/javascript" src="<?=JS?>config.js"></script>
	<script type="text/javascript" src="<?=JS?>index.js"></script>
