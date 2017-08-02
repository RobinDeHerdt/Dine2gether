d2gApp.controller("createBookingController", function (kitchenstyleService, bookingService, authService, $location, $scope, Upload) {
	var vm = this;

	var bookingSvc 		= bookingService;	
	var authSvc 		= authService;
	var kitchenstyleSvc = kitchenstyleService;

    if(!authSvc.getUser()) {
        authSvc.showLoginModal();
        $location.path('/home');

        return;
    }

	vm.numberOfPages = 6;
	vm.currentPage = 1;

	vm.dishes = [{}];
    vm.dates = [{}];

    vm.addTemplateDate = function () {
        vm.dates.push({});
    };

	vm.addTemplateDish = function () {
        vm.dishes.push({});
	};

	vm.deleteDish = function (index) {
        vm.dishes.splice(index, 1);
	};

    vm.deleteDate = function (index) {
        vm.dates.splice(index, 1);
    };

	vm.createBooking = function () {
		var user = authSvc.getUser();

		var data = {
			user_id: user.id,
			menu_title: vm.menu_title,
			price: vm.price,
			address: vm.address,
			postal_code: vm.postal_code,
			city: vm.city,
			telephone_number: vm.telephone_number,
			kitchenstyles:  getSelectedKitchenstyles(),
			dishes: getDishes(),
			dates: getBookingDates()
		};

		bookingSvc.createBooking(data).then(function (data) {
			if(data.data.status === 'success') {
				$location.path('/overview');
			}
		}, function (error) {
			console.log(error);
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

	function loadKitchenstyles () {
		kitchenstyleSvc.getKitchenStyles().success(function (data) {
			vm.kitchenstyles = data.kitchenstyles;
		});
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

	function getBookingDates() {
		var arr_dates = [];

        for(var i = 0; i < vm.dates.length; i++) {
            arr_dates.push({
                date: vm.dates[i].bookingdate,
                time: vm.dates[i].time,
                max_guests: vm.dates[i].max_guests
            });
        }

        console.log(arr_dates);

		return arr_dates;
	}

	function getDishes () {
		var arr_dishes = [];

		for(var i = 0; i < vm.dishes.length; i++) {
			arr_dishes.push({
				dish_name: vm.dishes[i].dish_name,
				description: vm.dishes[i].descr,
				dish_img: vm.dishes[i].img
			});
		}

		console.log(arr_dishes);

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
		loadKitchenstyles();
	}

	_init();
});