<?php

namespace Api\Controllers;


class BaseController{

	protected $app;

	public function __construct($app){
		$this->app = $app;			
	}


	public function renderError($message, $code = 0, array $details = array()){
	
		$error = ["message" => $message];
		if($code != 0){
			$error['code'] = $code;		
		}
		
		if(!empty($details)){
			$error["details"] = $details;
		}
		
		
		$this->app->render(NULL, $error);
	
	}

}
















