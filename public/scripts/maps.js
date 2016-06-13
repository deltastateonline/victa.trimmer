  // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete,mapDetails;
      
      var $_RM = {
    		 
    		  startPoint : {},
    		  endPoint : {}
      }
	    
	    var marker = null;   
	  

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
		
		var mapProp = {
			center:new google.maps.LatLng(-27.4710,153.0234),
			zoom:8,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		  };		
		
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode'],componentRestrictions: {country: "au"}});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
		
		mapDetails = new google.maps.Map(document.getElementById("victaMaps"));
		mapDetails.setMapTypeId(google.maps.MapTypeId.ROADMAP);
		mapDetails.setZoom(10);  
		mapDetails.setCenter(new google.maps.LatLng(-27.4710,153.0234 ));	
		
		
		 marker = new google.maps.Marker({
	        map: mapDetails,
	        anchorPoint: new google.maps.Point(0, -29)
	     });
		 
		 $_RM.directionsService = new google.maps.DirectionsService;
		 $_RM.directionsDisplay = new google.maps.DirectionsRenderer({map:mapDetails});
		
      }  

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        marker.setVisible(false);
        
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        
        
        if (place.geometry.viewport) {
        	mapDetails.fitBounds(place.geometry.viewport);
	    } else {
	    	mapDetails.setCenter(place.geometry.location);
	    	mapDetails.setZoom(13);  // Why 17? Because it looks good.
	    }
        
        marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
          
          $_RM.startPoint = place.geometry.location ; //Set the stating point
          
          $('#victaMaps').loadmask($_pageData.loadingMessage); 
          
          $.getJSON('/'+$_pageData.serverEndPoint+'/?lat='+place.geometry.location.lat()+'&lng='+place.geometry.location.lng(), function(records){
        	  
        	  if(records.success){        		  
        		  obj.reset();
  			      var  tmpObjectList = obj.allItems();			   
  			      tmpObjectList =  wrapFunction(records.rs,tmpObjectList,normalFunction);
  			      obj.allItems(tmpObjectList);  
  			    $('#victaMaps').unloadmask();
        	  }
          });		
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });			
			
            autocomplete.setBounds(circle.getBounds());
			mapDetails.setZoom(10);  
			mapDetails.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude ));
          });    
		  	
        }
      }
	  

 function wrapFunction(currentArray,currentItemList,processingObject){	
	$.each(currentArray, function( key, value ) {	    	
		currentItemList.push(new processingObject(value));
    });		
	return currentItemList;
}
 var normalFunction = function (inputData){
	 
	if(inputData.id !== undefined){
		var map = ko.mapping.fromJS(inputData,mapping);
	}else{
		var map = ko.mapping.fromJS(inputData);
	}		
	return map;
}
 var mapping = {
	'key': function(data){
		return ko.utils.unwrapObservable(data.id);
	}
}
 
 function currentPoint(data){
	 var self = this;
	 
	 self.selected = false;
	 self.pointData = ko.observable({});	
 }
 
 currentPoint.prototype.init = function(data){
		var self = this;		
		self.pointData(data);
		self.selected = true;
}
 
 
 function pageModel(){
		
	var self = this;
	self.allItems = ko.observableArray([]);
	self.currentSelection = new currentPoint({});
	
	self.currentSelectionId = ko.observable();	
	
	self.totalRecords = ko.computed(function(){
		return self.allItems().length;
	});
	
	self.reset = function(){		
		return self.allItems.removeAll();	
	}
	
	self.plotMap = function(rootObject, mapPoint){
		
		//self.currentSelection.init(mapPoint);
		
		$('#victaMaps').loadmask('Loading Route, please wait...');
		
		 var cMapPoint = ko.toJS(mapPoint);		 
		 var centrePoint = {lat: parseFloat(cMapPoint.lat), lng: parseFloat(cMapPoint.lng)};
		 
		 self.currentSelectionId(cMapPoint.id)
		 
		 $_RM.endPoint = new google.maps.LatLng(centrePoint.lat, centrePoint.lng);

		 var request = {
	        origin : $_RM.startPoint,
	        destination : $_RM.endPoint,
	        travelMode : google.maps.TravelMode.DRIVING
	    };		 
		
		 $_RM.directionsService.route(request, function(response, status) {
	        if (status == google.maps.DirectionsStatus.OK) {
	        	$_RM.directionsDisplay.setDirections(response);
	        	$('#victaMaps').unloadmask();
	        }
	    });	
		 
	 }
}

 var obj = new pageModel();
 
$(document).ready(function(){
	 // jQuery methods go here... 	
	 ko.applyBindings(obj);
});

//custom ko binding to display safely the object properties even if
//they are undefined or empty
ko.bindingHandlers.safeText = {
	update: function (element, valueAccessor, allBindingsAccessor) {

		var emptyText = ko.unwrap(allBindingsAccessor.get('emptyText')) || "";
		var prfx = ko.unwrap(allBindingsAccessor.get('prefix')) || "";
		var psfx = ko.unwrap(allBindingsAccessor.get('postfix')) || "";

		try {
			var tryGetValue = ko.unwrap(valueAccessor());
			// handle empty strings
			tryGetValue = tryGetValue.length === 0 ? emptyText : prfx + tryGetValue + psfx;
			// and finally update the text attribute of the element
			ko.bindingHandlers.text.update(element, function () { return tryGetValue; });
		}
		catch (e) {
			// if exception occured assign emptyText to the element;
			ko.bindingHandlers.text.update(element, function () { return emptyText; });
		}
	}
};
