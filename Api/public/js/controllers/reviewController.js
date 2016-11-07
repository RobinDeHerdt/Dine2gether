d2gApp.controller("reviewController", function (reviewService, loginService, $stateParams) {
	vm = this;
	var reviewSvc = reviewService;
	var loginSvc  = loginService;

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
			vm.reviews  	= data.data.user.receiverreviews;
			vm.receiver 	= data.data.user;
			console.log(data);
		});
	}

	vm.getSelectedUser = function(id)
	{
		vm.selectedUser = id;
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
			console.log(data);
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