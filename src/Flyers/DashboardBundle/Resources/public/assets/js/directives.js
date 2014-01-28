(function () {
    "use strict";

    /* Directives */

    angular.module('PlanIT.directives', [])
      .directive('appVersion', ['version', function(version) {
        return function(scope, elm, attrs) {
          elm.text(version);
        };
      }])
      .directive('jqdatepicker', [function(){
      	return {
      	  restrict: 'A',
      	  require: 'ngModel',
      	  link: function(scope, element, attrs, ngModelCtrl) {
      	  	element.datepicker({
      	  		dateFormat: 'dd/mm/yy',
      	  		onSelect: function(date){
      	  			scope.$apply(function(){
      	  				ngModelCtrl.$setViewValue(date);
      	  			});
      	  		}
      	  	})
      	  }
      	}
      }])
      .directive('hcBurndown', [function(){
        return {
          restrict: 'A',
          replace : true,
          template: '<div id="container" style="width:100%;">not working</div>',
          scope: {
            items: '='
          },
          controller: function($scope, $element, $attrs) {
            console.log("hcBurndown")
          },
          link: function(scope, element, attrs) {
            console.log("hcBurndown")
            var chart = new Highcharts.Chart({
              chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
              },
              title: {
                text: 'Burndown'
              },
              series: [{
                name:'Project Burndown',
                data: scope.items
              }]
            });

            scope.$watch("items", function(nVals){
              chart.series[0].setData(nVals, true);
            }, true);

          }
        }
      }])
      .directive('jqGantt', ['$location', function($location){
        return {
          restrict: 'A',
          replace: true,
          template: '<div id="container" style="width:100%;">not working</div>',
          scope: {
            items: '=',
            project: '='
          },
          controller: function($scope, $element, $attrs) {
          },
          link: function(scope, element, attrs) {
          
          	scope.$watch("project", function(projectId){
          	
	            scope.$watch("items", function(nVals){
	              
	              element.gantt({
	                scale: "weeks",
	                minScale: "hours",
	                maxScale: "months",
	                onItemClick: function(data) {
	                  scope.$apply(function(){$location.path("/task/edit/"+projectId+"/"+data.task);});
	                },
	                onAddClick: function(dt, rowId) {
	                  scope.$apply(function(){$location.path("/task/add/"+projectId);});
	                },
	                source: nVals
	              });
	
	            }, true)
	            
            }, true)
          }
        }
      }])
      .directive('graphPert',[function(){
        return {
          restrict: 'A',
          replace: true,
          template: '<div id="container" style="height:550px;width:100%;">not working</div>',
          scope: {
            items: '='
          },
          controller: function($scope, $element, $attrs) {
          },
          link: function(scope, element, attrs) {
            scope.$watch("items", function(nVals){
              console.log(nVals);
              Raphael('container').pertChart(nVals,8);
            }, true)
          }
        }
      }]);

}())
