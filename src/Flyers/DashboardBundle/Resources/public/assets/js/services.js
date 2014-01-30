(function () {
  "use strict";

  /* Services */

  angular.module('PlanIT.services', ['ngResource'])
    .config(['$interpolateProvider', function($interpolateProvider){
      $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    }])
    .factory('Global', [function(){
      return {
        prefix: '/planit/app_dev.php',
        durationTransform: function(tr) {
        	var bmonth = moment().startOf('month');
        	var emonth = moment().endOf('month');
        	
        	var ddmonth = emonth.diff(bmonth, 'days');
        
	        var tr = parseFloat(tr);
	        var un = "";
	        
	        //Month
	        if (tr > (60 * 24 * ddmonth)) {
		        tr = tr / (60*24*ddmonth);
		        un = "months";
	        }
	        // Day
	        if (tr > (60 * 24)) {
		        tr = tr / (60*24);
		        un = "days";
	        }
	        // Hours
	        if (tr > 60 ) {
		        tr = tr / 60;
		        un = "hours";
	        }
	        return tr+" "+un;
        }
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