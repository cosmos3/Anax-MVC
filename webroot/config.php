<?php
	define('ANAX_INSTALL_PATH', realpath(__DIR__."/../")."/");
	define('ANAX_APP_PATH', ANAX_INSTALL_PATH."app/");
	include(ANAX_APP_PATH."config/autoloader.php");
	include(ANAX_INSTALL_PATH."src/functions.php");
	$server="http://".$_SERVER['SERVER_NAME'];
	define('EGO_URL_ROOT', $server); // local
	//define('EGO_URL_ROOT', $server."/bth_phpmvc"); // cosmos3.se
	//define('EGO_URL_ROOT', $server."/~gohe14/phpmvc/kmom01"); // BTH
?>