  // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete,mapDetails;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
	  
	    var mapProp = {
			center: {lat:51.508742,lng:-0.120850},
			zoom:5			
		};
	    
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
            {types: ['geocode']});

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
         
          
          $.getJSON('/repairers/?lat='+place.geometry.location.lat()+'&lng='+place.geometry.location.lng(), function(records){
        	         	 
        	  if(records.success){        		  
        		  obj.reset();
  			      var  tmpObjectList = obj.allItems();			   
  			      tmpObjectList =  wrapFunction(records.rs,tmpObjectList,normalFunction);
  			      obj.allItems(tmpObjectList);  			    
        	  }
          });
		
		/*

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }*/
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
	  
 $(document).ready(function(){
	 // jQuery methods go here... 
	

});	  
 
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
 function pageModel(){
		
		var self = this;
		self.allItems = ko.observableArray([]);	
		
		self.totalRecords = ko.computed(function(){
			return self.allItems().length;
		});
		
		self.reset = function(){		
			return self.allItems.removeAll();	
		}	

}
 var obj = new pageModel();
 ko.applyBindings(obj);