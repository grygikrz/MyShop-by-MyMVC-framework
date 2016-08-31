<?php

/**
 * Session start
 */
session_start();


/**
 * Composer with Twig and PSR-4 (class autoloader).
 * For web template used "Mobile-first Responsive" from http://www.initializr.com
 */
require '../vendor/autoload.php';


/**
 * Init Settings
 */
new \App\Settings;

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);

//:apiemy wszystkie errory i wysylamy do naszych funkcji
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
//$router->add('{controller}/{action}');
//$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('home', ['controller' => 'Home', 'action' => 'index']);
//$router->add('home/index', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts/index', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/pl/index', ['controller' => 'Posts', 'language' => 'pl' ,'action' => 'index']);
//$router->add('posts/en/index', ['controller' => 'Posts', 'language' => 'en' ,'action' => 'index']);

$router->add('', ['controller' => 'Home', 'language' => 'en' ,'action' => 'index']);

$router->add('home', ['controller' => 'Home', 'language' => 'en' ,'action' => 'index']);
$router->add('home/en', ['controller' => 'Home', 'language' => 'en' ,'action' => 'index']);
$router->add('home/en/index', ['controller' => 'Home', 'language' => 'en' ,'action' => 'index']);  

$router->add('item', ['controller' => 'Item', 'language' => 'en' ,'action' => 'index']);
$router->add('item/en', ['controller' => 'Item', 'language' => 'en' ,'action' => 'index']);
$router->add('item/en/{id:\d+}', ['controller' => 'Item', 'language' => 'en' ,'action' => 'index']);

$router->add('items', ['controller' => 'Items', 'language' => 'en' ,'action' => 'index']);
$router->add('items/en', ['controller' => 'Items', 'language' => 'en' ,'action' => 'index']);
$router->add('items/en/index', ['controller' => 'Items', 'language' => 'en' ,'action' => 'index']);
$router->add('items/en/page/{id:\d+}', ['controller' => 'Items', 'language' => 'en' ,'action' => 'index']); 

$router->add('category', ['controller' => 'Category', 'language' => 'en' ,'action' => 'index']);
$router->add('category/en', ['controller' => 'Category', 'language' => 'en' ,'action' => 'index']);
$router->add('category/en/{id:\d+}/{name}', ['controller' => 'Category', 'language' => 'en' ,'action' => 'index']);
$router->add('category/en/{id:\d+}/{name}/page/{pageid:\d+}', ['controller' => 'Category', 'language' => 'en' ,'action' => 'index']);
$router->add('category/en/{id:\d+}/{name}/{subid:\d+}/{subname}', ['controller' => 'Category', 'language' => 'en' ,'action' => 'index']);
$router->add('category/en/{id:\d+}/{name}/{subid:\d+}/{subname}/page/{subpageid:\d+}', ['controller' => 'Category', 'language' => 'en' ,'action' => 'index']);

$router->add('about', ['controller' => 'About', 'language' => 'en' ,'action' => 'index']);
$router->add('about/en', ['controller' => 'About', 'language' => 'en' ,'action' => 'index']);
$router->add('about/en/index', ['controller' => 'About', 'language' => 'en' ,'action' => 'index']);

$router->add('contact', ['controller' => 'Contact', 'language' => 'en' ,'action' => 'index']);
$router->add('contact/en', ['controller' => 'Contact', 'language' => 'en' ,'action' => 'index']);
$router->add('contact/en/index', ['controller' => 'Contact', 'language' => 'en' ,'action' => 'index']);

$router->add('basket', ['controller' => 'Basket', 'language' => 'en' ,'action' => 'index']);
$router->add('basket/en', ['controller' => 'Basket', 'language' => 'en' ,'action' => 'index']);
$router->add('basket/en/index', ['controller' => 'Basket', 'language' => 'en' ,'action' => 'index']);
$router->add('basket/delete/{id:\d+}', ['controller' => 'Basket', 'language' => 'en' ,'action' => 'index']);

$router->add('admin', ['controller' => 'Admin', 'language' => 'en' ,'action' => 'index']);
$router->add('admin/panel', ['controller' => 'Admin', 'language' => 'en' ,'action' => 'index']);
$router->add('admin/users', ['controller' => 'AdminUsers', 'language' => 'en' ,'action' => 'index']); 

$router->dispatch($_SERVER['QUERY_STRING']);
