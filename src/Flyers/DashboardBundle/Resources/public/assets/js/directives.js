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
          },
          link: function(scope, element, attrs) {
            
            scope.$watch("items", function(nVals){
                                    	
            	if (typeof nVals !== "undefined") {
            	            	
		            var chart = new Highcharts.Chart({
		            chart: {
		              renderTo: 'container',
		              plotBackgroundColor: null,
		              plotBorderWidth: null,
		              plotShadow: false,
		              type: 'area'
		            },
		            title: {
		              text: 'Burndown'
		            },
		            xAxis: {
			            type:'datetime',
			            title: {
				            enabled: true,
				            text: "Timeline"
			            }
		            },
		            yAxis: {
			            title: {
				            enabled: true,
				            text: "Remaining effort in hours"
			            }
		            },
		            series: [{
		                name:'Project Charges',
		                type: "area",
		                data: nVals['charge']
		              }, {
			              name: 'Project Timeline',
			              type: "line",
			              data: nVals['timeline']
		              }]
		            });	
		            
            	}
            	
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
	            
		            if ( (typeof nVals !== "undefined") && (nVals.length > 0) ) {
		            		              
		              element.gantt({
		                scale: "hours",
		                minScale: "hours",
		                maxScale: "months",
		                onItemClick: function(data) {
		                  // Bug Gantt hint
		                	$('body').find('.fn-gantt-hint').remove();
		                  scope.$apply(function(){$location.path("/task/edit/"+projectId+"/"+data.task);});
		                },
		                onAddClick: function(dt, rowId) {
		                  scope.$apply(function(){$location.path("/task/new/"+projectId);});
		                },
		                source: nVals
		              });
					  
								}
				  
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
              
              if (typeof nVals !== "undefined") {
              	Raphael('container').pertChart(nVals,8);	              
              }

            }, true)
          }
        }
      }]);

}())
