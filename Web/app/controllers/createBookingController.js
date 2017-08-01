d2gApp.controller("createBookingController", function (kitchenstyleService, interestService, bookingService, authService, $location, $scope, Upload) {
	var vm = this;

	var interestSvc 	= interestService;
	var bookingSvc 		= bookingService;	
	var authSvc 		= authService;
	var kitchenstyleSvc = kitchenstyleService;

	vm.numberOfPages = 5;
	vm.currentPage = 1;
	vm.dishes = [{
		number: 1
	}];

	vm.addTemplateDish = function () {
		console.log(vm.dishes);
		var dish_nr = vm.dishes.length + 1;
		vm.dishes.push({
			number: dish_nr
		});
	};

	vm.deleteLastDish = function () {
		vm.dishes.pop();
	};

	vm.createBooking = function () {
		var user = authSvc.getUser();

		var data = {
			user_id: user.id,
			menu_title: vm.menu_title,
			date: vm.date,
			price: vm.price,
			address: vm.address,
			postal_code: vm.postal_code,
			city: vm.city,
			telephone_number: vm.telephone_number,
			interests:  getSelectedInterests(),
			kitchenstyles:  getSelectedKitchenstyles(),
			dishes: getDishes()
		};
		console.log(data);
		bookingSvc.createBooking(data).then(function (data) {
			if(data.data.status === 'success') {
				$location.path('/overview');
			}
		}, function (error) {
			console.log(error);
			vm.errors = error.data;
		});
	};

	vm.createImageFile = function (files, errFiles, dish_nr) {
		var arr_nr = dish_nr - 1;

		if(files && files.length) {
			Upload.upload({
				url: CONSTANTS.API_BASE_URL + '/upload',
				data: {
					files:files
				}
			}).then(function (response) {
				var response_arr = response.data.paths;
				var imgs_arr = [];
				var arr_nr = vm.dishes.length - 1;

				if(response_arr.length > 0) {
					for(var i = 0; i < response_arr.length; i++) {
						imgs_arr.push(response_arr[i]);
					}
				}

				vm.dishes[arr_nr].img = imgs_arr;
			}, function (error) {
				console.log(error);
			});
		} 
	};

	function loadInterests () {
		interestSvc.getInterests().success(function (data) {
			vm.interests = data.interests;
		});
	}

	function loadKitchenstyles () {
		kitchenstyleSvc.getKitchenStyles().success(function (data) {
			vm.kitchenstyles = data.kitchenstyles;
		});
	}

	function getSelectedInterests () {
		var selected_interests = [];

		angular.forEach(vm.interests, function (interest) {
			if(interest.selected) {
                selected_interests.push(interest.id);
			}
		});

		return selected_interests;
	}

	function getSelectedKitchenstyles () {
		var selected_kitchenstyles = [];

		angular.forEach(vm.kitchenstyles, function (kitchenstyle) {
			if(kitchenstyle.selected) {
                selected_kitchenstyles.push(kitchenstyle.id);
			}
		});

		return selected_kitchenstyles;
	}

	function getDishes () {
		var arr_dishes = [];

		for(var i = 0; i < vm.dishes.length; i++) {

			arr_dishes.push({
				dish_name: vm.dishes[i].dish_name,
				description: vm.dishes[i].descr,
				dish_img: vm.dishes[i].img
			})
		}

		return arr_dishes;
	}

	vm.getAddress = function()	{
		if(vm.selectedAddress) {
			var user = authSvc.getUser();
			vm.address 		= user.street_number;
			vm.postal_code 	= user.postalcode;
			vm.city 		= user.city;
		} else
		{
			vm.address 		= '';
			vm.postal_code 	= '';
			vm.city 		= '';
		}
	};

	function _init () {
		if(!authSvc.getUser()) {
            swal({
            	text: "You need to be logged in to create a booking",
            	type: "error"
            }).then(function () {
                $location.path('/home');
            }, function () {
                $location.path('/home');
            });
		} else {
			loadKitchenstyles();
		}

        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true // Close upon selecting a date
        });
	}

	_init();
});