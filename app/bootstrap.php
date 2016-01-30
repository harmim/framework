<?php

/*
 * @author Dominik Harmim <harmim6@gmail.com>
 */

mb_internal_encoding("UTF-8");

define('ROOT_DIR', realpath(__DIR__ . '/..'));
define('APP_DIR', realpath(__DIR__));
define('CONTROLLERS_DIR', APP_DIR . '/controllers');
define('MODEL_DIR', APP_DIR . '/model');
define('VIEW_DIR', APP_DIR . '/view');
define('VENDOR_DIR', ROOT_DIR . '/vendor');

// load dependecies
require VENDOR_DIR . '/autoload.php';

$loader = new Symfony\Component\ClassLoader\ClassLoader();
$loader->addPrefixes([
	'App' => ROOT_DIR,
]);
$loader->register();

dibi::connect([
	'driver' => '',
	'host' => '',
	'username' => '',
	'password' => '',
	'database' => '',
	'lazy' => TRUE,
]);

$router = new App\Router\Router($_SERVER['REQUEST_URI']);
$router->createRouter();
