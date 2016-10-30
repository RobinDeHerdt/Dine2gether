d2gApp.controller("createBookingController", function (interestService) {
	var vm = this;
	var interestSvc = interestService;
	var dishes_arr = [];

	vm.numberOfPages = 4;
	vm.currentPage = 1;

	// dish_img zou eigenlijk dish_images moeten worden en een array zijn. 
	vm.addDish = function (dish_name, dish_descr, dish_img) {
		dishes_arr.push({name: dish_name, description: dish_descr, img: dish_img});
	}

	function loadInterests () {
		interestSvc.getInterests().success(function (data) {
			vm.interests = data.interests;
			console.log(vm.interests);
		})
	}

	function getSelectedInterests () {
		var arr_interests = [];
		angular.forEach(vm.interests, function (interest) {
			if(interest.selected) {
				arr_interests.push(interest.interest);
			}
		})
		return arr_interests;
	}

	function _init () {
		loadInterests();
	}

	_init();
});