<?php

@session_start();
ob_start();

$current_file = $_SERVER['SCRIPT_NAME'];
$http_referer;
if (isset($_SERVER['HTTP_REFERER'])) {
	$http_referer = $_SERVER['HTTP_REFERER'];
}

?>