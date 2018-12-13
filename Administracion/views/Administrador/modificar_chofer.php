
  <!-- <link rel="stylesheet" type="text/css" href="<?=CSS?>.css"> -->
  <title></title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>ModRuta2.css">
  <link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <script type="text/javascript" src="<?=JS?>preHash.js"></script>

  <!--En este header se encuentra el botón para volver al menú principal-->
  <header>
    <button class="casa" onclick="menu()"><img class="icono" src="<?=IMG?>school-bus.png"></button>
    <h1>UAQ-ANDA</h1>
    <button class="cerrar"><img class="icono2" src="<?=IMG?>exit.png"></button>
  </header>

    <!--Este div se encuentra debajo del header-->
    <div class="intro">
      <p>Por favor, llene los siguientes campos con los nuevos datos del conductor</p>
    </div>

    <!--En este div se separa cada input con su imagen y texto-->
    <form class="form" id="datos" onsubmit="return false">
    <div class="inicio" id="inicio">
          <div class="campo">
              <p>Número de licencia:</p>
              <div class="dato">
                <img src="<?=IMG?>driver-license.png">
                <input type="" name="" id="newlic">
              </div>
          </div>
          <div class="campo">
              <p>Teléfono de referencia:</p>
              <div class="dato">
                <img src="<?=IMG?>phone-call.png">
                <input type="" name="" id="newTel2">
              </div>
          </div>
          <div class="campo">
              <p>Nombre:</p>
              <div class="dato">
                <img src="<?=IMG?>users.png">
                <input type="" name="" id="newNombre">
              </div>
          </div>
          <div class="campo">
              <p>Apellido:</p>
              <div class="dato">
                <img src="<?=IMG?>users.png">
                <input type="" name="" id="newApellido">
              </div>
          </div>
          <div class="campo">
              <p>Correo:</p>
              <div class="dato">
                <img src="<?=IMG?>email.png" >
                <input type="email" name="" id="newCorreo">
              </div>
          </div>
          <div class="campo">
              <p>Telefono</p>
              <div class="dato">
                <img src="<?=IMG?>phone-call.png">
                <input type="" name="" id="newTel">
              </div>
          </div>
          <div class="campo">
              <p>Contraseña:</p>
              <div class="dato">
                <img src="<?=IMG?>key.png">
                <input type="" name="" id="newPass">
              </div>
          </div>
    </div>
      <button class="save" onclick="updateChofer()">Guardar cambios</button>
      <button class="cancel" onclick="cancelar()">Cancelar</button>
  </form>

    <!--Estos divs se usan para el modal-->
    <div class="fondo"></div>
    <div class="mensaje">
      <p>¿Guardar cambios?</p>
      <button class="save" onclick="cerrarModal()">Aceptar</button>
      <button class="cancel" onclick="cerrarModal()">Cancelar</button>
    </div>

<script type="text/javascript" src="<?=JS?>funciones.js"></script>
<script type="text/javascript" src="<?=JS?>config.js"></script>
<script type="text/javascript" src="<?=JS?>index.js"></script>
<script type="text/javascript">
  
  if (document.addEventListener){
        window.addEventListener('load',infoChofer(),false);
    } else {
        window.attachEvent('onload',infoChofer());
    }
       
</script>
