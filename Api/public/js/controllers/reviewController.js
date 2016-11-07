d2gApp.controller("reviewController", function (reviewService, loginService, $stateParams, $location, $anchorScroll) {
	vm = this;
	var reviewSvc = reviewService;
	var loginSvc  = loginService;
	vm.name = "...";

	function getGuestsInfo() {
		var user = loginSvc.getUser();
		reviewSvc.getGuests(user.id).then(function(data)
		{
			vm.guestbookings = data.data.bookings;
			console.log(data);
		});
	}

	function getHostsInfo() {
		var user = loginSvc.getUser();
		reviewSvc.getHosts(user.id).then(function(data)
		{
			vm.hostbookings = data.data.bookings;
			console.log(data);
		});
	}

	function loadReviews() {
		reviewSvc.getReviewsByUser($stateParams.id).then(function(data) {
			var user = loginSvc.getUser();
			vm.userid = user['id'];
			vm.reviews  	= data.data.reviews;
			console.log(data);
		});
	}

	vm.getSelectedUser = function(id, first_name, last_name)
	{
		vm.selectedUser = id;
		vm.name = first_name + " " + last_name;

		// Scroll down
		$location.hash('reviewtextarea');
      	$anchorScroll();
	}

	vm.sendReview = function()
	{
		var author = loginSvc.getUser();
		var review = { 
			review 		: vm.reviewinput,
			author 		: author,
			guest_id 	: vm.selectedUser,
		};

		reviewSvc.postReview(review).then(function(data)
		{
			if(data.status == 200)
			{
				$location.path('/user/'+vm.selectedUser+'/reviews');
			}
		});
	}

	vm.deleteReview = function()
	{
		var author = loginSvc.getUser();
		var review = { 
			review 		: vm.reviewinput,
			author 		: author,
			guest_id 	: vm.selectedUser,
		};

		reviewSvc.postReview(review).then(function(data)
		{
			if(data.status == 200)
			{
				$location.path('/user/'+vm.selectedUser+'/reviews');
			}
		});
	}

	vm.goBack = function() {
		window.history.back();
	}

	function _init() {
		getGuestsInfo();
		getHostsInfo();
		loadReviews();
	}

	_init();
});