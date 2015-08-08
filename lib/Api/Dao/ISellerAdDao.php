<?php
namespace Api\Dao;




interface ISellerAdDao{


	/**
	* This method retrieves SellerAd records from the 
	* db. 
	* @param assoc array $getParams 
	*		These are parsed $_GET variables. 
	*		Use 'page' and 'amount' to paginate results.
	*       Use 'lat', 'lng' and 'radius' to fetch results for specific areas.
	* @return assoc array
	*/
	public function fetchGetList(array $getParams);
	
	/**
	* This method retrieves a SellerAd record from the 
	* db. 
	* @param $id The id of the record to fetch.
	* @return assoc array
	*/
	public function fetchGetItem($id);


}

