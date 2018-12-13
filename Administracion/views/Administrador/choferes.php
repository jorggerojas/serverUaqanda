	<!-- <link rel="stylesheet" type="text/css" href="<?=CSS?>.css"> -->
  <title>Choferes</title>

  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>ElimUnidad.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <script type="text/javascript" src="<?=JS?>preHash.js"></script>

<body onload="mostrarChoferes()">
  <!--Aquí empieza el header que contiene el botón para volver al menú principal-->
  <header>
      <button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
      <p>Choferes</p>
        <button class="cerrar" onclick="modalSesion();"><img class="icono2" src="<?=IMG?>exit.png"></button>
  </header>

  <!--Div que esta ubicado abajo del header-->
  <div class="superior">
    <button type="button" name="button"  class="registro" onclick="choferesX()">Registrar chofer</button>
  </div>
  <hr>

<!--Aquí se muestran todos los datos de los choferes-->
<div id="info"></div>

<!--Estos divs son para el modal-->
<div class="fondo"></div>
<div id="mensaje2" class="mensaje">
<p>¿Seguro que desea eliminar este chofer?</p>
<button class="save" onclick="cerrarModal()">Aceptar</button>
<button class="cancel" onclick="cerrarModal()">Cancelar</button>
</div>

<script type="text/javascript" src="<?=JS?>funciones.js"></script>
<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
