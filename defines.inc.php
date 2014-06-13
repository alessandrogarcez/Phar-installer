<?php

/**
 * @author Alessandro Garcez <dev@alessandrogarcez.com.br>
 * @copyright (c) 2014, Alessandro Garcez
 * @version 1.0.0
 */

//Application version
$major=1;
$minor=0;
$patch=0;
$package=1;

//Application name
$name='Phar_installer';
//Path where application will be installed
$installpath = '/Users/alessandrogarcez/Sites/descompress/Phar-installer';
//Files or directories to ignore
$ignored_files = 'cgi-bin|.|..|.DS_Store|.git|nbproject|LICENSE|README.md|.gitignore';
//File name or fullpath of the files that must be ignored.
$confs = '';

define('VERSION', $major.'.'.$minor.'.'.$patch);
define('SOURCEVERSION', $major.'.'.$minor.'.'.$patch.'-'.$package);
define('NAME', $name);
define('PROJECTFOLDER', __DIR__);
define('INSTALLATIONPATH', $installpath);
define('IGNOREDFILES', $ignored_files);
define('CONFS', $confs);
