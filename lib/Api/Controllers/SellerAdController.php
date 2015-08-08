<?php

namespace Api\Controllers;

use Api\Base;
use Api\Exceptions\InvalidArgumentException;
use Api\Dao\ISellerAdDao;
use Api\Controllers\BaseController;
use Util\UrlUtils;
use Api\Validators\ISellerAdValidator;
use Api\Exceptions\ValidationException;

use \Slim\Slim;




class SellerAdController extends BaseController{

	private $sellerAdDao;
	private $sellerAdValidator;

	public function __construct(\Slim\Slim $app, ISellerAdDao $sellerAdDao){
		parent::__construct($app);
		$this->sellerAdDao = $sellerAdDao;
	}


	public function displayAdList(){
	
		$ads;
			
		try{
			$ads = $this->sellerAdDao->fetchGetList(UrlUtils::parseGetParams($_SERVER['QUERY_STRING']));
		}catch(InvalidArgumentException $e){
			
			$this->renderError($e->getMessage());
			$this->app->status(400);
			$this->app->stop();
			
		}
			
		
		$this->app->render(NULL, $ads);
	
	
	}

	public function displayAd($id){
		
		$ads;
			
		try{
			$ads = $this->sellerAdDao->fetchGetItem($id);
		}catch(InvalidArgumentException $e){
			$this->renderError($e->getMessage());
			$this->app->status(400);
			$this->app->stop();
			
		}
		
		if($ads == NULL){
			$this->app->notFound();
			$this->app->stop();
		}
		
		$this->app->render(NULL, $ads);
	
	}
	
	public function createAd(){
		
		try{
			$this->sellerAdDao->createAd($this->app->request->getBody());
		}catch(ValidationException $e){
			$this->renderError("Invalid ad", 0, $e->getData());
			$this->app->status(400);
			$this->app->stop();
		}
		
	}


}












