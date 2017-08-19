d2gApp.controller("createBookingController", function (kitchenstyleService, bookingService, authService, $state, $scope, $timeout, Upload) {
    var vm = this;

    var bookingSvc = bookingService;
    var authSvc = authService;
    var kitchenstyleSvc = kitchenstyleService;

    if (!authSvc.getUser()) {
        authSvc.showLoginModal();
        $state.go('home');

        return;
    }

    vm.currentPage = 1;

    vm.dishes = [{}];
    vm.dates = [{}];

    function _init() {
        loadKitchenstyles();
    }

    vm.addTemplateDate = function () {
        vm.dates.push({});
        $timeout(function () {
            vm.initDatePickers();
        }, 50);
    };

    vm.initDatePickers = function () {
        $('.datepicker').pickadate({
            selectMonths: true,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true,
            format: 'dd-mm-yyyy'
        });

        $('.timepicker').pickatime({
            default: 'now',
            fromnow: 0,
            twelvehour: false,
            donetext: 'OK',
            cleartext: 'Clear',
            canceltext: 'Cancel',
            autoclose: false,
            ampmclickable: true
        });
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
            kitchenstyles: getSelectedKitchenstyles(),
            dishes: getDishes(),
            dates: getBookingDates()
        };

        bookingSvc.createBooking(data).then(function (data) {
            if (data.data.status === 'success') {
                $state.go('overview');
            }
        }, function (error) {
            var html = "";

            for (var field in error.data) {
                html += "<ul>";

                for (var i = 0; i < error.data[field].length; i++) {
                    html += "<li>" + error.data[field][i] + "</li>"
                }

                html += "</ul>";
            }

            swal({
                html: html,
                type: "error"
            });

            vm.currentPage = 1;
        });
    };

    vm.createImageFile = function (files, errFiles, dish_nr) {
        var arr_nr = dish_nr - 1;

        if (files && files.length) {
            Upload.upload({
                url: CONSTANTS.API_BASE_URL + '/upload',
                data: {
                    files: files
                }
            }).then(function (response) {
                var response_arr = response.data.paths;
                var imgs_arr = [];
                var arr_nr = vm.dishes.length - 1;

                if (response_arr.length > 0) {
                    for (var i = 0; i < response_arr.length; i++) {
                        imgs_arr.push(response_arr[i]);
                    }
                }

                vm.dishes[arr_nr].img = imgs_arr;
            }, function (error) {
                console.log(error);
            });
        }
    };

    function loadKitchenstyles() {
        kitchenstyleSvc.getKitchenStyles().success(function (data) {
            vm.kitchenstyles = data.kitchenstyles;
        });
    }

    function getSelectedKitchenstyles() {
        var selected_kitchenstyles = [];

        angular.forEach(vm.kitchenstyles, function (kitchenstyle) {
            if (kitchenstyle.selected) {
                selected_kitchenstyles.push(kitchenstyle.id);
            }
        });

        return selected_kitchenstyles;
    }

    function getBookingDates() {
        var arr_dates = [];

        angular.forEach(vm.dates, function (date) {
            arr_dates.push({
                date: date.bookingdate,
                time: date.time,
                max_guests: date.max_guests
            });
        });

        return arr_dates;
    }

    function getDishes() {
        var arr_dishes = [];

        angular.forEach(vm.dishes, function (dish) {
            arr_dishes.push({
                dish_name: dish.dish_name,
                description: dish.descr,
                dish_img: dish.img
            });
        });

        return arr_dishes;
    }

    vm.getAddress = function () {
        if (vm.selectedAddress) {
            var user = authSvc.getUser();
            vm.address = user.street_number;
            vm.postal_code = user.postalcode;
            vm.city = user.city;
        } else {
            vm.address = '';
            vm.postal_code = '';
            vm.city = '';
        }
    };

    _init();
});