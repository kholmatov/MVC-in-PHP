<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:55
 */
define('_ROOTPATH_',realpath(dirname(__FILE__)));

if (isset($_GET['controller']))  $controller = ucfirst($_GET['controller']);
else $controller = 'Tasks';
$controller .= 'Controller';
require_once('assets/paginator.php');
require_once('views/layots/main.php');
require_once(_ROOTPATH_.'/controllers/'.$controller.'.php');
$class = new $controller();
$class->view = new MainView();
$class->handleRequest();
//require_once('views/layout.php');
