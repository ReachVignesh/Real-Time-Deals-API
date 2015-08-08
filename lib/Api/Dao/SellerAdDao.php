<?php
namespace Api\Dao;

use \Api\Exceptions\InvalidArgumentException;
use \Api\Dao\ISellerAdDao;

use Respect\Validation\Validator as v;
use RedBeanPHP\Facade as R;
use Api\Validators\ISellerAdValidator;

use Api\Exceptions\ValidationException;

class SellerAdDao implements ISellerAdDao{

	private $validator;

	public function __construct(ISellerAdValidator $validator){
		$this->validator = $validator;
	}


	/**
	* This method retrieves SellerAd records from the 
	* db. 
	* @param assoc array $getParams 
	*		These are parsed $_GET variables. 
	*		Use 'page' and 'amount' to paginate results.
	*       Use 'lat', 'lng' and 'radius' to fetch results for specific areas.
	* @return assoc array
	*/
	public function fetchGetList(array $getParams){
	
		$page = 1;
		$amount = 10;
		
		$selectClause = "";
		$whereClause = " WHERE";
		$limitClause = "";
		$fullQsssuery = "";
		
		$queryParams = array();
		
	
		$hasWhere = false;
		
		
		if(isset($getParams['page'])){
			if(v::int()->min(0)->validate($getParams['page']) ){		
				$page = intval($getParams['page']);			
			}else{				
				throw new InvalidArgumentException("Invalid page number");				
			}		
		}
		
		if( isset($getParams['amount'])){
			if(v::int()->min(0)->max(100)->validate($getParams['amount']) ){		
				$amount = intval($getParams['amount']);			
			}else{				
				throw new InvalidArgumentException("Invalid amount");				
			}
		}
		
		$queryParams[':offset'] = ($page - 1) * $amount;
		$queryParams[':count'] = $amount;
		
		
		if(isset( $getParams['lat'] ) || isset($getParams['lng']) || isset($getParams['radius'])){
		
			if(!isset( $getParams['lat'] ) || !isset($getParams['lng']) || !isset($getParams['radius'])){
				throw new InvalidArgumentException("'lat', 'lng' and 'radius' must be set together");
			}
		
			if(!v::numeric()->min(-90)->max(90)->validate($getParams['lat'])){
				throw new InvalidArgumentException("Invalid 'lat' number");
			}
			
			if(!v::numeric()->min(-180)->max(180)->validate($getParams['lng'])){
				throw new InvalidArgumentException("Invalid 'lng' number");
			}
			
			if(!v::numeric()->validate($getParams['radius'])){
				throw new InvalidArgumentException("Invalid 'radius' number");
			}			
			
			$hasWhere = true;
			
			
			$R = 6371;
			$lat = round($getParams['lat'], 4);
			$lng = round($getParams['lng'], 4);
			$radius = round($getParams['radius'], 4);
			// first-cut bounding box (in degrees)
			$maxLat = $lat + rad2deg($radius/$R);
			$minLat = $lat - rad2deg($radius/$R);
			// compensate for degrees longitude getting smaller with increasing latitude
			$maxLng = $lng + rad2deg($radius/$R/cos(deg2rad($lat)));
			$minLng = $lng - rad2deg($radius/$R/cos(deg2rad($lat)));
			
			$whereClause .= ' lat BETWEEN :minLat AND :maxLat
			AND lng BETWEEN :minLng And :maxLng ';
			
			$queryParams[':minLat'] = $minLat;
			$queryParams[':minLng'] = $minLng;
			$queryParams[':maxLat'] = $maxLat;
			$queryParams[':maxLng'] = $maxLng;
		
		}
		
		$selectClause = "SELECT * FROM sellerads";	
		$limitClause = " LIMIT :offset, :count";
		
		
		$fullQuery = $selectClause . ($hasWhere? $whereClause: "") . $limitClause;
		
		//print $fullQuery . "<pre>";
		//print_r($queryParams);
		
		$ads = R::getAll($fullQuery, $queryParams);//->export();
			
		return $ads; 	
	
	}
	
	/**
	* This method retrieves a SellerAd record from the 
	* db. 
	* @param $id The id of the record to fetch.
	* @return assoc array
	*/
	public function fetchGetItem($id){
	
		if(v::int()->min(0)->validate($id)){		
			$id = intval($id);	
			
		}else{	
	
			throw new InvalidArgumentException("Invalid id");				
		}
		
		
		$ads = R::getAll("SELECT * FROM sellerads WHERE id = :id", 
			array(':id' => $id));//->export();
			
		if(count($ads) == 0){
			return NULL;
		}else{
			return $ads[0];
		}
	
	}	
	

	public function createAd(array $ad){
		
		$errors = $this->validator->validateNewAd($ad);
		
		if(!empty($errors)){
			throw new ValidationException("Error in ad", 0, $errors);
		}
		
		$adBean = R::dispense('sellerads');
		$adBean->import($ad);
		R::store($adBean);
		
	}


}





