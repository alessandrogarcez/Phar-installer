#!/usr/bin/php
<?php
/**
 * @author Alessandro Garcez <dev@alessandrogarcez.com.br>
 * @copyright (c) 2014, Alessandro Garcez
 * @version 1.0.0
 */
main($argc, $argv);

function main($argc, $argv) {

	$option = ($argc > 1) ? $argv[1] : '';

	switch ($option) {
		case '--version':
			showVersion();
			break;
		case '--help':
			showHelp();
			break;
		default:
			showHelp();
			break;
	}
	
	chmod("/Users/alessandrogarcez/Sites/Phar-installer/app.php", 0755);
	
}

function showHelp() {

	echo '
	This call must be made after installation of the app.
	./app.php [option]
	
	--version	Currently installed version.
	--help		show help

';
}

function showVersion() {

	$my_file = 'version';
	if (is_file($my_file)) {
		$handle = fopen($my_file, 'r');
		$data = fread($handle, filesize($my_file));
		echo decrypt($data). "\n";
	} else {
		echo "This is not the installed version. This call must be made after installation of the app.\n";
	}
}

function decrypt($str) {

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'This is my secret key';
	$secret_iv = 'This is my secret iv';
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_decrypt(base64_decode($str), $encrypt_method, $key, 0, $iv);

	return $output;
}
