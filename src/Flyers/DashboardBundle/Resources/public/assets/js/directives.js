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
      .directive('jqGantt', [function(){
        return {
          restrict: 'A',
          replace: true,
          template: '<div id="container" style="width:100%;">not working</div>',
          scope: {
            items: '='
          },
          controller: function($scope, $element, $attrs) {
          },
          link: function(scope, element, attrs) {

            scope.$watch("items", function(nVals){
              
              // TODO add (add Task and Edit Task events)
              element.gantt({
                scale: "weeks",
                minScale: "hours",
                maxScale: "months",
                onItemClick: function(data) {
                  console.log(data);
                  alert("Item clicked - show some details");
                },
                onAddClick: function(dt, rowId) {
                  console.log(dt);
                  console.log(rowId);
                  alert("Empty space clicked - add an item!");
                },
                source: nVals
              });

            }, true)
          }
        }
      }])
      .directive('raphPert',[function(){
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
