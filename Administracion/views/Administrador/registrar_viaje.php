	<title>Registrar viaje</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body onload="cargarDatos();">
	<header>
  		<button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
  		<h1>UAQ-ANDA</h1>
  		<button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
  	</header>

		<form id="datos" onsubmit="return false">
			<div class="inicio" id="inicio">
				<div class="campo">
					<p>Selecciona un chofer:</p>
					<div class="dato">
						<img class="user" src="<?=IMG?>users.png">
						<select class="" id="chofer" name="chofer"></select>
					</div>
				</div>
				<div class="campo">
					<p>Selecciona una unidad:</p>
					<div class="dato">
						<img class="bus" src="<?=IMG?>bus.png">
						<select class="" name="unidad" id="unidad"></select>
					</div>
				</div>
				<div class="campo">
					<p>Selecciona una ruta:</p>
					<div class="dato">
						<img class="start" src="<?=IMG?>start.png">
						<select class="" id="ruta" name="ruta"></select>
					</div>
				</div>
				<div class="campo">
					<p>Selecciona una la hora: </p>
					<div class="dato">
						<img class="hora" src="<?=IMG?>clock.png">
						<input class="horas" name="horas" placeholder="Horas:" type="number" min="06" max="20" step="1" value="06" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" />
					</div>
				</div>
				<div class="campo">
					<p>Selecciona los minutos:</p>
					<div class="dato">
						<img class="minuto" src="<?=IMG?>clock.png">
						<input class="minutos" type="number" value="00" step="30" min="00" max="30" name="min" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;">
					</div>
				</div>
			</div>
			<button onclick="registrarViaje();">Registrar viaje</button>
		</form>


	<div class="fondo"></div>
	<div class="mensaje"></div>

	<script type="text/javascript"src="<?=JS?>funciones.js"></script>
	<script type="text/javascript" src="<?=JS?>config.js"></script>
	<script type="text/javascript" src="<?=JS?>index.js"></script>
