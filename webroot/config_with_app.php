<?php
	require(__DIR__."/config.php");
	$di=new \Anax\DI\CDIFactoryDefault();
	$app=new \Anax\Kernel\CAnax($di);
?>