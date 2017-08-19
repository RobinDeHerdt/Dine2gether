d2gApp.controller("publicProfileController", function (bookingService, $stateParams, $filter) {

    var vm = this;
    var bookingSvc = bookingService;

    vm.user = vm.bookings = vm.reviews = {};

    vm.user = bookingSvc.getUserBookingsAndReviews($stateParams.id).then(function (data) {
        vm.user = data.data.user;
        vm.bookings = data.data.bookings;
        vm.reviews = data.data.latest_reviews;

        vm.userImage = function (user) {
            return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
        };

        vm.bookingImage = function (booking) {
            return CONSTANTS.PUBLIC_BASE_URL + "/" + booking.dishes[0].dishimages[0].image_uri;
        };

    }, function (error) {
        console.log("Error occured")
    });

    vm.toDate = function (datestring) {
        var date = $filter('date')(new Date(datestring), 'MMM d yyyy');
        return date;
    };
});