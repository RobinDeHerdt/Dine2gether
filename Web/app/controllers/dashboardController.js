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

    vm.deleteBookingdate = function (id) {
        swal({
            title: 'Remove date',
            text: "Are you sure you want to delete this date? Your guests will be notified if you do.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function () {
            bookingSvc.deleteBookingdate(id).then(function () {
                swal({
                    title: 'Deleted',
                    text: 'This date has been deleted',
                    type: 'success'
                });
                getHostBookings();
            });
        });
    };

    vm.createBookingdate = function (id) {
        var data = {
            date: vm.createbookingdate,
            time: vm.createbookingtime,
            max_guests: vm.createbookingmax,
            booking_id: id
        };

        bookingSvc.createBookingdate(data).then(function() {
            swal({
                title: 'Success',
                text: 'Date created',
                type: 'success'
            });

            vm.showCreateBookingdateForm = false;
            getHostBookings();
        }, function (error) {

            swal({
                title: 'Error',
                text: 'Something was not quite right. Check the form again.' ,
                type: 'error'
            });
        });
    };

    vm.handleRequest = function (bookingdate_id, guest_id, guest_fn, guest_ln, status) {
        swal({
            title: (status) ? 'Accept' : 'Decline',
            input: 'textarea',
            text: "Have a message for " + guest_fn + " " + guest_ln + "?",
            inputPlaceholder: "Optional message",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function (input) {
            var data = {
                guest_id: guest_id,
                status: status,
                message: input
            };

            requestSvc.handleRequest(bookingdate_id, data).then(function () {
                swal({
                    title: 'Success',
                    text: (status) ? 'Guest accepted' : 'Guest declined',
                    type: 'success'
                });
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
            title: 'Remove booking',
            text: "Are you sure you want to delete your booking? Your guests will be notified if you do.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function () {
            bookingSvc.deleteBooking(id).then(function () {
                swal({
                    title: 'Deleted',
                    text: 'Your booking has been deleted',
                    type: 'success'
                });
                getHostBookings();
            });
        });
    };

    vm.cancelRequest = function (id) {
        swal({
            title: 'Confirm cancellation',
            text: "Are you sure you want to cancel your request?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function () {
            requestSvc.cancelRequest(id).then(function () {
                swal({
                    title: 'Cancelled',
                    text: 'Your request was cancelled',
                    type: 'success'
                });
                getGuestBookings();
            });
        });
    };

    vm.cancelSeat = function (bookingdate_id) {
        swal({
            title: 'Are you sure you want to cancel?',
            text: "The host will be notified",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function () {
            bookingSvc.cancelSeat(bookingdate_id).then(function () {
                swal({
                    title: 'Cancelled',
                    text: 'You have cancelled this booking',
                    type: 'success'
                });
                getGuestBookings();
            });
        });
    };

    _init();
});