<?php
	require_once( 'config.php' );
	require_once( SYSTEM_PATH.'autoloader.php' );
	
	$server = new webe\server\Server();
	$server->defaultUrl = "home";
	
	$h1 = new webe\server\WebHandler();
	$h1->path = SITE_PATH."pages/";
	$h1->templatePath = SITE_PATH."templates/";
	$h1->template = "default";
	
	$h2 = new webe\server\AppHandler();
	
	$server->setSite( "/", $h1 );
	$server->setSite( "app", $h2 );
	
	$server->start();
?>
