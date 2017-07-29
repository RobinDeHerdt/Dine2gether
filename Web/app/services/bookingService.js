d2gApp.service('bookingService', function($http) {

	var svc = this;

	svc.getBookings = function () {
		return $http.get(CONSTANTS.API_BASE_URL + '/bookings');
    	}

    svc.getBookingsByLocation = function (location) {
        var url = '/search?location='+location;
        return $http.get(url);
    }
    
    svc.getBookingById = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL +  '/bookingdetails/' + id);
    }

    svc.createBooking = function (data) {
    	return $http.post(CONSTANTS.API_BASE_URL + '/bookings', data);
    }
    
    svc.deleteBooking = function (id) {
        return $http.delete(CONSTANTS.API_BASE_URL + '/bookings/' + id);
    }

    svc.getBookingsByUserId = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL + '/userbookings/' + id);
    }

    svc.getGuestBookingsById = function (id) {
        return $http.get(CONSTANTS.API_BASE_URL + '/guestbookings/' +id);
    }  

    svc.detachBooking = function (id, userid) {
        return $http.delete(CONSTANTS.API_BASE_URL + '/bookings/detach/' + id + '/user/' + userid);
    }

    svc.getBookingdateByDate = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/getbookingdatebydate', data);
    }

    svc.createNewBookingdate = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/createbookingdate', data);
    }

    svc.addUserToBookingdate = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/addtobookingdate', data);
    }

});