<?php

namespace App\Http\Controllers;

use App\User;
use App\Geolocation;
use Illuminate\Http\Request;

class MapController extends Controller
{

    public function show()
    {
		return view('map');       
    }
    
    public function repairers(Request $request){
    	
    	$results = app('db')->select("SELECT * FROM trimmer where ! isnull(lng) and status = 1 order by company ; ");
    	$geoData['lng']  = $request->input('lng');
    	$geoData['lat']  = $request->input('lat');
    	
    	$finalresutls = new \stdClass();
    	$finalresutls->success = TRUE;
    	$finalresutls->geoData =  $geoData;
    
    	$tmpResults = array();    	
    	
    	if(count($results) > 0){
	    	foreach($results as $result){    		
	    		
	    		$theta = $result->lng - $geoData['lng'];
	    		
	    		$calc = sin(deg2rad($result->lat)) * sin(deg2rad($geoData['lat'])) + cos(deg2rad($result->lat)) * cos(deg2rad($geoData['lat'])) * cos(deg2rad($theta));
	    		$calc = acos($calc);
	    		$calc = rad2deg($calc);
	    		
	    		$result->distance = round( ($calc * 60 * 1.1515) * 1.609344, 2);	    		
	    		$tmpResults[] = (array)$result;   		
	    		
	    	}
	    	
	    	usort($tmpResults, function ($a, $b) {
	    		if ($a['distance'] == $b['distance']) {
	    			return 0;
	    		}
	    		return ($a['distance'] < $b['distance']) ? -1 : 1;
	    	});
    	}
    	
    	$finalresutls->rs =  array_slice($tmpResults, 0 ,20);     	
    	return response()->json($finalresutls);    	
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