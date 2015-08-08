<?php
require_once 'vendor/autoload.php';
require_once 'dependencies/rb.php';

use Api\Base;

$config = include('config/default.php');

$app = new Base(array(
	'config' => $config['app'],
	'view' => new Api\Views\JsonView()));
	
	
$app->container->set('ISellerAdDao', function($c){
	return new Api\Dao\SellerAdDao($c['ISellerAdValidator']);
});

$app->container->set('ISellerAdValidator', function($c){
	return new Api\Validators\SellerAdValidator();
});

$app->container->set('SellerAdController', function($c) use ($app){
	return new Api\Controllers\SellerAdController($app, $c['ISellerAdDao']);
});

$app->container->set('ISellerDao', function($c){
	return new Api\Dao\SellerAdDao($c['ISellerAdValidator']);
});

$app->container->set('ISellerDao', function($c){	
	return new Api\Dao\SellerAdDao();
});



$app->view()->parserOptions = array(
    'debug' => true,
    //'cache' => dirname(__FILE__) . '/cache'
);

R::setup(sprintf('mysql:host=%s;dbname=%s', 
			$config['db']['host'],
			$config['db']['db']),
		$config['db']['username'],
		$config['db']['password'],
		FALSE
		);			
			
/*			
$app->notFound(function () use ($app) {
    $error = ['message' => 'Page Not Found'];
	$app->render(NULL, $error);

});*/

$app->add(new \Slim\Middleware\ContentTypes());
$app->add(new Api\Middleware\JSON('/api/v1'));



