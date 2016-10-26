d2gApp.controller("overviewController", function (bookingService, interestService, $scope) {

	var vm = this;
	var bookingSvc = bookingService;
	var interestSvc = interestService;

	vm.bookings = {};

	vm.convertToDate = function (dateString) {
		var convertedString = new Date(dateString);
		return convertedString;
	}

	vm.showFilteredInterests = function () {
		var interestsarray = getInterestsFilter();
		var arr_x = []
			return function (booking) {
				if(interestsarray.length != 0) {
					for(var i in booking.user.interests) {
						for(var x=0; x<interestsarray.length; x++) {
							if(booking.user.interests[i].interest == interestsarray[x]) {
								console.log("true interest");
								return booking.user.interests[i].interest == interestsarray[x];
							}
						}
					} 
				} else {
					return true;
				}
			}
	}
	function loadBookings () {
		bookingSvc.getBookings()
			.success(function(data) {
				//console.log(data.bookings[0].dishes[0].dish_images[0]['image-url'])
				console.log(data);
				vm.bookings = data.bookings;
			});
	}

	function loadInterests () {
		interestSvc.getInterests()
			.success(function (data) {
				console.log(data);
				vm.interests = data.interests;
			});
	}

	function getInterestsFilter () {
		var arr_interests = [];
		angular.forEach(vm.interests, function (interest) {
			if(interest.selected) {
				arr_interests.push(interest.interest);
			}
		})
		return arr_interests;
	}

	function _init () {
		loadBookings();
		loadInterests();
	}
	_init();


});