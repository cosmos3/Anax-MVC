<?php

	function txtPageTitle($text) {
		return "<h3>".$text."</h3>";
	}
	
	
	function cleanTxt($value) {
		return filter_var(trim($value), FILTER_SANITIZE_STRING);
	}
	
	function cleanURL($url) {
		return html_entity_decode($url);
	}
	
	function readPOST($var, $false) {
		return cleanTxt(isset($_POST[$var]) ? $_POST[$var] : $false);
	}
	
	function readGET($var, $false) {
		return cleanTxt(isset($_GET[$var]) ? $_GET[$var] : $false);
	}
	
	function readSession($var, $false) {
		return cleanTxt(isset($_SESSION[$var]) ? $_SESSION[$var] : $false);
	}
	
	function readSessionFromGet($var, $false) {
		if (!isset($_SESSION[$var])) {
			if (isset($_GET[$var])) {
				$_SESSION[$var]=readGet($var, $false);
			} else {
				$_SESSION[$var]=$false;
			}
		} elseif (isset($_GET[$var])) {
			$_SESSION[$var]=readGet($var, $false);
		}
		return $_SESSION[$var];
	}
	
	function readSessionFromPost($var, $false) {
		if (!isset($_SESSION[$var])) {
			if (isset($_POST[$var])) {
				$_SESSION[$var]=readPost($var, $false);
			} else {
				$_SESSION[$var]=$false;
			}
		} elseif (isset($_POST[$var])) {
			$_SESSION[$var]=readPost($var, $false);
		}
		return $_SESSION[$var];
	}
	
	function downloadFile($file) {
		header("Content-Description: File Transfer");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($file));
		readfile($file);
		/*
		if ($f=fopen($file, 'rb')) {
			while (!feof($f)) {
				print(fread($f, 1024*8));
				flush();
			}
			fclose($file);
		}	
		*/	
		exit();
	}

	function txtLinkBlank($link, $text) {
		return "<a href='".$link."' target='_blank'>".$text."</a>";
	}
	
	function txtDownloadFile($link, $file) {
		return "Ladda ner fil: <a href='".$link.$file."' title='Ladda ner filen: ".$file."'><span class='download-file'></span></a> (".round(filesize($file)*0.001, 1)." kB)";
	}

	

	
?>