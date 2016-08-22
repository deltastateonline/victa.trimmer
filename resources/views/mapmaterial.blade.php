<html>  
<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    
   	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.2.0/material.indigo-pink.min.css">
	
	<link href="/css/sticky-footer.css" rel="stylesheet">
	<link href="/css/jquery.loadmask.min.css" rel="stylesheet">
	
	<script defer src="https://code.getmdl.io/1.2.0/material.min.js"></script>
   
	<script src="https://use.fontawesome.com/9a293d9ea0.js"></script>   
    <script type='text/javascript' src='/scripts/knockout-3.4.0.js'></script>
    <script type='text/javascript' src='/scripts/knockout.mapping.js'></script>    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script type='text/javascript' src='/scripts/jquery.loadmask.js'></script>    
	<script type="text/javascript" src="/scripts/maps.js"> </script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiG-W9yHgCjc1ugC6_M3-gn1wxho8gAuM&libraries=places&callback=initAutocomplete" async defer></script>
	
	<script type="text/javascript">
		var $_pageData = {
			loadingMessage : '{{$loadingMessage}}',
			serverEndPoint : '{{$serverController}}',	
		}
	</script>
	
</head>  
<body onLoad="geolocate()">  
<div class="container">  
	<div class="row" style="font-size:0.8em">
	<div class="six columns">&nbsp;</div>
		<div class="two columns"><a href="">Victa Lawn Mower Retailers</a>|</div>
		<div class="two columns"><a href="">Yellow Fever Vaccination Centers</a>|</div>
		<div class="two columns"><a href="">Motorcycle Service Centers</a></div>
	</div>
    <div class="row">
      <div class="twelve columns" style="margin-top: 1%">
	   <div id="locationField" class="twelve columns">
	   	<label>Enter an address or a suburb.</label>
		  <input id="autocomplete" class="u-full-width" placeholder="Enter an address or a suburb"  onFocus="geolocate()" type="text"></input>
		</div>
       </div> 
    </div>	
	<div class="row">
      <div class="eight columns" style="margin-top: 2%">      	
      	<div class="tag">
			<label style="font-size:1.2em;background-color:#FFFFFF"><center>{{$companyTitle}}</center></label>
			<div style="font-size:0.7em;" data-bind="template:{name:'resultsTmpl', data:$root, as:'pageTab'}"></div>
		</div>		
		<div id="victaMaps" class="u-full-width" style="width:100%;height:500px;background-color:#EFEFEF">Render Map Here</div>	
       </div> 
       <div class="four columns directionPanel">
       	<label>Directions</label>
       		<div id="victaDirection" style="height:460px;overflow-y:auto;"></div>
       	</div>       
    </div>	
	<!-- <div class="row">
		<div class='u-cf'></div>
	</div> -->
</div> 
<script id="resultsTmpl" type="text/html">
<!-- ko if :pageTab.totalRecords() > 0 -->
<div style='overflow-y:scroll;height:400px' id='resultDiv'>
<!-- ko foreach :pageTab.allItems() -->
<div class="eachResult" data-bind="css:{panelSelected: $data.id() == pageTab.currentSelectionId()}">
		<a href="javascript:void(0)" data-bind="click:$root.plotMap.bind($data,$parent)" title="Click for directions"><strong data-bind="safeText:$data.company, emptyText:'N/A'" ></strong></a><br />	
		<i data-bind="safeText:$data.distance, emptyText:'N/A'"></i><i> Km</i>
		<a class="u-pull-right" style="font-size:1.2em" href="javascript:void(0)" data-bind="click:$root.gotoMap.bind($data,$parent)" title="Open in Google Maps"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
		<br />		
		<span data-bind="safeText:$data.street, emptyText:'N/A'"></span> ,<br />
		<span data-bind="safeText:$data.state, emptyText:'N/A'"></span> <span data-bind="safeText:$data.postcode, emptyText:'N/A'"></span><br />		
		<a data-bind="href:$data.phone"><span data-bind="safeText:$data.phone, emptyText:'N/A'"></span></a>
		
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
	      <div style="text-align:center">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- app_deltastateonline -->
			<ins class="adsbygoogle"
				 style="display:inline-block;width:468px;height:60px"
				 data-ad-client="ca-pub-0692375547011702"
				 data-ad-slot="3497672953"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			</div>
			<p style="text-align:center;padding:5px;"><small >Designed By <a href="http://{{env('OUR_WEBSITE')}}">{{env('DESIGNED_BY')}}</a></small></p>
			<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			  ga('create', 'UA-65045919-1', 'auto');
			  ga('send', 'pageview');			
			</script>
        
      </div>
    </footer>
</body>  
</html> 