#!/usr/bin/php
<?php
/**
 * @author Alessandro Garcez <dev@alessandrogarcez.com.br>
 * @copyright (c) 2014, Alessandro Garcez
 * @version 1.0.0
 */
require 'defines.inc.php';

$buildroot = getUserHomePath() . '/BUILD/PHARS';
$sourcename = NAME . '-' . SOURCEVERSION . '.phar';

define('BUILDROOT', $buildroot);
define('SOURCE', $sourcename);
define('SOURCEPATH', BUILDROOT . '/' . SOURCE);

main($argc, $argv);

function main($argc, $argv) {

	$option = ($argc > 1) ? $argv[1] : '';

	switch ($option) {
		case 'installer':
			generateInstaller();
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
	./make.php [option]
	
	installer	to build a package for installation.
	--help		show help

';
}

function generateInstaller() {

	createBuildPath();

	if (existsSource()) {
		echo "Package already exists, please update the version.\n	";

		return false;
	}

	createPharFile();
}

function createBuildPath() {

	if (!is_dir(BUILDROOT)) {
		mkdir(BUILDROOT, 0777, true);
	}
}

function getUserHomePath() {

	$usr_id = posix_getuid();
	$usr = posix_getpwuid($usr_id);

	return $usr['dir'];
}

function createPharFile() {

	$phar = new Phar(SOURCEPATH, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, SOURCE);

	packageFiles($phar, PROJECTFOLDER);

	$phar->setStub($phar->createDefaultStub("install.php"));
	
	echo "####################\ncreated ".SOURCEPATH."\n####################\n";

	return true;
}

function existsSource() {

	if (file_exists(SOURCEPATH)) {
		return true;
	} else {
		return false;
	}
}

function packageFiles($phar, $path = '.', $level = 0) {

	$ignore = explode('|', IGNOREDFILES);
	$confs = explode('|', CONFS);
	$dh = opendir($path);

	while (false !== ( $file = readdir($dh) )) {

		$is_conf = false;

		if (!in_array($file, $ignore)) {
			$fullpath = $path . '/' . $file;

			if (in_array($file, $confs) || in_array($fullpath, $confs)) {
				$is_conf = true;
				$file = $file . '.new';
			}

			if (is_dir($fullpath)) {
				packageFiles($phar, $fullpath, ($level + 1));
			} else {
				echo "Coping " . $fullpath . "\n";
				$str_file_index = $str_file = str_replace(PROJECTFOLDER . '/', '', $fullpath);
				if($is_conf) {
					$str_file_index = $str_file.'.new';	
					
				}
				$phar[$str_file_index] = file_get_contents(PROJECTFOLDER . '/' . $str_file);
			}
		}
	}

	closedir($dh);
}
