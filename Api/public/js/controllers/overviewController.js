d2gApp.controller("overviewController", function (bookingService, interestService, $scope) {

	var vm = this;
	var bookingSvc = bookingService;
	var interestSvc = interestService;

	vm.bookings = {};

	vm.convertToDate = function (dateString) {
		var convertedString = new Date(dateString);
		return convertedString;
	}

	vm.showFilteredBookings = function () {
		var interests = getInterestsFilter();
		//var kitchen = getKitchenFilter();
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