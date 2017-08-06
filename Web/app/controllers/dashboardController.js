d2gApp.controller("dashboardController", function (authService, bookingService, requestService, $state) {
    var vm = this;

    var authSvc = authService;
    var bookingSvc = bookingService;
    var requestSvc = requestService;

    function _init() {
        if(!authSvc.getUser()) {
            authSvc.showLoginModal();
            $state.go('home');

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

    vm.showBookingdateCreateForm = function(booking_id) {
        $('#modal-create-date-' + booking_id).openModal();
    };

    vm.showBookingdateEditForm = function(bookingdate_id) {
        Materialize.updateTextFields();
        $("#modal-edit-date-" + bookingdate_id).openModal();
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
            getHostBookings();
        }, function () {
            swal({
                title: 'Error',
                text: 'Something was not quite right. Check the form again. Make sure the selected date is in the future.' ,
                type: 'error'
            }).then(function() {
                $('#modal-create-date-' + id).openModal();
            });
        });
    };

    vm.updateBookingdate = function(id) {
        // @todo Temp fix. Clean this up using angular models.
        var data = {
            date: $('#edit-date-' + id).val(),
            time: $('#edit-time-' + id).val(),
            max_guests: $('#edit-max-' + id).val()
        };

        bookingSvc.updateBookingdate(id, data).then(function() {
            swal({
                title: 'Success',
                text: 'Changes were saved!',
                type: 'success'
            });

            getHostBookings();
        }, function(error) {
            swal({
                title: 'Error',
                text: 'Something was not quite right. Check the form again. Make sure the selected date is in the future.' ,
                type: 'error'
            }).then(function() {
                $('#modal-edit-date-' + id).openModal();
            });
        });
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

    vm.handleRequest = function (bookingdate_id, guest_id, guest_fn, guest_ln, host_approved, status) {
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
                if(status && !host_approved) {
                    swal({
                        title: 'success',
                        type: 'success',
                        text: 'Set a max number of guests',
                        input: 'text',
                        inputPlaceholder: 'Max amount of guests'
                    }).then(function(max_guests) {
                        data = {
                            max_guests: max_guests
                        };

                        bookingSvc.updateBookingdate(bookingdate_id, data).then(function() {
                            swal({
                                title: 'Success',
                                text: 'Changes were saved!',
                                type: 'success'
                            });

                            getHostBookings();
                        });
                    });
                } else {
                    swal({
                        title: 'Success',
                        text: (status) ? 'Guest accepted' : 'Guest declined',
                        type: 'success'
                    });
                }


                getHostBookings();
            }, function () {
                swal({
                    text: "We're sorry, we couldn't handle this request. Please try again or contact us if this problem keeps occuring.",
                    type: "error"
                });
            });
        });
    };

    vm.getGuestCount = function(guests) {
        var guestcount = 0;

        angular.forEach(guests, function(guest) {
            if(guest.pivot.status === "accepted") {
                guestcount++;
            }
        });

        return guestcount;
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
            title: 'Confirm cancellation',
            text: "Your host will be notified.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then(function () {
            bookingSvc.cancelSeat(bookingdate_id).then(function () {
                swal({
                    title: 'Cancelled',
                    text: 'Cancellation successful',
                    type: 'success'
                });
                getGuestBookings();
            });
        });
    };

    vm.splitDateTime = function(datetime) {
        var datetimesplit = datetime.split(" ");

        var date = datetimesplit[0];
        var time = datetimesplit[1];

        return {
            date: date,
            time: time
        };
    };

    _init();
});