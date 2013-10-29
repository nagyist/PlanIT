(function () {
    "use strict";

    /* Filters */

    angular.module('PlanIT.filters', []).
        filter('test', [function(){
            
        }]);


    /*.
      filter('groupBy', [function(){
        return function(items, groupedBy) {
            var finalItems = [];
            var thisGroup;
            for (var i=0; i<items.length; i++) {
                if (!thisGroup)
                    thisGroup = [];
                thisGroup.push(items[i]);
                if (((i+1) % groupedBy) === 0) {
                    finalItems.push(thisGroup);
                    thisGroup = null;
                }
            }
            if (thisGroup) {
                finalItems.push(thisGroup);
            }
            return finalItems;
        }
      }]);*/

}())