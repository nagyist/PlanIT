(function () {
    "use strict";

    var prefix = '/planit/bundles/dashboard';

    // Declare app level module which depends on filters, and services
    angular.module('PlanIT', ['PlanIT.filters', 'PlanIT.services', 'PlanIT.directives', 'PlanIT.controllers'])
      .config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
        
        $routeProvider.when('/', {templateUrl: prefix+'/assets/js/templates/index.html', controller: 'HomeCtrl'});

        // Projects
        $routeProvider.when('/projects', {templateUrl: prefix+'/assets/js/templates/projects.html', controller: 'ProjectsCtrl'});
        $routeProvider.when('/project/new', {templateUrl: prefix+'/assets/js/templates/project/new.html', controller: 'ProjectCtrl'});
        $routeProvider.when('/project/add/:projectId', {templateUrl: prefix+'/assets/js/templates/project/addParticipant.html', controller: 'ProjectCtrl'});        
        $routeProvider.when('/project/edit/:projectId', {templateUrl: prefix+'/assets/js/templates/project/edit.html', controller: 'ProjectCtrl'});        
        $routeProvider.when('/project/:projectId', {templateUrl: prefix+'/assets/js/templates/project.html', controller: 'ProjectCtrl'});
        
        // Employees
        $routeProvider.when('/employee/new', {templateUrl: prefix+'/assets/js/templates/employee/new.html', controller: 'EmployeeCtrl'});
        $routeProvider.when('/employee/edit/:employeeId', {templateUrl: prefix+'/assets/js/templates/employee/edit.html', controller: 'EmployeeCtrl'});        
        
        // Tasks
        $routeProvider.when('/tasks/:projectId', {templateUrl: prefix+'/assets/js/templates/tasks.html', controller: 'TasksCtrl'});
        $routeProvider.when('/task/new/:projectId', {templateUrl: prefix+'/assets/js/templates/task/new.html', controller: 'TaskCtrl'});
        $routeProvider.when('/task/edit/:taskId', {templateUrl: prefix+'/assets/js/templates/task/edit.html', controller: 'TaskCtrl'});
        $routeProvider.otherwise({redirectTo: '/'});
        
      }]);

}())
