<?php


namespace Api\Validators;


interface ISellerAdValidator{

	/**
	* 
	* @param $ad to be validated
	* @return array Errors if any
	**/
	public function validateNewAd(array $ad);
}





