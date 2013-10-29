(function () {
  "use strict";

  /* Controllers */

  angular.module('PlanIT.controllers', [])
    .controller('LoginCtrl', ['$scope', '$http', 'Global', function($scope, $http, Global) {
      $scope.user = {};

      $scope.submit = function() {
        var user = $scope.user;

        $http({method: 'POST', url:Global.prefix+'/user/auth', data:{email:user.login,password:user.password}})
          .success(function(data,status,headers){

          })
          .error(function(data,status,headers){

          });
      }
    }])
    .controller('RegisterCtrl', ['$scope', '$http', function($scope, $http) {
      $scope.user = {};

      $scope.submit = function() {
        var user = $scope.user;

        $http({method: 'POST', url:Global.prefix+'/user/create'})
          .success(function(data,status,headers){
            
          })
          .error(function(data,status,headers){
            
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
    

}())