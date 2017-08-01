d2gApp.controller("reviewController", function (reviewService, authService, $stateParams, $location, $anchorScroll) {
	vm = this;

	var reviewSvc = reviewService;

	vm.selectedname = null;

	function getGuests() {
		reviewSvc.getGuests().then(function(data) {
			vm.guestbookings = data.data.bookings;
		});
	}

	function getHosts() {
		reviewSvc.getHosts().then(function(data) {
			vm.hostbookingdates = data.data.bookings;
		});
	}

	function loadReviews() {
		reviewSvc.getReviewsByUser($stateParams.id).then(function(data) {
			vm.reviews = data.data.reviews;
			vm.user = data.data.user;
		});
	}

	vm.getSelectedUser = function(id, first_name, last_name) {
		vm.selectedUser = id;
		vm.selectedname = first_name + " " + last_name;

        setTimeout(function(){
            $location.hash('reviewtextarea');
            $anchorScroll();
		}, 100);
	};

	vm.sendReview = function() {
		var review = { 
			review : vm.reviewinput,
			user_id : vm.selectedUser
		};

		reviewSvc.postReview(review).then(function(data) {
			if(data.status === 200) {
				$location.path('/user/'+ vm.selectedUser+'/reviews');
			}
		}, function (error) {
			vm.sendreviewerror = error.data.review[0];
			console.log(error);
		});
	};

    vm.bookingImage = function(user) {
		return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
    };

    vm.userImage = function(user) {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
    };

	vm.deleteReview = function(id) {
		reviewSvc.deleteReviews(id).then(function(data) {
			if(data.status === 200) {
				loadReviews();
			}
		});
	};

	vm.goBack = function() {
		window.history.back();
	};

	function _init() {
		switch($location.url().split("#")[0]) {
			case "/writereview":
                getHosts();
                getGuests();
				break;
			default:
                loadReviews();
                break;
		}
	}

	_init();
});