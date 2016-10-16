var app = angular.module('dine2gether-app', [ 'ngRoute' ]);

app.config(function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl : 'templates/home.html',
                controller  : 'homeController'
            })
});