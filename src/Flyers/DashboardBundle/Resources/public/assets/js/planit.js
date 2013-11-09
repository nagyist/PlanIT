(function () {
    "use strict";

    var prefix = '/planit/bundles/dashboard';

    // Declare app level module which depends on filters, and services
    angular.module('PlanIT', ['PlanIT.filters', 'PlanIT.services', 'PlanIT.directives', 'PlanIT.controllers'])
      .config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
        
        $routeProvider.when('/', {templateUrl: prefix+'/assets/js/templates/index.html', controller: 'HomeCtrl'});
        $routeProvider.when('/project', {templateUrl: prefix+'/assets/js/templates/projects.html', controller: 'ProjectsCtrl'});
        $routeProvider.when('/project/:projectId', {templateUrl: prefix+'/assets/js/templates/project.html', controller: 'ProjectCtrl'});
        $routeProvider.otherwise({redirectTo: '/'});
        
      }]);

}())