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
		var markers = {};
		
		/**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        var getMarkerUniqueId= function(lat, lng) {
            return lat + '_' + lng;
        };
		
	  

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
	        anchorPoint: new google.maps.Point(0, -29),
			draggable:true
	     });
		 
		marker.addListener('click', markerClicked);
		 
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
        
		
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
          
          var newPoint = {lat:place.geometry.location.lat() , lng:place.geometry.location.lng()};	  
          obj.currentSelection.init(newPoint);
          obj.addressString(document.getElementById('autocomplete').value);
          
          $('#victaMaps').loadmask($_pageData.loadingMessage); 		  
		  $('#victaMaps').unloadmask();
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
	 //self.pointData = ko.observable({});	
	 self.lng = ko.observable(0.0);	
	 self.lat = ko.observable(0.0);	
	 
	 self.worktype = ko.observable("");	
	 self.budget = ko.observable();	
	 self.description = ko.observable("Some kind of text");	
	 self.division = ko.observable(0);	
	 self.councillor = ko.observable(0);
	 
	 self.division.subscribe(function(divisionId) {		
		 self.councillor(divisionId);
	 });

	 
 }
 
currentPoint.prototype.init = function(data){
		var self = this;		
		self.lng(data.lng);
		self.lat(data.lat)
		self.selected = true;
}
 
 
 function pageModel(){
		
	var self = this;
	self.allItems = ko.observableArray([]);
	self.currentSelection = new currentPoint({});
	
	self.currentSelectionId = ko.observable();	
	
	self.addressString = ko.observable("Brendale Business Park, South Pine Road, Brendale QLD, Australia");	
	
	self.totalRecords = ko.computed(function(){
		return self.allItems().length;
	});
	
	self.reset = function(){		
		return self.allItems.removeAll();	
	}
	
	
	self.worktypes = ko.observableArray([
	       { id: 0, name: '-- Select Worktype --' },{ id: 1, name: 'Division 1' }, { id: 2, name: 'Division 2' }, 
 	 ]);
	
	
	self.divisions = ko.observableArray([
	    { id: 0, name: '-- Select Division --' },{ id: 1, name: 'Division 1' }, { id: 2, name: 'Division 2' },
	    { id: 3, name: 'Division 3' },{ id: 4, name: 'Division 4' }, { id: 5, name: 'Division 5' },
	    { id: 6, name: 'Division 6' },{ id: 7, name: 'Division 7' }, { id: 8, name: 'Division 8' },
	    { id: 9, name: 'Division 9' },{ id: 10, name: 'Division 10' }, { id: 11, name: 'Division 11' }, { id: 12, name: 'Division 12' }
	 ]);
	
	self.councillors = ko.observableArray(		
	[{ id: 0, name: '-- Select Councillors --' },{ id: 1, name: 'Councillor Brooke Savige' }, { id: 2, name: 'Peter Flannery' }, 
	 { id: 3, name: 'Councillor Adam Hain' }, { id: 4, name: 'Councillor Julie Greer' },
	 { id: 5, name: 'James Houghton' }, { id: 6, name: 'Councillor Koliana Winchester' },
	 { id: 7, name: 'Divisional Councillor Denise Sims' }, { id: 8, name: 'Councillor Mick Gillam' },
	 { id: 9, name: 'Deputy Mayor and Divisional Councillor Mike Charlton' }, { id: 10, name: 'Councillor Matt Constance' },
	 { id: 11, name: 'Councillor Darren Grimwade' }, { id: 12, name: 'Councillor Adrian Raedel' },
	 ]);
	
	
	
	self.saveData = function(budgetData){
		
		console.log(obj.addressString());
		//console.log(ko.unwrap(rootObject));
		console.log(ko.toJSON(budgetData));
	}
}

 var obj = new pageModel();

 function markerClicked(){		  
	  var tmpPos = marker.getPosition();
	  var newPoint = {lat:tmpPos.lat() , lng:tmpPos.lng()};
	  
	  obj.currentSelection.init(newPoint);
	 
	  
  }
 
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
