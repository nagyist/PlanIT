(function () {
  "use strict";

  /* Controllers */

  angular.module('PlanIT.controllers', [])
    .controller('HomeCtrl', [function(){

    }])
    .controller('LoginCtrl', ['$scope', '$http', '$location', 'Global', function($scope, $http, $location, Global) {
      $scope.user = {};

      $scope.submit = function() {
        var user = $scope.user;

        $http({method: 'POST', url:Global.prefix+'/user/auth', data:{email:user.login,password:user.password}})
          .success(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            } else {
              Global.user = data.user;
              $location.path('/projects')
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          });
      }
    }])
    .controller('RegisterCtrl', ['$scope', '$http', 'Global', function($scope, $http, Global) {
      $scope.user = {};

      $scope.submit = function() {
        var user = $scope.user;

        $http({method: 'POST', url:Global.prefix+'/user/create', data:{email:user.login,password:user.password,password_confirm:user.password_confirm}})
          .success(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          });

      }

    }])
    .controller('ContactCtrl', [ '$scope', 'Contact', function($scope, Contact) {
      $scope.contact = {};

      $scope.submit = function() {
        var contact = new Contact();
        contact.name = $scope.contact.name;
        contact.mail = $scope.contact.mail;
        contact.subject = $scope.contact.subject;
        contact.message = $scope.contact.message;
        contact.$send();
      }
    }])
    .controller('ProjectsCtrl', [ '$scope', '$http', '$location', 'Global', function($scope, $http, $location, Global){
      $scope.loadProjects = function() {
        $scope.cur_user = Global.user;
        if (typeof $scope.cur_user == "undefined") $location.path('/');
        $http({method:'GET', url:Global.prefix+'/api/projects/'+$scope.cur_user.id})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.projects = data.projects;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

      $scope.openProject = function(id) {
        $location.path('/project/'+id);
      };

      $scope.addParticipant = function(id) {
        $location.path('/project/add/'+id);
      }
    }])
    .controller('ProjectCtrl', ['$scope', '$http', '$location', '$routeParams','Global', function($scope, $http, $location, $routeParams, Global) {

      $scope.loadJob = function() {
        $scope.cur_user = Global.user;
        //if(typeof $scope.cur_user == "undefined") $location.path('/');

        $http({method:'GET', url:Global.prefix+'/api/jobs'})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              console.log(data);
              $scope.jobs = data.jobs;
            }
          })
          .error(function(data,status,headers){

          })
      };

      $scope.loadProject = function() {
        $scope.projectId = $routeParams.projectId;
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');

        $http({method:'GET', url:Global.prefix+'/api/project/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.project = data.project;
            }
          })
          .error(function(data,status,headers){

          })
      };

      $scope.new = function() {
        var project = $scope.project;

        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');

        $http({method:'POST',url:Global.prefix+'/api/project',data:{user:$scope.cur_user.id,name:project.name,description:project.description,begin:project.begin,end:project.end}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){

          })
      };

      $scope.addParticipant = function() {
        var participant = $scope.participant;

        $scope.projectId = $routeParams.projectId;
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');

        $http({method:'POST', url:Global.prefix+'/api/participant/add/'+$scope.projectId,data:{lastname:participant.lastname,firstname:participant.firstname,email:participant.email,phone:participant.phone,job:participant.job,salary:participant.salary}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){

          })
      };
    }])

}())