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
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadProjects = function() {
        $scope.checkUser();

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

      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadJob = function() {
        $scope.checkUser();

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
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

      $scope.loadProject = function() {
        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $http({method:'GET', url:Global.prefix+'/api/project/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.project = data.project;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

      $scope.addProject = function() {
        var project = $scope.project;

        $scope.checkUser();

        $http({method:'POST',url:Global.prefix+'/api/project',data:{user:$scope.cur_user.id,name:project.name,description:project.description,begin:project.begin,end:project.end}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

      $scope.editProject = function() {
        var project = $scope.project;

        $scope.checkUser();

        $http({method:'PUT',url:Global.prefix+'/api/project/'+project.id,data:{user:$scope.cur_user.id,name:project.name,description:project.description,begin:project.begin,end:project.end}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

      $scope.addParticipant = function() {
        var participant = $scope.participant;

        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $http({method:'POST', url:Global.prefix+'/api/participant/add/'+$scope.projectId,data:{lastname:participant.lastname,firstname:participant.firstname,email:participant.email,phone:participant.phone,job:participant.job,salary:participant.salary}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };
    }])
    .controller('EmployeesCtrl', ['$scope', '$http', '$location', 'Global', function($scope, $http, $location, Global) {
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadEmployees = function() {
        $scope.checkUser();

        $http({method:'GET', url:Global.prefix+'/api/employees/'+$scope.cur_user.id})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.employees = data.employees;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

    }])
    .controller('JobCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global){
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.addJob = function() {
        var job = $scope.job;

        $http({method:'POST', url:Global.prefix+'/api/job',data:{name:job.name,description:job.description}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };
    }])
    .controller('EmployeeCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global) {
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadJob = function() {
        $scope.checkUser();
        $scope.employee = {};

        $http({method:'GET', url:Global.prefix+'/api/jobs'})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.jobs = data.jobs;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

      $scope.loadEmployee = function() {
        $scope.employeeId = $routeParams.employeeId;

        $scope.loadJob();

        $http({method:'GET', url:Global.prefix+'/api/employee/'+$scope.employeeId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.employee = data.employee;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

      $scope.addEmployee = function() {
        var employee = $scope.employee;

        $scope.checkUser();

        $http({method:'POST',url:Global.prefix+'/api/employee',data:{user:$scope.cur_user.id,lastname:employee.lastname,firstname:employee.firstname,email:employee.email,phone:employee.phone,salary:employee.salary,job:employee.job}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

      $scope.editEmployee = function () {
        var employee = $scope.employee;

        $scope.checkUser();

        $http({method:'PUT',url:Global.prefix+'/api/employee/'+employee.id,data:{user:$scope.cur_user.id,lastname:employee.lastname,firstname:employee.firstname,email:employee.email,phone:employee.phone,salary:employee.salary,job:employee.job}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }
    }])
    .controller('TasksCtrl', ['$scope', '$http', '$location', '$routeParams','Global', function($scope, $http, $location, $routeParams, Global) {
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadTasks = function() {
        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $http({method:'GET', url:Global.prefix+'/api/tasks/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.tasks = data.tasks;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

    }])
    .controller('TaskCtrl', ['$scope', '$http', '$location', '$routeParams','Global', function($scope, $http, $location, $routeParams, Global) {
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadTasks = function() {
        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $http({method:'GET', url:Global.prefix+'/api/tasks/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.tasks = data.tasks;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      };

      $scope.loadEmployees = function() {
        $scope.loadTasks();

        $http({method:'GET', url:Global.prefix+'/api/employees/'+$scope.cur_user.id})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.employees = data.employees;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

      $scope.addTask = function() {
        var task = $scope.task;

        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $http({method:'POST',url:Global.prefix+'/api/task',data:{user:$scope.cur_user.id,project:$scope.projectId,name:task.name,description:task.description,begin:task.begin,estimate:task.estimate,employees:task.employees,parent:task.parent}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

      
    }])
    .controller('ChargesCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global){
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

    }])
    .controller('ChargeCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global){
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadEmployees = function() {
        $scope.checkUser();

        $http({method:'GET', url:Global.prefix+'/api/employees/'+$scope.cur_user.id})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.employees = data.employees;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }


      $scope.loadTasks = function() {
        $scope.projectId = $routeParams.projectId;

        $scope.loadEmployees();

        $http({method:'GET', url:Global.prefix+'/api/tasks/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.tasks = data.tasks;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }


      $scope.addCharge = function() {
        var charge = $scope.charge;

        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $http({method:'POST',url:Global.prefix+'/api/charge',data:{user:$scope.cur_user.id,project:$scope.projectId,task:charge.task,description:charge.description,duration:charge.duration,employee:charge.employee}})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.notice = data.message;
            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }

    }])
    .controller('BurndownCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global){
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };


      $scope.loadBurndown = function() {
        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $scope.hcValues = [];

        /* Load Tasks */
        $http({method:'GET', url:Global.prefix+'/api/tasks/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.tasks = data.tasks;

              var total = 0;

              for (var i = 0; i<data.tasks.length; i++) {
                var task = data.tasks[i];
                total += task.estimate;
              }
              for (var i = 0; i<data.tasks.length; i++) {
                $scope.hcValues.push(total);

                var task = data.tasks[i];
                
                if(task.charges.length > 0) {
                  for (var j=0; j<task.charges.length;j++) {
                    var charge = task.charges[j];
                    total -= charge.duration;
                  }
                }
              }

              console.log($scope.hcValues);

            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })

      }  

    }])
    .controller('GanttCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global){
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadGantt = function() {
        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $scope.ganttValues = [];

/*
        $scope.ganttValues = [{
                  name: 'Test',
                  desc: 'Test',
                  values: [{
                    to: "/Date(1328832000000)/",
                    from: "/Date(1333411200000)/",
                    desc: "Something",
                    label: "Example Value"
                  }]
                }];
*/                

        $http({method:'GET', url:Global.prefix+'/api/tasks/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.tasks = data.tasks;

              for (var i = 0; i<data.tasks.length; i++)
              {
                var task = data.tasks[i];

                var taskFrom = moment(task.begin);
                var taskTo = taskFrom.add('minutes', task.estimate);

                var itemTask = {
                    name:task.name, 
                    values: [{
                      from:"/Date("+taskFrom.valueOf()+")/", 
                      to:"/Date("+taskTo.valueOf()+")/", 
                      desc: task.description, 
                      label: task.name,
                      dataObj: {project:task.project.id,task:task.id}
                    }]
                  };

                $scope.ganttValues.push(itemTask);

              }

              console.log($scope.ganttValues)

            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }
    }])
    .controller('PertCtrl', ['$scope', '$http', '$location', '$routeParams', 'Global', function($scope, $http, $location, $routeParams, Global){
      $scope.checkUser = function() {
        $scope.cur_user = Global.user;
        if(typeof $scope.cur_user == "undefined") $location.path('/');
      };

      $scope.loadPert = function () {
        $scope.checkUser();

        $scope.projectId = $routeParams.projectId;

        $scope.pertValues = [];

        $scope.pertValues = {
          begin: "Thu, 21 Dec 2000 16:01:07 +0200",
          end: "Thu, 30 Dec 2000 16:01:07 +0200",
          tasks: [{
            id: 1,
            name: 'Test',
            duration: 150,
            parent: null
          }]
        };

        $http({method:'GET', url:Global.prefix+'/api/tasks/'+$scope.projectId})
          .success(function(data,status,headers){
            if(data.error == "error") {
              $scope.error = data.message;
            } else {
              $scope.tasks = data.tasks;



            }
          })
          .error(function(data,status,headers){
            if (data.error == "error") {
              $scope.error = data.message;
            }
          })
      }
    }])
}())