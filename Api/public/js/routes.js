d2gApp.config(function ($stateProvider, $urlRouterProvider) {
 
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
});