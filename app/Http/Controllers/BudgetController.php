<?php

namespace App\Http\Controllers;
use Log;
use App\User;
use App\Geolocation;
use Illuminate\Http\Request;

class BudgetController extends Controller
{

    public function show(Request $request)
    {
    	$template = $request->input('layout','');   	
    	
    	$data["title"]="Budget Mapper";
    	$data["companyTitle"] = "Budgets";
    	$data["loadingMessage"] = "Loading Budget, please wait...";
    	$data["serverController"] = "budget";
		return view('budgetmap'.$template,$data);       
    }
    public function showhealthcenters(Request $request)
    {
		$template = $request->input('layout','');   
    	$data["title"]="Yellow Fever Vaccines Directory";
    	$data["companyTitle"] = "Medical Centers";
    	$data["loadingMessage"] = "Loading Medical Centers, please wait...";
    	$data["serverController"] = "healthcenters";
    	return view('map'.$template,$data);
    }
	
	public function showmotocycles(Request $request)
    {
		$template = $request->input('layout','');   
    	$data["title"]="MotorCycle Service Centers";
    	$data["companyTitle"] = "MotorCycle Service Centers";
    	$data["loadingMessage"] = "Loading Service Centers, please wait...";
    	$data["serverController"] = "motorcycles";
    	return view('map'.$template,$data);
    }
    
    public function repairers(Request $request){    	
		$tableName = "trimmer";
		return $this->get_results($tableName,$request );
    }
    
    public function healthcenters(Request $request){    	
    	$tableName = "yellowf_centers";
		return $this->get_results($tableName,$request );	
    }
	
	public function motorcycles(Request $request){		
		$tableName = "motorcycle";
		return $this->get_results($tableName,$request );		
	}
	
	private function get_results($tableName,Request $request ){
		
		$geoData['lng']  = $request->input('lng');
    	$geoData['lat']  = $request->input('lat');			
    	 
    	$results = app('db')->select("SELECT *, {$this->_calucation_string($geoData)} FROM `".$tableName."` where ! isnull(lng) and status = 1 order by distance, company limit 20  ; ");
    
		$finalresutls = new \stdClass();
    	$finalresutls->success = TRUE;
    	$finalresutls->geoData =  $geoData;
    
    	$tmpResults = array();	
		
    	if(count($results) > 0){
    		foreach($results as $result){  
				$result->distance = sprintf("%.2f",$result->distance);  			
    			$tmpResults[] = (array)$result;    	   
    		}
    	}
    	 
    	$finalresutls->rs =  $tmpResults;
    	$finalresutls->total = count($finalresutls->rs);
    	return response()->json($finalresutls);
		
	}
    /**
     * Script to generate geolocation from database table.
     */        
    public function updategeolocation(){
    	
    	return;
    	//$tableName = "yellowf_centers";
		$tableName = "motorcycle"; // change this to the table name where the address are stored.
    	
    	$results = app('db')->select("SELECT * FROM `".$tableName."` where isnull(lng) order by company limit 20; ");
    	
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
	    			$update_lst[] = sprintf("update `".$tableName."` set lng='%s', lat='%s',accuracy='%s' where id = %d ;",
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
    	
    
    }
    
    /**
     * 
     * @param stdObject $result
     * @param array() $geoData
     * @return number
     */
    
    private function calculate_distance($result, $geoData){   	
    	
    	$theta = $result->lng - $geoData['lng'];
    	
    	$calc = sin(deg2rad($result->lat)) * sin(deg2rad($geoData['lat'])) + cos(deg2rad($result->lat)) * cos(deg2rad($geoData['lat'])) * cos(deg2rad($theta));
    	$calc = acos($calc);
    	$calc = rad2deg($calc);   	
    	
    	return round( ($calc * 60 * 1.1515) * 1.609344, 2);
    }
	/**
	 * 
	 * @param array() $geoData
	 * @return string
	 */
	private function _calucation_string($geoData){
		$str = sprintf("(3956 * 2 * ASIN(SQRT(POWER(SIN((lat- %f) * pi()/180 / 2), 2) + 
		COS(lat * pi()/180) *COS(%f * pi()/180) * POWER(SIN((lng - %f) * pi()/180 / 2), 2) )) * 1.609344) 
		as distance		
		",$geoData['lat'],$geoData['lat'],$geoData['lng']);		
		
		return $str;
	}
}