<h1>Phar-installer</h1>

<h2>Description</h2>
Phar-installer makes easy package, deploy and install your PHP application.

Applying it in your project is very simple, it just needed copy some files to your application and configure it.

<h2>Step by step</h2>
1.	Download the sorce of Phar-installer
2.	Copy the followinf files to your application's root dir
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
7.	Type teh following command to install:<br/>
	<code>php package install</code> or <code>php package --help</code> to see the list of commands

Now your application is installed in path that was configured in defines.inc.php

<h2>Requirements</h2>


