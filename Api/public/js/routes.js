d2gApp.config(function ($stateProvider, $urlRouterProvider, $authProvider) {
 
 $authProvider.loginUrl = '/api/authenticate';

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
	// .state("createbooking", {
	// 	url: "/createbooking",
	// 	templateUrl: "pages/createbooking.html",
	// 	controller: "bookingController as booking"
	// })
});