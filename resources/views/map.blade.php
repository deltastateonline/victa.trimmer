<html>  
<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Victa . National Service Directory</title>
    <link href="/css/starveling/css/starveling.css" rel="stylesheet" type="text/css"/>
	<link href="/css/starveling/css/normalize.css" rel="stylesheet" type="text/css"/>
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
	   	<label>Enter an address or a suburb.</label>
		  <input id="autocomplete" class="u-full-width" placeholder="Enter an address or a suburb"  onFocus="geolocate()" type="text"></input>
		</div>
       </div> 
    </div>	
	<div class="row">
      <div class="twelve columns" style="margin-top: 2%">      	
      	<div class="tag">
			<h5 style="font-size:1.3em;background-color:#FFFFFF"><center>Repairers</center></h5>
			<div style="font-size:0.7em;" data-bind="template:{name:'resultsTmpl', data:$root, as:'pageTab'}"></div>
		</div>		
		<div id="victaMaps" class="u-full-width" style="width:100%;height:500px;background-color:#EFEFEF">map here</div>	
       </div>        
    </div>	
	<div class="row">
		<div class='u-cf'></div>
	</div>
</div> 

<script id="resultsTmpl" type="text/html">
<!-- ko if :pageTab.totalRecords() > 0 -->
<div style='overflow-y:scroll;height:400px'>
<!-- ko foreach :pageTab.allItems() -->
<div class="eachResult">
		<a href="javascript:void(0)" data-bind="click:$root.plotMap.bind($data,$parent)"><strong data-bind="text:$data.company()" ></strong></a><br />	
		<i data-bind="text:$data.distance()"></i><i> Km</i><br />		
		<span data-bind="text:$data.street"></span> ,<br />
		<span data-bind="text:$data.state"></span> <span data-bind="text:$data.postcode"></span><br />
		<a data-bind="href:$data.phone"><span data-bind="text:$data.phone"></span></a>	
</div>
<!-- /ko -->
</div>
<!-- /ko -->
<!-- ko if :pageTab.totalRecords() == 0 -->
<div class="eachResult">
    <div class="">
        <div class="alert alert-danger text-center" role="alert">
            <b>No Results</b>
        </div>
    </div>
</div>
<!-- /ko -->
</script>
   <footer class="footer">
      <div class="container">
        <p class="text-muted">Render the adverts here.</p>
      </div>
    </footer>
</body>  
</html> 