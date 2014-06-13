Phar-installer
==================

Description
---------------------
Phar-installer makes easy package, deploy and install your PHP application.

Applying it in your project is very simple, it just needed copy some files to your application and configure it.

##Step by step##

###Packaging and installing###

1.	Download the sorce of Phar-installer
2.	Copy the following files to your application's root dir
	* app
	* defines.inc.php
	* install
	* make
3.	Edit the defines.inc.php setting the corretly values.
	* *$name* - name of your application
	* *$installpath* - path where the application will be installed
	* *$ignored_files* - The file's name or path's name the should be ignored in installation
	* *$confs* - configs of your application, this files will never be overwritten in a new installation.
4.	After configure the defines, execute the following command to generate the package.<br/>
	<code>./make installer</code>
5.	The package will be generated in ~/BUILD/PHARS/
6.	Go to path where is the package
7.	Type the following command to install:<br/>
	<code>php package-1.0.0.0.phar install</code> or <code>php package-1.0.0.0.phar --help</code> to see the list of commands

Now your application is installed in path that was configured in defines.inc.php

###Consulting installed version###
*	Go into your installed application's path and type:
	<code>./app --version</code> or <code>./app --help</code> to see the list of commands.


Requirements
---------------------
*	PHP 5.2 or newer as the PHP documemtation ( http://www.php.net/manual/en/phar.requirements.php )
*	To generate the package is necessary phar.readonly variable be off.
	*	It's possible change it in php.ini	



