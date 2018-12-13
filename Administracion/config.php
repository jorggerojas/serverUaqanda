<?php
	date_default_timezone_set('America/Mexico_City');
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');


	define( 'URL' ,"http://localhost:9999/UAQ-ANDA/".basename(getcwd())."/");
	define( 'CSS' ,URL."public/css/");
	define( 'JS' , URL."public/js/" );
	define( 'IMG', URL."public/img/");
	define( 'LIB', URL."libs/");

	//Crean el archivo de config.js
	//Comentar al primer uso, no es necesario sobreescribir
	@$file = fopen("public/js/config.js", "w");
	@fwrite($file,
		'var config = {
			url: "'.URL.'",
			img: "'.URL.'public/img/"
		}');
	@fclose($file);

	//Constantes de la base de datos
	define( 'DB_HOST' , 'localhost');
	define( 'DB_USER' , 'root');
	define( 'DB_PASS' , '');
	define( 'DB_NAME' , 'uaq-anda');
	define('DB_CHARSET', 'utf-8');


	define( 'ALGOR', 'sha1');
	define( 'KEY', 'oPMh543YGvb==?');
	define( 'ID_SESSION', 'ua18..');
?>
