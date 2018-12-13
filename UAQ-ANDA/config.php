<?php
	date_default_timezone_set('America/Mexico_City');
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');


	define( 'URL' ,"https://uaq-anda.herokuapp.com/".basename(getcwd())."/");
	define( 'CSS' ,URL."public/css/");
	define( 'JS' , URL."public/js/" );
	define( 'IMG', URL."public/img/");
	define( 'LIB', URL."libs/");

	//Crean el archivo de config.js
	//Comentar al primer uso, no es necesario sobreescribir
	@$file = fopen("public/js/config.js", "w");
	@fwrite($file,
		'var config = {
			url: "'.URL.'/Administracion/",
			img: "'.URL.'/Administracion/public/img/"
		}');
	@fclose($file);

	//Constantes de la base de datos
	define( 'DB_HOST' , 'us-cdbr-iron-east-01.cleardb.net');
	define( 'DB_USER' , 'bbc44b817897f1');
	define( 'DB_PASS' , '27b80d4c');
	define( 'DB_NAME' , 'heroku_dc4918426883fe6');
	define('DB_CHARSET', 'utf8');


	define( 'ALGOR', 'sha1');
	define( 'KEY', 'oPMh543YGvb==?');
	define( 'ID_SESSION', 'ua18..');
?>
