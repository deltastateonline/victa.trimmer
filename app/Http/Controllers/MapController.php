<?php

namespace App\Http\Controllers;

use App\User;
use App\Geolocation;

class MapController extends Controller
{

    public function show()
    {
		return view('map');       
    }
    
    public function repairers(){
    	
    }
    public function repairers1(){
    	
    	$results = app('db')->select("SELECT * FROM trimmer where isnull(lng) order by company limit 50; ");
    	
    	$geolocation = new Geolocation();
    	//echo "<pre>";
    	//var_dump($results);
    	$update_lst = array();
    	$address_lst = array();
    	
    	foreach($results as $aCompany){  
    		$address = sprintf("%s %s %s",$aCompany->street,$aCompany->suburb,$aCompany->postcode );
    		try {
    			
    			$geo = $geolocation->generate_geocode($address);    			

    			if(!empty($geo['lng'])){
	    			$update_lst[] = sprintf("update trimmer set lng='%s', lat='%s',accuracy='%s' where id = %d ;",
	    			$geo['lng'],$geo['lat'],$geo['accuracy'], $aCompany->id);    			
    			}
    			
    			$address_lst[] = $address;
    		} catch (Exception $e) {
    			
    		}
    		
    		
    	}
    	echo "<pre>";
    		echo implode("<br />",$update_lst);
    	echo "<ol>";
    		echo "<li>";
    			echo implode("</li><li>",$address_lst);
    	echo "</li>";
    	
    	echo "</ol>";
    	echo "</pre>";
    	
    	//return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }
}