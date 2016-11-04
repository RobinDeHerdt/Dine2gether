d2gApp.controller("homeController", function ($location) {

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

	vm.checkIfInputLocation = function () {
		if($("#autocomplete").val().trim() != "") {
			$location.path('/overview/'+$("#autocomplete").val());
		} else {
			$location.path('/overview');
		}
	}

	autoComplete();
	_init();


});