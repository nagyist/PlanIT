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

/*
      var Project = $resource('https://api.mongolab.com/api/1/databases/flyersweb/collections/projects/:id', 
      { apiKey: 'bEpyIKo90xEFGGaWZ5CQEOl8ZpOcHeUQ' } ,  
      {
        update: {method:'PUT'},
        query: {method:'GET', params:{}, isArray:true}
      });

      Project.prototype.update = function(cb) {
        return Project.update({id: this._id.$oid},
          angular.extend({}, this, {_id:undefined}), cb)
      }

      Project.prototype.destroy = function(cb) {
        return Project.remove({id: this._id.$oid}, cb);
      }
    
      return Project;
      */