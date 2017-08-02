d2gApp.config(function ($stateProvider, $urlRouterProvider, $authProvider) {
 
 $authProvider.loginUrl = CONSTANTS.API_BASE_URL + '/authenticate/login';
 $authProvider.signupUrl = CONSTANTS.API_BASE_URL + '/authenticate/register';

 $urlRouterProvider.otherwise("/home");

  $stateProvider
	.state("home", {
	  url: "/home",
	  templateUrl: "app/pages/home.html",
	  controller: "homeController as home"
	})
	.state("activate-user", {
		url:"/activation/:token",
		templateUrl: "app/pages/activation.html",
	  	controller: "activationController as controller"
	})
	.state("overviewsearch", {
		url: "/overview/:search",
		templateUrl: "app/pages/overview.html",
		controller: "overviewController as overview"
	})
	.state("overview", {
		url: "/overview",
		templateUrl: "app/pages/overview.html",
		controller: "overviewController as overview"
	})
	.state("bookingdetails", {
		url: "/booking/:id/details",
		templateUrl: "app/pages/bookingDetails.html",
		controller: "bookingDetailsController as bookingdetails"
	})
	.state("requestbooking", {
		url: "/booking/:id/request",
		templateUrl: "app/pages/requestbooking.html",
		controller: "requestBookingController as request"
	})
	.state("booknow", {
		url: "/booknow/:id",
		templateUrl: "app/pages/confirmbooking.html",
		controller: "ConfirmBookingController as confirmbooking"
	})
	.state("createbooking", {
		url: "/booking/create",
		templateUrl: "app/pages/createbooking.html",
		controller: "createBookingController as create"
	})
	.state("profile", {
		url: "/profile",
		templateUrl: "app/pages/profile.html",
		controller: "profileController as profile"
	})
	.state("createreview", {
		url: "/review/create",
		templateUrl: "app/pages/createreview.html",
		controller: "reviewController as review"
	})
	.state("reviews", {
		url: "/user/:id/reviews",
		templateUrl: "app/pages/showreviews.html",
		controller: "reviewController as review"
	})
	.state("dashboard", {
		url: "/dashboard",
		templateUrl: "app/pages/dashboard.html",
		controller: "profileController as profile"
	})
});