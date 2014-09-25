<?php
	echo "
<!doctype html>
<html class='no-js' lang='".$lang."'>
<head>
	<meta charset='utf-8'/>
	<title>".$title.$title_append."</title>";
	if (isset($favicon)) {
		echo "
	<link rel='icon' href='".$this->url->asset($favicon)."'/>";
	}
	foreach ($stylesheets as $css_file) {
		echo "
	<link rel='stylesheet' type='text/css' href='".$this->url->asset($css_file)."'/>";
	}
	foreach ($javascript_include as $js_file) {
		echo "
	<script type='text/javascript' src='".$this->url->asset($js_file)."'></script>";
	}
	if (isset($modernizr)) {
		echo "
	<script type='text/javascript' src='".$this->url->asset($modernizr)."'></script>";
	}
	if (isset($jquery)) {
		echo "
	<script type='text/javascript' src='".$this->url->asset($jquery)."'></script>";
	}
	if (isset($style)) {
		echo "
	<style>\n".$style."
	</style>";
	}
	echo "
</head>
<body>";
	if (isset($google_analytics)) {
		include_once('ego_gat.php');
	}
	echo "
	<div id='top-head-fixed'>
	</div>
	<div id='top-head'>
	</div>
	<div id='top-space'>
	</div>
	<div id='wrapper'>
		<div id='header'>".(isset($header) ? $header : "");
	$this->views->render('header');
	echo "
		</div>";
	if ($this->views->hasContent('navbar')) {
		echo "
		<div id='navbar'>";
		$this->views->render('navbar');
		echo "
		</div>";
	}
	echo "
		<div id='main'>".(isset($main) ? $main : "");
	$this->views->render('main');
	echo "
		</div>
	</div>
	<div id='footer-space'>".(isset($footer) ? $footer : "");
	$this->views->render('footer');
	echo "
	</div>
	<script>
		menuTop();
	</script>
</body>
</html>";
?>