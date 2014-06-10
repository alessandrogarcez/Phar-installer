<?php

/**
 * @author Alessandro Garcez <dev@alessandrogarcez.com.br>
 * @copyright (c) 2014, Alessandro Garcez
 * @version 1.0.0
 */
require 'defines.inc.php';

main($argc, $argv);

function main($argc, $argv) {

	$option = ($argc > 1) ? $argv[1] : '';
	$force = (in_array('--force', $argv) || in_array('-f', $argv))?true:false;
	
	switch ($option) {
		case 'install':
			install($argv[0], $force);
			break;
		case '--help':
			showHelp();
			break;
		default:
			showHelp();
			break;
	}
}

function showHelp() {

	echo '
	pachage.phar [option]
	
	install			Install the phar package.
	--force, -f Force the installation.
	--help			show help

';
}

function install($package, $force) {

	if (isNewerVersion() || $force) {
		
		createInstallationPath(INSTALLATIONPATH);
		$phar = new Phar($package);
		$phar->extractTo(INSTALLATIONPATH, null, true);
		deleteFiles(array('defines.inc.php', 'install.php'));
		$version_file = INSTALLATIONPATH . '/version';
		createFile($version_file, str_replace('.phar', '', encrypt($package)));
		echo $package . " installed.\n";
		
	} else {
		echo "Is not possible install because current installed version is the same or newer than that your trying to install. The package version have to be newer than installed.\n";
	}
}

function createInstallationPath($path) {

	if (!is_dir($path)) {
		mkdir($path, 0777, true);
	}
}

function deleteFiles($files = array()) {

	foreach ($files as $files) {
		unlink(INSTALLATIONPATH . '/' . $files);
	}
}

function createFile($file, $data) {

	$handle = fopen($file, 'w');
	fwrite($handle, $data);
}

function encrypt($str) {

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'This is my secret key';
	$secret_iv = 'This is my secret iv';

	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$hash = openssl_encrypt($str, $encrypt_method, $key, 0, $iv);
	$hash = base64_encode($hash);

	return $hash;
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

function isNewerVersion() {

	$newer = false;

	if ($version_file_content = getdataOfFile(INSTALLATIONPATH . '/version')) {

		$version_file_content = decrypt($version_file_content);
		$installed_version = explode('.', str_replace(NAME . '-', '', $version_file_content));

		$major_inst = (int) $installed_version[0];
		$minor_inst = (int) $installed_version[1];
		$patch_inst = (int) $installed_version[2];
		$package_inst = (int) $installed_version[3];

		$version = explode('.', SOURCEVERSION);
		$major = (int) $version[0];
		$minor = (int) $version[1];
		$patch = (int) $version[2];
		$package = (int) $version[3];

		if ($major > $major_inst) {
			$newer = true;
		} else {
			if ($major == $major_inst) {
				if ($minor > $minor_inst) {
					$newer = true;
				}
			} else {
				if ($minor == $minor_inst) {
					if ($patch > $patch_inst) {
						$newer = true;
					} else {
						if ($patch == $patch_inst) {
							if ($package > $package_inst) {
								$newer = true;
							}
						}
					}
				}
			}
		}
	} else {

		$newer = true;
	}

	return $newer;
}

function getdataOfFile($file) {

	$data = null;

	if (is_file($file)) {
		$handle = fopen($file, 'r');
		$data = fread($handle, filesize($file));
	}

	return $data;
}
