<?php
/**
 * PSR-4 Compliant Autoloader
 *
 * This will dynamically load classes by resolving the prefix and class name. This is the method that frameworks
 * such as Laravel and Composer automatically resolve class names and load them. To use it, simply set the
 * configurable parameters inside the closure. This example is taken from PHP-FIG, deepdive class notes, referenced below.
 *
 * @param string $class fully qualified class name to load
 * @see http://www.php-fig.org/psr/psr-4/examples/ PSR-4 Example Autoloader
 **/
spl_autoload_register(function($Profile) {
	/**
	 * CONFIGURABLE PARAMETERS
	 * prefix: the prefix for all the classes (i.e., the namespace)
	 * baseDir: the base directory for all classes (default = current directory)
	 **/
	$prefix = "Edu\\Cnm\\DataDesign";
	$baseDir = __DIR__;

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $Profile, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$Profile = substr($Profile, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $baseDir . str_replace("\\", "/", $Profile) . ".php";


	// if the file exists, require it
	if(file_exists($file)) {
		require_once($file);
	}
});
