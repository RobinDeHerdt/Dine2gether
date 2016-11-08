d2gApp.config(function ($stateProvider, $urlRouterProvider, $authProvider) {
 
 $authProvider.loginUrl = '/api/authenticate/login';

 $urlRouterProvider.otherwise("/home");

  $stateProvider
	.state("home", {
	  url: "/home",
	  templateUrl: "pages/home.html",
	  controller: "homeController as home"
	})
	.state("activate-user", {
		url:"/activation/:token",
		templateUrl: "pages/activation.html",
	  	controller: "activationController as controller"
	})
	.state("overviewsearch", {
		url: "/overview/:search",
		templateUrl: "pages/overview.html",
		controller: "overviewController as overview"
	})
	.state("overview", {
		url: "/overview",
		templateUrl: "pages/overview.html",
		controller: "overviewController as overview"
	})
	.state("bookingdetails", {
		url: "/booking/:id/details",
		templateUrl: "pages/bookingDetails.html",
		controller: "bookingDetailsController as bookingdetails"
	})
	.state("requestbooking", {
		url: "/requestbooking/:id",
		templateUrl: "pages/requestbooking.html",
		controller: "requestBookingController as request"
	})
	.state("booknow", {
		url: "/booknow/:id",
		templateUrl: "pages/confirmbooking.html",
		controller: "ConfirmBookingController as confirmbooking"
	})
	.state("create_booking", {
		url: "/create_booking",
		templateUrl: "pages/createbooking.html",
		controller: "createBookingController as create"
	})
	.state("profile", {
		url: "/profile",
		templateUrl: "pages/profile.html",
		controller: "profileController as profile"
	})
	.state("writereview", {
		url: "/writereview",
		templateUrl: "pages/createreview.html",
		controller: "reviewController as review"
	})
	.state("reviews", {
		url: "/user/:id/reviews",
		templateUrl: "pages/showreviews.html",
		controller: "reviewController as review"
	})
	.state("dashboard", {
		url: "/dashboard",
		templateUrl: "pages/dashboard.html",
		controller: "profileController as profile"
	})
});