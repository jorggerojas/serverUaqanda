<!DOCTYPE html>
<html>
<head>
	<title>Inicio de Sesión</title>
	<script src="<?=JS?>log.js"></script>
	<script src="<?=JS?>config.js"></script>
	<script src="<?=JS?>preHash.js"></script>
	<script src="<?=JS?>jquery-3.1.1.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilos.css">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>
<body>


	<!-- header -->

	<header>
			<img class="icono" src="<?=IMG?>school-bus.png"></img>
	</header>

	<p>Accesa con tu usuario y contraseña</p>
	<!-- se piden los datos -->

		<form onsubmit="return false">
			<div class="inicio">
				<div class="campo">
					<p>Clave:</p>
					<div class="dato">
						<img src="<?=IMG?>users.png">
						<input type="Number" name="user" id="exp">
					</div>
				</div>
				<div class="campo">
					<p>Contraseña:</p>
					<div class="dato">
						<img src="<?=IMG?>key.png">
						<input type="password" name="pass" id="pass">
					</div>
				</div>
				<div class="extra">
					<input type="submit" name="login" value="Entrar" class="boton" onclick="getValues()">
				</div>
			</div>
		</form>


	<footer>
		<p>UAQ-ANDA</p>
	</footer>
	<!-- fin  -->

</body>
</html>
