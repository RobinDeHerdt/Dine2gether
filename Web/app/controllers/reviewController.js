d2gApp.controller("reviewController", function (reviewService, authService, $stateParams, $location, $anchorScroll) {
	vm = this;
	var reviewSvc = reviewService;
	var authSvc  = authService;
	vm.selectedname = "...";

	function getGuests() {
        vm.auth_user = authSvc.getUser();

		reviewSvc.getGuests().then(function(data) {
			vm.guestbookings = data.data.bookings;
		});
	}

	function getHosts() {
		reviewSvc.getHosts().then(function(data) {
			vm.hostbookings = data.data.bookings;
		});
	}

	function loadReviews() {
		reviewSvc.getReviewsByUser($stateParams.id).then(function(data) {
			vm.reviews = data.data.reviews;
			vm.user = data.data.user;
			console.log(vm.user);
		});
	}

	vm.getSelectedUser = function(id, first_name, last_name) {
		vm.selectedUser = id;
		vm.selectedname = first_name + " " + last_name;

		$location.hash('reviewtextarea');
      	$anchorScroll();
	};

	vm.sendReview = function() {
		var author = authSvc.getUser();
		var review = { 
			review 		: vm.reviewinput,
			author 		: author,
			guest_id 	: vm.selectedUser
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
		loadReviews();
	}

	_init();
});