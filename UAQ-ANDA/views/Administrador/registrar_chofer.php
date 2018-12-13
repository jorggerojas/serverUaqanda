  <!-- <link rel="stylesheet" type="text/css" href="<?=CSS?>.css"> -->
  <title>Choferes</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <script type="text/javascript" src="<?=JS?>preHash.js"></script>

  <header>
      <button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
      <h1>UAQ-ANDA</h1>
      <button class="cerrar"><img class="icono2" src="<?=IMG?>exit.png"></button>
  </header>

  <form id="datos" onsubmit="return false">
    <div class="inicio" id="inicio">
          <div class="campo">
              <p>Número de licencia:</p>
              <div class="dato">
                <img src="<?=IMG?>driver-license.png">
                <input type="" name="" id="numLicencia">
              </div>
          </div>
          <div class="campo">
              <p>Fecha de contratación:</p>
              <div class="dato">
                <img src="<?=IMG?>calendar.png">
                <input type="date" name="" id="fecha">
              </div>
          </div>
          <div class="campo">
              <p>Teléfono de referencia:</p>
              <div class="dato">
                <img src="<?=IMG?>phone-call.png">
                <input type="" name="" id="telr">
              </div>
          </div>
          <div class="campo">
              <p>Nombre:</p>
              <div class="dato">
                <img src="<?=IMG?>users.png">
                <input type="" name="" id="nombre">
              </div>
          </div>
          <div class="campo">
              <p>Apellido:</p>
              <div class="dato">
                <img src="<?=IMG?>users.png">
                <input type="" name="" id="apellido">
              </div>
          </div>
          <div class="campo">
              <p>Expediente:</p>
              <div class="dato">
                <img src="<?=IMG?>users.png">
                <input type="" name="" id="expediente">
              </div>
          </div>
          <div class="campo">
              <p>Correo:</p>
              <div class="dato">
                <img src="<?=IMG?>email.png" >
                <input type="email" name="" id="correo">
              </div>
          </div>
          <div class="campo">
              <p>Telefono</p>
              <div class="dato">
                <img src="<?=IMG?>phone-call.png">
                <input type="" name="" id="tel">
              </div>
          </div>
          <div class="campo">
              <p>Contraseña:</p>
              <div class="dato">
                <img src="<?=IMG?>key.png">
                <input type="password" name="" id="pass">
              </div>
          </div>
    </div>
      <button onclick="insertChofer()">Registrar chofer</button>
  </form>

    <div class="fondo"></div>
    <div class="mensaje">
      <p>Chofer registrado exitosamente</p>
      <button onclick="menu()">Aceptar</button>
    </div>

<script type="text/javascript" src="<?=JS?>funciones.js"></script>
<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
<script type="text/javascript" src="<?=JS?>preHash.js"></script>
