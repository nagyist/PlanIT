(function () {
  "use strict";

  /* Services */

  angular.module('PlanIT.services', ['ngResource'])
    .config(['$interpolateProvider', function($interpolateProvider){
      $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    }])
    .factory('Global', [function(){
      return {
        prefix: '/planit/app_dev.php'
      }
    }])
    .factory('User', ['$resource', 'Global', function($resource, Global) {
      var prefix = Global.prefix;
      var User = $resource(prefix+'/api/user',
        {},
        {
          update:{method:'PUT'},
        });
      return User;
    }])
    .factory('Contact', ['$resource', 'Global', function($resource, Global) {
      var prefix = Global.prefix;
      var Contact = $resource(prefix+'/api/contact',
        {},
        {
          send:{method:'POST'}
        });
      return Contact;
    }])
    .factory('Projects', ['$resource', 'Global', function($resource, Global) {
      var prefix = Global.prefix;
      var Projects = $resource(prefix+'/api/projects',
        {},
        {});
      return Projects;
    }])
    

}())