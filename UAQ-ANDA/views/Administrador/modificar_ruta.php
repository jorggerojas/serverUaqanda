 	<title>Modificar Ruta</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

  <!--l header contiene el botón que redirigirá al menú principal y el de cerrar sesión-->
  <body onload="cargarRuta(<?=$this->ruta?>);">
    <header>
  		<button class="casa" onclick="rutas()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
  		<h1>UAQ-ANDA</h1>
  		<button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
  	</header>

  	<!--Aquí se muestra el formulario donde viene un div por cada input-->
	<form id="datos" onsubmit="return false">
      	<div class="inicio" id="inicio">
      		<div class="campo">
				<p>Punto de salida:</p>
				<div class="dato">
					<img src="<?=IMG?>start.png">
					<input type="" name="pSal" id="pi">
				</div>
			</div>
			<div class="campo">
					<p>Paradas del camión: (escribe todas las paradas que hara separadas por un guion "-")</p>
					<div class="dato">
						<img src="<?=IMG?>bus-stop.png">
						<input type="" name="pInterm"  id="ad">
					</div>
			</div>
			<div class="campo">
					<p>Punto de destino:</p>
					<div class="dato">
						<img src="<?=IMG?>route.png">
						<input type="" name="pDest" id="pf">
					</div>
			</div>
		</div>
		<button id='0' class="cero" onclick="guardarRuta(this.id);">Guardar Cambios</button>
    	<button class="cancel" onclick="rutas();">Cancelar</button>
	</form>

  <!--Estos divs se usan para el modal-->
  <div class="fondo"></div>
  <div class="mensaje"></div>
	<script type="text/javascript" src="<?=JS?>config.js"></script>
	<script type="text/javascript" src="<?=JS?>index.js"></script>
