d2gApp.service('bookingService', function($http) {

	var svc = this;

	svc.getBookings = function () {
		return $http.get('/api/bookings');
    	}

    svc.getBookingsByLocation = function (location) {
        var url = '/search?location='+location;
        return $http.get(url);
    }
    
    svc.getBookingById = function (id) {
        return $http.get('api/bookingdetails/' + id);
    }

    svc.createBooking = function (data) {
        console.log(data);
    	return $http.post('api/bookings', data);
    }

    svc.deleteBooking = function (id) {
        return $http.delete('api/bookings/' + id);
    }

    svc.getBookingsByUserId = function (id) {
        return $http.get('api/userbookings/' + id);
    }

    svc.getGuestBookingsById = function (id) {
        return $http.get('api/guestbookings/' +id);
    }  

    svc.detachBooking = function (id, userid) {
        return $http.delete('api/bookings/detach/' + id + '/user/' + userid);
    }

});