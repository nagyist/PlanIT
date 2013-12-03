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
          scope: {
            items: '='
          },
          controller: function($scope, $element, $attrs) {
            console.log("hcBurndown")
          },
          template: '<div id="container" style="margin:0 auto">not working</div>',
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

            scope.$watch("items", function(nValue){
              console.log(nValue);
              chart.series[0].setData(nValue, true);
            }, true);

          }
        }
      }]);

}())
