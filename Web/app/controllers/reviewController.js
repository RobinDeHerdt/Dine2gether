d2gApp.controller("reviewController", function (reviewService, authService, $stateParams, $location, $state) {
	vm = this;

	var reviewSvc = reviewService;
	var authSvc = authService;

	vm.authenticated_user = authSvc.getUser();

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

	vm.reviewUser = function(user_id, booking_id, user_fn, user_ln, booking_title) {
		swal({
            title: 'Review',
            text: 'Write your review for ' + user_fn + ' ' + user_ln + ' regarding "' + booking_title + '"',
			input: 'textarea',
            width: 750,
            padding: 50,
			inputPlaceholder: 'Write review',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Save'
        }).then(function (review) {
            var data = {
                user: user_id,
                booking: booking_id,
				review: review
            };

            reviewSvc.createReview(data).then(function() {
                swal({
                    title: 'Success!',
                    text: 'Your review was posted.',
                    type: 'success'
                }).then(function() {
                    $state.go('reviews', {id:user_id});
				});
            }, function (error) {
				console.log(error);
            });
        });
	};

    vm.bookingImage = function(user) {
		return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
    };

    vm.userImage = function(user) {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
    };

	vm.deleteReview = function(id) {
        swal({
            title: 'Are you sure you want to remove your review?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm delete'
        }).then(function () {
			reviewSvc.deleteReviews(id).then(function() {
                swal(
                    'Deleted!',
                    'Your comment has been deleted.',
                    'success'
                );
				loadReviews();
			});
        });
	};

	vm.goBack = function() {
		window.history.back();
	};

	function _init() {
		switch($location.url().split("#")[0]) {
			case "/review/create":
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