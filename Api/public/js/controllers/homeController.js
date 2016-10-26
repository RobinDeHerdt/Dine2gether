d2gApp.controller("homeController", function () {

	var vm = this;

	function autoComplete () {
		var input = document.getElementById('autocomplete');
  
  		var autocomplete = new google.maps.places.Autocomplete(input);
	  	autocomplete.addListener('place_changed', function() {
	    	var place = autocomplete.getPlace();
		    if (!place.geometry) {
		      	window.alert("Autocomplete's returned place contains no geometry");
		      	return;
	    	}
		});
	}

	function _init () {
		//console.log("Logging homeController");
	}

	autoComplete();
	_init();


});