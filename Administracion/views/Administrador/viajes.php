
	<!-- <link rel="stylesheet" type="text/css" href="<?=CSS?>.css"> -->
  <title>Viajes</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>ElimUnidad.css">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

  <body onload="cargarViajes();">

    <header>
  		<button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
  		<h1>Viajes</h1>
      <button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
  	</header>

    <div class="superior">
      <button type="button" name="button"  class="registro" onclick="regViajes();">Registrar Viaje</button>
    </div>

    <hr>

    <div class="select">
      <h2>Ver: </h2>
      <select class="" name="" id="ver" onchange="cargarViajes()">
      <option value="1">Todas los viajes</option>
      <option value="2">En espera</option>
      <option value="3">En curso</option>
      <option value="4">Finalizados</option>
    </select>
    </div>

    <div class="inicio" id="inicio">

    </div>

    <div class="fondo"></div>
    <div class="mensaje"></div>

      	<footer>UAQ-ANDA</footer>
<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
