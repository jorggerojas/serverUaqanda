  <!-- <link rel="stylesheet" type="text/css" href="<?=CSS?>.css"> -->
  <title>Choferes</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>retro.css">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>SolUsuario.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <script type="text/javascript" src="<?=JS?>preHash.js"></script>

  <!--Este header contiene el botón para regresar al menú principal-->
  <header>
      <button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
      <h1>UAQ-ANDA</h1>
      <p>Retroalimentaciones</p>
    </header>

    <!--Aquí está el buscador que sirve como filtro para las retroalimentaciones-->
    <div class="datos">
      <div class="dato">
        <h2>Fecha:</h2>
        <input type="date" name="" id="date">
        <button class="search" onclick="cali()" >Buscar</button>
      </div>
    </div>


    <div id="infoC"></div>

<script type="text/javascript" src="<?=JS?>funciones.js"></script>
<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
