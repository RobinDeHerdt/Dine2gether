d2gApp.controller("createBookingController", function (kitchenstyleService, interestService, bookingService, loginService, $location, $scope, Upload) {
	var vm = this;

	var interestSvc 	= interestService;
	var bookingSvc 		= bookingService;	
	var loginSvc 		= loginService;
	var kitchenstyleSvc = kitchenstyleService;

	vm.numberOfPages = 5;
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
		console.log(user.id);
		var data = {
			user_id: user.id,
			menu_title: vm.menu_title,
			date: vm.date,
			price: vm.price,
			address: vm.address,
			postal_code: vm.postal_code,
			city: vm.city,
			interests:  getSelectedInterests(),
			kitchenstyles:  getSelectedKitchenstyles(),
			max_nr_guests: vm.max_nr_guests,
			dishes: getDishes(),
		};
		console.log(data);
		bookingSvc.createBooking(data).then(function (data) {
			if(data.data.status == 'success')
			{
				$location.path('/overview');
			}
			}, function (error) {
				console.log(error);
				vm.errors = error.data;
				console.log(error.data);
			});
	} 

	vm.createImageFile = function (files, errFiles, dish_nr) {
		console.log(files)
		var arr_nr = dish_nr - 1;
		if(files && files.length) {
			Upload.upload({
				url: '/api/upload',
				data: {
					files:files
					}
				}).then(function (response) {
					console.log(response);
					var response_arr = response.data.filenaam;
					var imgs_arr = [];
					var arr_nr = vm.dishes.length - 1;
					for(var i=0; i<response_arr.length; i++) {
						imgs_arr.push(response_arr[i]);
					}
					console.log(imgs_arr);

					vm.dishes[arr_nr].img = imgs_arr;
					console.log(vm.dishes[arr_nr]);
				}, function (error) {
					if(error.status > 0) {
						console.log(error);
					}
				});
			
			console.log(vm.dishes);
		} 
	}

	function loadInterests () {
		interestSvc.getInterests().success(function (data) {
			vm.interests = data.interests;
			console.log(vm.interests);
		})
	}

	function loadKitchenstyles () {
		kitchenstyleSvc.getKitchenStyles().success(function (data) {
			vm.kitchenstyles = data.kitchenstyles;
			console.log(vm.kitchenstyles);
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

	function getSelectedKitchenstyles () {
		var arr_kitchenstyles = [];
		angular.forEach(vm.kitchenstyles, function (kitchenstyle) {
			if(kitchenstyle.selected) {
				arr_kitchenstyles.push(kitchenstyle.style);
			}
		})
		return arr_kitchenstyles;
	}

	function getDishes () {
		var arr_dishes = [];
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
			loadKitchenstyles();
		}
		
	}

	_init();
});