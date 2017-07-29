d2gApp.controller("reviewController", function (reviewService, loginService, $stateParams, $location, $anchorScroll) {
	vm = this;
	var reviewSvc = reviewService;
	var loginSvc  = loginService;
	vm.selectedname = "...";

	function getGuestsInfo() {
		var user = loginSvc.getUser();
		vm.user = user;
		reviewSvc.getGuests(user.id).then(function(data)
		{
			vm.guestbookings = data.data.bookings;
			console.log(data.data.bookings);
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
			getUserById($stateParams.id);
			vm.reviews  	= data.data.reviews;
			console.log(data);
		});
	}

	function getUserById(id) {
		var token = loginSvc.token;

		reviewSvc.getUserInfo(id, token).then(function(data)
		{
			vm.name = data.data.first_name + " " + data.data.last_name;
		});
	}

	vm.getSelectedUser = function(id, first_name, last_name)
	{
		vm.selectedUser = id;
		vm.selectedname = first_name + " " + last_name;

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
				$location.path('/user/'+ vm.selectedUser+'/reviews');
			}
		}, function (error) {
			vm.sendreviewerror = error.data.review[0];
			console.log(error);
		});
	}

    vm.bookingImage = function(user) {
		return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
    }

    vm.userImage = function(user) {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + user.image;
    }

	vm.deleteReview = function(id)
	{
		reviewSvc.deleteReviews(id).then(function(data)
		{
			if(data.status == 200)
			{
				loadReviews();
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