d2gApp.service('bookingService', function($http) {

	var svc = this;

	svc.getBookings = function () {
		return $http.get(CONSTANTS.API_BASE_URL + '/bookings');
    };

    svc.getBookingsByLocation = function (location) {
        return $http.get(CONSTANTS.PUBLIC_BASE_URL + '/search?location=' + location);
    };
    
    svc.getBookingById = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL +  '/booking/' + id);
    };

    svc.createBooking = function (data) {
    	return $http.post(CONSTANTS.API_BASE_URL + '/bookings', data);
    };
    
    svc.deleteBooking = function (id) {
        return $http.delete(CONSTANTS.API_BASE_URL + '/bookings/' + id);
    };

    svc.getHostBookings = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL + '/hostbookings');
    };

    svc.getGuestBookings = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL + '/guestbookings');
    };

    svc.cancelSeat = function (id) {
        return $http.post(CONSTANTS.API_BASE_URL + '/bookingdate/' + id + '/cancel');
    };

    svc.getBookingdateByDate = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/getbookingdatebydate', data);
    };

    svc.createBookingdate = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/bookingdate/create', data);
    };

    svc.deleteBookingdate = function (id) {
        return $http.post(CONSTANTS.API_BASE_URL + '/bookingdate/' + id + '/delete');
    };

    svc.addUserToBookingdate = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/addtobookingdate', data);
    };

    svc.getUserBookingsAndReviews = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL + '/user/' + id);
    };
});