
	<title>Registrar Ruta</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<header>
		<button class="casa" onclick="rutas()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
		<h1>UAQ-ANDA</h1>
		<button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
	</header>


		<form id="datos" onsubmit="return false">
			<div class="inicio">
				<div class="campo">
					<p>Punto de salida:</p>
					<div class="dato">
						<img class="start" src="<?=IMG?>start.png">
						<input type="" name="pSal">
					</div>
				</div>
				<div class="campo">
					<p>Paradas del camión: (Escribe las paradas contempladas en la ruta separadas por guiones "-")</p>
					<div class="dato">
						<img class="bus" src="<?=IMG?>bus-stop.png">
						<input type="" name="pInterm">
					</div>
				</div>
				<div class="campo">
					<p>Punto de destino:</p>
					<div class="dato">
						<img src="<?=IMG?>route.png">
						<input type="" name="pDest">
					</div>
				</div>
			</div>
			<button onclick="registrarRuta();">Registrar ruta</button>
		</form>
	
	<div class="fondo"></div>
	<div class="mensaje" id="mensaje"></div>
	<script type="text/javascript" src="<?=JS?>funciones.js"></script>
	<script type="text/javascript" src="<?=JS?>config.js"></script>
	<script type="text/javascript" src="<?=JS?>index.js"></script>
