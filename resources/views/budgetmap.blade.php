<html lang="en">  
<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!--  <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$title}}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
	<link href="/css/sticky-footer.css" rel="stylesheet">
	<link href="/css/jquery.loadmask.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Alegreya:400,700|Roboto+Condensed' rel='stylesheet' type='text/css'>
   
	<script src="https://use.fontawesome.com/9a293d9ea0.js"></script>   
    <script type='text/javascript' src='/scripts/knockout-3.4.0.js'></script>
    <script type='text/javascript' src='/scripts/knockout.mapping.js'></script>    
	<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script> -->
	
		
	


	<script type="text/javascript">
		var $_pageData = {
			loadingMessage : '{{$loadingMessage}}',
			serverEndPoint : '{{$serverController}}',	
		}
	</script>
	
</head>  
<body onLoad="geolocate()">  
<div class="container-fluid">  

		<div class="row" >
			<div class="col" style="font-size:2em">{{$title}}</div>
			<div class="col" style="font-size:0.8em;"><br /><a href="">Moreton Bay</a></div>
		</div>		
		<form>
		    <div id="locationField" class="form-group">
		   	  <label>Enter an address or a suburb.</label>
			  <input id="autocomplete" placeholder="Enter an address or a suburb" data-bind="value:$root.addressString" onFocus="geolocate()" type="text" class="form-control"></input>
			</div> 
		</form>	    
		<div class="row">	       	
	      	<div class="col-2">
				<label style="font-size:1.2em;background-color:#FFFFFF"><center>{{$companyTitle}}</center></label>
				<div style="font-size:0.7em;" data-bind="template:{name:'budgetTmpl', data:$root.currentSelection, as:'pageTab'}"></div>
			</div>		
			<div id="victaMaps" class="col-10" style="width:100%;height:500px;background-color:#EFEFEF">Render Map Here</div>	                
	    </div>	
</div> 
<script id="budgetTmpl" type="text/html">

<form>
	<div  id='resultDiv' class="row1">
		<div class="form-group"><label for="lng">Longitude</label>
			<input type="text" data-bind="value:$data.lng" class="form-control" />
		</div>
		<div class="form-group"><label for="lat">Latitude</label>
			<input type="text" data-bind="value:$data.lat" class="form-control"/>
		</div>
		<div class="form-group"><label for="worktype">Work Type</label>
			<input type="text" data-bind="value:$data.worktype" class="form-control" list="worktypeList"/>
		</div>
		<div class="form-group"><label for="budget">Budget</label>
			<input name="budget" type="text" class="form-control"  data-bind="value:$data.budget" />
		</div>
		<div class="form-group"><label for="description">Budget Description</label>
			<textarea  data-bind="value:$data.description" class="form-control"/></textarea>
		</div>
		<div class="form-group"><label for="">Divisions </label>
			<select data-bind="options:$root.divisions,  optionsText:'name', optionsValue:'id', value:$data.division" class="form-control"/></select>
		</div>
		<div class="form-group"><label for="">Councillors</label>
			<select  data-bind="options:$root.councillors, optionsText:'name', optionsValue:'id', value:$data.councillor" class="form-control"/></select>
		</div>
		<div class="form-group">
			<input class="btn btn-primary" type="button" value="Add Budget" data-bind="click:$root.saveData.bind($data)">
		</div>		
	</div>	
</form>
<!-- ko if :pageTab.currentSelection -->
<!-- /ko -->

</script>
<script id="resultsTmpl" type="text/html">
<!-- ko if :pageTab.totalRecords() > 0 -->
<div style='overflow-y:scroll;height:400px' id='resultDiv'>
<!-- ko foreach :pageTab.allItems() -->
<div class="eachResult" data-bind="css:{panelSelected: $data.id() == pageTab.currentSelectionId()}">
		<a href="javascript:void(0)"  title="Click for directions"><strong data-bind="safeText:$data.company, emptyText:'N/A'" ></strong></a><br />	
		<i data-bind="safeText:$data.distance, emptyText:'N/A'"></i><i> Km</i>
		<a class="u-pull-right" style="font-size:1.2em" href="javascript:void(0)"  title="Open in Google Maps"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
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
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   
   <script type='text/javascript' src='/scripts/jquery.loadmask.js'></script> 
	<script type="text/javascript" src="/scripts/maps.budget.js"> </script>	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiG-W9yHgCjc1ugC6_M3-gn1wxho8gAuM&libraries=places&callback=initAutocomplete" async defer></script>
    
    <datalist id="worktypeList">
			<option value="Road Works">
			<option value="Sport">
			<option value="Civil Works">
			<option value="Storm Works">
			<option value="Bus Stops Works">
			<option value="Design Work">
			<option value="Lift">
			<option value="Water">
			<option value="Playgroud">
			<option value="Pedestrian">
			<option value="Footpaths">
			<option value="Lighting">
	</datalist>
</body>  
</html> 