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
    	return $http.post('api/createbooking', data);
    }

});