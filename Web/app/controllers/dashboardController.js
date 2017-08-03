d2gApp.controller("dashboardController", function (authService, bookingService, requestService, $http, $location) {
    var vm = this;

    var authSvc = authService;
    var bookingSvc = bookingService;
    var requestSvc = requestService;

    function _init() {
        if(!authSvc.getUser()) {
            authSvc.showLoginModal();
            $location.path('/home');

            return;
        }

        getHostBookings();
        getGuestBookings();
    }

    function getHostBookings() {
        bookingSvc.getHostBookings().then(function (data) {
            vm.hostbookings = data.data.bookings;
        });
    }

    function getGuestBookings() {
        bookingSvc.getGuestBookings().then(function (data) {
            vm.guestbookingdates = data.data.bookingdates;
            vm.guestrequests = data.data.requests;
        });
    }

    vm.convertToDate = function (dateString) {
        return new Date(dateString);
    };

    vm.handleRequest = function (bookingdate_id, guest_id, guest_fn, guest_ln, status) {
        var data = {
            guest_id: guest_id,
            status: status
        };

        var swal_text = "";

        if (status) {
            swal_text = "accept " + guest_fn + " " + guest_ln;
        } else {
            swal_text = "decline " + guest_fn + " " + guest_ln;
        }

        swal({
            title: 'Confirm',
            text: "Are you sure you want to " + swal_text + "?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function () {
            requestSvc.handleRequest(bookingdate_id, data).then(function () {
                getHostBookings();
            }, function () {
                swal({
                    text: "We're sorry, we couldn't handle this request. Please try again or contact us if this problem keeps occuring.",
                    type: "error"
                });
            });
        });
    };

    vm.deleteBooking = function (id) {
        swal({
            title: 'Are you sure you want to delete this?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            bookingSvc.deleteBooking(id).then(function () {
                swal(
                    'Deleted!',
                    'Your booking has been deleted.',
                    'success'
                );
                getHostBookings();
            });
        });
    };

    vm.cancelRequest = function (id) {
        swal({
            title: 'Confirm cancellation?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then(function () {
            requestSvc.cancelRequest(id).then(function () {
                swal(
                    'Cancelled',
                    'Your request was cancelled.',
                    'success'
                );
                getGuestBookings();
            });
        });
    };

    vm.cancelSeat = function (bookingdate_id) {
        swal({
            title: 'Are you sure you want to cancel?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then(function () {
            bookingSvc.cancelSeat(bookingdate_id).then(function () {
                swal(
                    'Cancelled',
                    'You have cancelled this booking.',
                    'success'
                );
                getGuestBookings();
            });
        });
    };

    _init();
});