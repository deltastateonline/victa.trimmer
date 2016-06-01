<?php  
namespace App;
class Geolocation {


		private $_accuracy = null;
		private $_geocode_status = null;
		
		private $requestClient = null;


		public function __construct()
		{

			$this->_accuracy['ROOFTOP'] = 9;
			$this->_accuracy['RANGE_INTERPOLATED'] = 7;
			$this->_accuracy['GEOMETRIC_CENTER'] = 6;
			$this->_accuracy['APPROXIMATE'] = 5;

			$this->_geocode_status['OK'] = 200;
			$this->_geocode_status['ZERO_RESULTS'] = 602;
			$this->_geocode_status['OVER_QUERY_LIMIT'] = 620;
			$this->_geocode_status['REQUEST_DENIED'] = 400;
			$this->_geocode_status['INVALID_REQUEST'] = 400;
			$this->_geocode_status['UNKNOWN_ERROR'] = 500;
		}

		/**
		 * Take string, use google api to geocode and then return an associative array
		 * @param string $address
		 * @throws \Exception
		 * @return array('lat'=>,'lng', 'accuracy') <unknown, number>
		 */
		function generate_geocode($address){

			if(isset($address)){
				return $this->geocoding_address($address);
			}else{
				throw new \Exception("Invalid Address");
			}

		}		
		
		private function geocoding_address($address){

			$response = NULL;		
			
			$d_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address); //."&client=".GOOGLE_CLIENT_ID;			
			//$d_url =  $this->_signUrl($d_url,GOOGLE_CRYPT_KEY);		

			$server = parse_url($d_url);
			$curl = curl_init($server['scheme'] . '://' . $server['host'] . $server['path'] . (isset($server['query']) ? '?' . $server['query'] : ''));
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_PORT, $server['host']);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $server['query']);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($curl, CURLOPT_REFERER, 'http://local.adjustitapi.com/repairer');
			curl_setopt($curl, CURLOPT_AUTOREFERER, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, 60);

			if (($response = curl_exec($curl)) === false) {
				$error_string =  'Curl error: ' . curl_error($curl) . 'in file ' . __FILE__;
				throw new \Exception($error_string);
			}
			curl_close($curl);

			if($response){
				$json = json_decode($response);
				$geo['status'] = $json->status ;
				if ($geo['status'] == 'OK') {
					$geo['lat'] = $json->results[0]->geometry->location->lat;
					$geo['lng'] = $json->results[0]->geometry->location->lng;
					$geo['accuracy'] = $this->get_accuracy($json->results[0]->geometry->location_type);

					unset($geo['status']);
					return $geo;
				}else{
					@$geo['error_message'] = $json->error_message ;					
					$error = array("Response"=>$geo['status'], "invalid"=>$geo['error_message'],'url'=>$d_url);
					//throw new \Exception(json_encode($error));
				}
				return $geo;
			}else{
				throw new \Exception("No Response", STOP_CRITICAL);
			}
		}

		/**
		 Google Maps V2:
		 G_GEO_SUCCESS = 200	 No errors occurred; the address was successfully parsed and its geocode has been returned.
		 G_GEO_BAD_REQUEST = 400	 A directions request could not be successfully parsed. For example, the request may have been rejected if it contained more than the maximum number of waypoints allowed.
		 G_GEO_SERVER_ERROR = 500	 A geocoding, directions or maximum zoom level request could not be successfully processed, yet the exact reason for the failure is not known.
		 G_GEO_MISSING_QUERY = 601	 The HTTP q parameter was either missing or had no value. For geocoding requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.
		 G_GEO_MISSING_ADDRESS = 601	 Synonym for G_GEO_MISSING_QUERY.
		 G_GEO_UNKNOWN_ADDRESS = 602	 No corresponding geographic location could be found for the specified address. This may be due to the fact that the address is relatively new, or it may be incorrect.
		 G_GEO_UNAVAILABLE_ADDRESS = 603	 The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.
		 G_GEO_UNKNOWN_DIRECTIONS = 604	 The GDirections object could not compute directions between the points mentioned in the query. This is usually because there is no route available between the two points, or because we do not have data for routing in that region.
		 G_GEO_BAD_KEY = 610	 The given key is either invalid or does not match the domain for which it was given.
		 G_GEO_TOO_MANY_QUERIES = 620	 The given key has gone over the requests limit in the 24 hour period or has submitted too many requests in too short a period of time. If you're sending multiple requests in parallel or in a tight loop, use a timer or pause in your code to make sure you don't send the requests too quickly.

		 Google Maps V3:
		 "OK" indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
		 "ZERO_RESULTS" indicates that the geocode was successful but returned no results. This may occur if the geocode was passed a non-existent address or a latlng in a remote location.
		 "OVER_QUERY_LIMIT" indicates that you are over your quota.
		 "REQUEST_DENIED" indicates that your request was denied, generally because of lack of a sensor parameter.
		 "INVALID_REQUEST" generally indicates that the query (address or latlng) is missing.
		 UNKNOWN_ERROR indicates that the request could not be processed due to a server error. The request may succeed if you try again.
		 */
		private function get_geocode_status($status=''){
			return isset($this->_geocode_status[$status])?$this->_geocode_status[$status]:0;
		}


		/**
		 Google Maps V2:
			0	Unknown accuracy.
			1	Country level accuracy.
			2	Region (state, province, prefecture, etc.) level accuracy.
			3	Sub-region (county, municipality, etc.) level accuracy.
			4	Town (city, village) level accuracy.
			5	Post code (zip code) level accuracy.
			6	Street level accuracy.
			7	Intersection level accuracy.
			8	Address level accuracy.
			9	Premise (building name, property name, shopping center, etc.) level accuracy.

			Google Maps V3:
			"ROOFTOP" indicates that the returned result is a precise geocode for which we have location information accurate down to street address precision.
			"RANGE_INTERPOLATED" indicates that the returned result reflects an approximation (usually on a road) interpolated between two precise points (such as intersections). Interpolated results are generally returned when rooftop geocodes are unavailable for a street address.
			"GEOMETRIC_CENTER" indicates that the returned result is the geometric center of a result such as a polyline (for example, a street) or polygon (region).
			"APPROXIMATE" indicates that the returned result is approximate.
			*/
		private function get_accuracy($location_type){
			return isset($this->_accuracy[$location_type])?$this->_accuracy[$location_type]:0;
		}
		
		// Encode a string to URL-safe base64
		private function _encodeBase64UrlSafe($value)
		{
			return str_replace(array('+', '/'), array('-', '_'),base64_encode($value));
		}
		
		// Decode a string from URL-safe base64
		private function _decodeBase64UrlSafe($value)
		{
			return base64_decode(str_replace(array('-', '_'), array('+', '/'),$value));
		}
		
		// Sign a URL with a given crypto key
		// Note that this URL must be properly URL-encoded
		private function _signUrl($myUrlToSign, $privateKey)
		{
			// parse the url
			$url = parse_url($myUrlToSign);
		
			$urlPartToSign = $url['path'] . "?" . $url['query'];
		
			// Decode the private key into its binary format
			$decodedKey = $this->_decodeBase64UrlSafe($privateKey);
		
			// Create a signature using the private key and the URL-encoded
			// string using HMAC SHA1. This signature will be binary.
			$signature = hash_hmac("sha1",$urlPartToSign, $decodedKey,  true);
		
			$encodedSignature = $this->_encodeBase64UrlSafe($signature);
		
			return $myUrlToSign."&signature=".$encodedSignature;
		}
		
		
		
}