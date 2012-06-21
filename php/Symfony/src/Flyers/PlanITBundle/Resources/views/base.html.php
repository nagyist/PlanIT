<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php $view['slots']->output('title', 'PlanIT - Plan it Right now') ?></title>
        <?php foreach ($view['assetic']->stylesheets(
		    	array(
		    		'bundles/planit/jquery-ui/css/flick/jquery-ui-1.8.16.custom.css',
		    		'bundles/planit/jquery-ui/css/flick/jquery-ui-timepicker-addon.css',
		    		'bundles/planit/jquery-gantt/style.css',
		    		'bundles/planit/fullcalendar/fullcalendar.css',
		    		'bundles/planit/planit-style.css',
		    	),
		    	array('cssrewrite'),
		    	array('output'=>'css/planIT.css')
		      ) as $url): ?>
			<link rel="stylesheet" href="<?php echo $view->escape($url) ?>" type="text/css" media="screen" />
		<?php endforeach;  ?>
				
        <?php foreach ($view['assetic']->javascripts(
		    array(
		    	'bundles/planit/jquery-ui/js/jquery-1.6.2.min.js',
		    	'bundles/planit/jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
		    	'bundles/planit/jquery-ui/js/jquery-ui-timepicker-addon.js',
		    	'bundles/planit/jquery-gantt/jquery.fn.gantt.js',
		    	'bundles/planit/fullcalendar/fullcalendar.js',
		    	'bundles/planit/initialize.js'
		    ),
		    array(),
		    array('output'=>'js/planIT.js')
		    ) as $url): ?>
			<script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
		<?php endforeach; ?>
		
    </head>
    <body id="planit">
    	<a href="<?php echo $view['router']->generate('PlanITBundle_logout'); ?>" class="right" style="color:white;padding:17px 6px;">Logout</a>
    	<h1>
	        <a href="<?php echo $view['router']->generate('PlanITBundle_homepage'); ?>"><?php $view['slots']->output('title', 'Plan IT') ?></a>
	    </h1>
	    
	    <ul id="menu">
	        <li>
	        	<a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listProject'); ?>" title="Manage projects" id="project" class="dialog">Projects</a>
	        	<ul class="submenu" id="subproject">
	        		<li><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_addProject'); ?>" title="Add a project" class="dialog">Add</a></li>
	        		<li><a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listProject'); ?>" title="Manage projects" class="dialog">List</a></li>
	        	</ul>
	        </li>
	        <li>
	        	<a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listPerson'); ?>" title="Manage team members" id="team" class="dialog">Team members</a>
	        	<ul class="submenu" id="subteam">
	        		<li><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_addPerson'); ?>" title="Add a Team member" class="dialog">Add</a></li>
	        		<li><a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listPerson'); ?>" title="Manage team members" class="dialog">List</a></li>
	        	</ul>
	        </li>
	        <li>
	        	<a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listTask'); ?>" title="Manage tasks" id="task" class="dialog">Tasks</a>
	        	<ul class="submenu" id="subtask">
	        		<li><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_addTask'); ?>" title="Add a task" class="dialog">Add</a></li>
	        		<li><a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listTask'); ?>" title="Manage tasks" class="dialog">List</a></li>
	        	</ul>
	        </li>
	        <li>
	        	<a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listCharge'); ?>" title="Manage charges" id="task" class="dialog">Charges</a>
	        	<ul class="submenu" id="subtask">
	        		<li><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_addCharge'); ?>" title="Add a charge" class="dialog">Add</a></li>
	        		<li><a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listCharge'); ?>" title="Manage charges" class="dialog">List</a></li>
	        	</ul>
	        </li>
	        <li>
	        	<a rel="help" href="<?php echo $view['router']->generate('PlanITBundle_listFeedback'); ?>" title="Manage feedbacks" id="feedback" class="dialog">Feedback</a>
	        	<ul class="submenu" id="subfeedback">
	        		<li><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_ganttFeedback'); ?>" title="Get the Gantt for the specified project">Gantt</a></li>
	        		<!-- <li><a href="<?php echo $view['router']->generate('PlanITBundle_pertFeedback'); ?>" title="Get the Pert diagram from the specified project">PERT</a></li>  -->
	        	</ul>
	        </li>
	    </ul>
	    
	    <?php $view['slots']->output('body') ?>
	    <p style="height:30px;">&nbsp;</p>
	    <?php echo $view->render('PlanITBundle::footer.html.php', array() ); ?>
    
    </body>
</html>