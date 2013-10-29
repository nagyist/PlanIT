(function () {
    "use strict";


    // Declare app level module which depends on filters, and services
    angular.module('PlanIT', ['PlanIT.filters', 'PlanIT.services', 'PlanIT.directives', 'PlanIT.controllers'])
      /*.config(['$routeProvider', function($routeProvider) {
        
        $routeProvider.when('/', {templateUrl: '/index', controller: 'HomeCtrl'});
        $routeProvider.when('/project', {templateUrl: '/project', controller: 'ProjectCtrl'});
        $routeProvider.when('/blog', {templateUrl: '/blog', controller: 'BlogCtrl'});
        $routeProvider.when('/blog/:year/:month/:day/:post', {templateUrl: '/blog/post.html', controller: 'PostCtrl'});
        $routeProvider.otherwise({redirectTo: '/'});
        
      }]);*/

}())