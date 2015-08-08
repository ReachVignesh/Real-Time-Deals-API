<?php

require "../bootstrap.php";

use Api\Dao\SellerAdDao;
use Util\UrlUtils;
use Api\Exceptions\BadRequestException;
use Api\Exceptions\InvalidArgumentException;
use Api\Controllers\SellerAdController;
use Api\Validators\SellerAdValidator;
use Api\Validators\ISellerAdValidator;

/*\Slim\Route::setDefaultConditions(array(
    'id' => '[1-9][0-9]*'
));*/
/*
print "<pre>";
$ad = ["title" => "lol", "oldprfice" => 5, "price" => 2, "details" => "lsfsdfsdfsdfol" , "amount" => 5
	, "endtimestamp" => time(), "lat" => 45, "lng" => 78, "imagename" => "lol.png"];


$validator = new SellerAdValidator();
$dao = new SellerAdDao($validator);

$dao->saveAd($ad);

//print_r($errors);

exit();*/



$app->group("/api", function() use($app){	
	
	$app->group("/v1", function() use ($app){
		
		$app->get("/ad/", function() use ($app){			
			$app->container->get('SellerAdController')->displayAdList();	
			
		});
		
		$app->get("/ad/:id", function($id) use ($app){		
			$app->container->get('SellerAdController')->displayAd($id);			
					
		});	
		
		$app->post("/ad/", function() use ($app){
			$app->container->get('SellerAdController')->createAd();				
			
		});
	
	});	

});



/*// JSON friendly errors
// NOTE: debug must be false
// or default error template will be printed
$app->error(function (\Exception $e) use ($app) {

    $mediaType = $app->request->getMediaType();

    $isAPI = (bool) preg_match('|^/api/v.*$|', $app->request->getPath());

    // Standard exception data
    $error = array(
        'code' => $e->getCode(),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    );

    // Graceful error data for production mode
    if ('production' === $app->config('mode')) {
        $error['message'] = 'There was an internal error';
        unset($error['file'], $error['line']);
    }

    // Custom error data (e.g. Validations)
    if (method_exists($e, 'getData')) {
        $errors = $e->getData();
    }

    if (!empty($errors)) {
        $error['errors'] = $errors;
    }

    $log->error($e->getMessage());
    if ('application/json' === $mediaType || true === $isAPI) {
        $app->response->headers->set(
            'Content-Type',
            'application/json'
        );
        echo json_encode($error, JSON_PRETTY_PRINT);
    } else {
        echo '<html>
        <head><title>Error</title></head>
        <body><h1>Error: ' . $error['code'] . '</h1><p>'
        . $error['message']
        .'</p></body></html>';
    }

});*/






$app->run();




