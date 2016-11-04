d2gApp.controller("createBookingController", function (interestService, bookingService, loginService, $location) {
	var vm = this;
	var interestSvc = interestService;
	var bookingSvc = bookingService;	
	var loginSvc = loginService;

	vm.numberOfPages = 4;
	vm.currentPage = 1;
	vm.dishes = [{
		number: 1,
	}];

	vm.addTemplateDish = function () {
		console.log(vm.dishes);
		var dish_nr = vm.dishes.length + 1;
		vm.dishes.push({
			number: dish_nr,
		});
	}
	vm.deleteLastDish = function () {
		vm.dishes.pop();
	}
	vm.createBooking = function () {
		var user = loginSvc.getUser();
		var data = {
			user_id: user.id,
			menu_title: vm.menu_title,
			date: vm.date,
			price: vm.price,
			address: vm.address,
			postal_code: vm.postal_code,
			city: vm.city,
			interests:  getSelectedInterests(),
			dishes: getDishes()
		};

		bookingSvc.createBooking(data).then(function (data) {
			console.log(data);
		}, function (error) {
			console.log(error);
		});
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

	function getDishes () {
		var arr_dishes = [];
		var arr_dish_img = [];
		for(var x=0; x < vm.dishes.length; x++) {

			arr_dishes.push({
				dish_name: vm.dishes[x].dish_name,
				description: vm.dishes[x].descr,
				dish_img: vm.dishes[x].img
			})
		}

		return arr_dishes;
	}

	function _init () {
		if(!loginSvc.getUser()) {
			loginSvc.errorMessage = "You need to be logged in to create a booking";
			$location.path('/home');
		} else {
			loadInterests();
		}
		
	}

	_init();
});