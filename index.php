<?php
/**
 * @author Michal Cichon
 * @version 1.0
 */
session_start();
/**
 * Metoda ładująca automatycznie controllery
 * @param $class Nazwa klontrollera
 */
function __autoload($class)
{
	$class = strtolower($class);
	if(file_exists('controller/'.$class.'.php'))
		include_once 'controller/'.$class.'.php';
	else if(file_exists('model/'.$class.'.php'))
		include_once 'model/'.$class.'.php';
}

require_once 'lib/int.php';

$controller = @$_GET['controller'] ? $_GET['controller']  : 'start';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$form = isset($_POST['form']) ? $_POST['form'] : null;

$obj = new $controller;

$res = $obj->$action($form);

//echo "<pre>";
//print_r($_SESSION);

