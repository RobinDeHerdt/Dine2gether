d2gApp.config(function ($stateProvider, $urlRouterProvider, $authProvider) {
 
 $authProvider.loginUrl = '/api/authenticate/login';

  $urlRouterProvider.otherwise("/home");

  $stateProvider
	.state("home", {
	  url: "/home",
	  templateUrl: "pages/home.html",
	  controller: "homeController as home"
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
	// .state("createbooking", {
	// 	url: "/createbooking",
	// 	templateUrl: "pages/createbooking.html",
	// 	controller: "bookingController as booking"
	// })
});