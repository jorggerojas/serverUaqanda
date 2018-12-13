<title>Modificar Ruta</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">


<body onload="cargarDatos();">
  <header>
    <button class="casa" onclick="rutas()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
    <h1>UAQ-ANDA</h1>
    <p>Modificar viaje</p>
    <button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
  </header>


  <form id="datos" onsubmit="return false">
    <div class="inicio">
      <div class="campo">
          <p>Selecciona un chofer:</p>
          <div class="dato">
            <img src="<?=IMG?>users.png">
            <select class="" id="chofer" name="chofer"></select>
          </div>
      </div>
      <div class="campo">
          <p>Selecciona una unidad:</p>
          <div class="dato">
            <img src="<?=IMG?>bus.png">
            <select class="" name="unidad" id="unidad"></select>
          </div>
      </div>
      <div class="campo">
          <p>Selecciona una ruta:</p>
          <div class="dato">
            <img src="<?=IMG?>start.png">
            <select class="" id="ruta" name="ruta"></select>
          </div>
      </div>
    </div>
    <button id='0' onclick="guardarViaje(this.id);">Guardar Cambios</button>
    <button onclick="viajes();">Cancelar</button>
  </form>

<div class="fondo"></div>
<div class="mensaje"></div>


<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
