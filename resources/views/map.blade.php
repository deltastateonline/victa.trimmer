<html>  
<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Victa Trimmer</title>
    <link href="/css/skeleton204/css/skeleton.css" rel="stylesheet" type="text/css"/>
	<link href="/css/skeleton204/css/normalize.css" rel="stylesheet" type="text/css"/>
	<link href="/css/sticky-footer.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Alegreya:400,700|Roboto+Condensed' rel='stylesheet' type='text/css'>
    <script type='text/javascript' src='/scripts/knockout-3.4.0.js'></script>
    <script type='text/javascript' src='/scripts/knockout.mapping.js'></script>    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script type="text/javascript" src="/scripts/maps.js"> </script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiG-W9yHgCjc1ugC6_M3-gn1wxho8gAuM&libraries=places&callback=initAutocomplete" async defer></script>
	
	
</head>  
<body onLoad="geolocate()">  
<div class="container">  
    <div class="row">
      <div class="twelve columns" style="margin-top: 5%">
	   <div id="locationField" class="twelve columns">
		  <input id="autocomplete" class="u-full-width" placeholder="Enter an address or a suburb"  onFocus="geolocate()" type="text"></input>
		</div>
       </div> 
    </div>
	
	<div class="row">
      <div class="twelve columns" style="margin-top: 5%">
		<div id="victaMaps" class="u-full-width" style="width:100%;height:500px;background-color:#EFEFEF">map here</div>
       </div> 
    </div>
	
	
</div> 

   <footer class="footer">
      <div class="container">
        <p class="text-muted">Render the adverts here.</p>
      </div>
    </footer> 
	
</body>  
</html> 