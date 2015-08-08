<?php

namespace Api\Views;


class JsonView extends \Slim\View{


	public function render($template, $data = NULL){
		$app = \Slim\Slim::getInstance();
		$data = $this->data->all();
		unset($data['flash']);
	
		echo ( json_encode($data, JSON_PRETTY_PRINT) );
		
	
	}


}






