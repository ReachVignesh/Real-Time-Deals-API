<?php


namespace Api\Validators;

use Api\Validators\ISellerAdValidator;
use Respect\Validation\Validator as v;

class SellerAdValidator implements ISellerAdValidator{


	public function validateNewAd(array $ad){
	
		$errors = [];
		
		if(!isset($ad["title"])){
			$errors["title"][] = "Not specified";
		}else{
		
			if(!v::string()->length(2, 15)->validate($ad["title"])){
				$errors["title"][] = "Length (2, 15)";
			}
		
		}
		
		
		if(!isset($ad["details"])){
			$errors["details"][] = "Not specified";
		}else{
		
			if(!v::string()->length(10, 2500)->validate($ad["details"])){
				$errors["details"][] = "Length (10, 2500)";
			}
		
		}
		
		$oldPrice = 99999999999;
		if(!isset($ad["oldprice"])){
			$errors["oldprice"][] = "Not specified";
		}else{
		
			if(!v::int()->min(0)->max($oldPrice)->validate($ad["oldprice"])){
				$errors["oldprice"][] = "Must be an integer x, 0 <= x ";
			}else{
				$oldPrice = intval( $ad["oldprice"] );
			}
		
		}
		
		if(!isset($ad["price"])){
			$errors["price"][] = "Not specified";
		}else{
		
			if(!v::int()->min(0)->max($oldPrice)->validate($ad["price"])){
				$errors["price"][] = "Must be an integer x, 0 <= x <= oldprice";
			}
		
		}
		
		if(!isset($ad["amount"])){
			$errors["amount"][] = "Not specified";
		}else{
		
			if(!v::int()->min(0)->max(999999)->validate($ad["amount"])){
				$errors["price"][] = "Must be an integer";
			}
		
		}
		
		if(!isset($ad["endtimestamp"])){
			$errors["endtimestamp"][] = "Not specified";
		}else{
		
			if(!v::int()->min(0)->max(9999999999999)->validate($ad["endtimestamp"])){
				$errors["endtimestamp"][] = "Must be an integer";
			}
		
		}
		
		if(!isset($ad["lat"])){
			$errors["lat"][] = "Not specified";
		}else{
		
			if(!v::numeric()->min(-90)->max(90)->validate($ad['lat'])){
					$errors["lat"][] = "Invalid 'lat' number";
				}
				
		}
		
		if(!isset($ad["lng"])){
			$errors["lng"][] = "Not specified";
		}else{
			
			if(!v::numeric()->min(-180)->max(180)->validate($ad['lng'])){
				$errors["lng"][] = "Invalid 'lng' number";
			}
			
		}
		
		
		
		if(!isset($ad["imagename"])){
			$errors["imagename"][] = "Not specified";
		}else{
		
			if(!v::string()->length(2, 15)->validate($ad["imagename"])){
				$errors["imagename"][] = "Length (5, 25)";
			}
		
		}
		
		
		
		return $errors;
	
	}




}





