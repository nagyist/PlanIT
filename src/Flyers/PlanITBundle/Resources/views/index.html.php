<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php $view['slots']->output('title', 'PlanIT - plan your projects') ?></title>
        <?php /*foreach ($view['assetic']->stylesheets(
		    	array(
		    		'bundles/planit/jquery-ui/css/flick/jquery-ui-1.8.16.custom.css',
		    		'bundles/planit/planit-style.css',
		    	),
		    	array('cssrewrite'),
		    	array('output'=>'css/base.css')
		      ) as $url): ?>
			<link rel="stylesheet" href="<?php echo $view->escape($url) ?>" type="text/css" media="screen" />
		<?php endforeach;  */?>
		
		<link href="<?php echo $view['assets']->getUrl('bundles/planit/jquery-ui/css/flick/jquery-ui-1.8.16.custom.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $view['assets']->getUrl('bundles/planit/planit-style.css') ?>" rel="stylesheet" type="text/css" />
				
        <?php /*foreach ($view['assetic']->javascripts(
		    array(
		    	'bundles/planit/jquery-ui/js/jquery-1.6.2.min.js',
		    	'bundles/planit/jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
		        'bundles/planit/video/jwplayer.js',
		    	'bundles/planit/initialize.js',
		    ),
		    array(),
		    array('output'=>'js/base.js')
		    ) as $url): ?>
			<script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
		<?php endforeach; */?>
		
		<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/planit/jquery-ui/js/jquery-1.7.2.min.js') ?>"></script>
		<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/planit/jquery-ui/js/jquery-ui-1.8.16.custom.min.js') ?>"></script>
		<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/planit/video/jwplayer.js') ?>"></script>
		<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/planit/initialize.js') ?>"></script>
		
    </head>
    <body>
      <div id="wrapheader">
	      <div id="header">
	      	<h1>PlanIT</h1>
	      	<h2 id="slogan">Plan it Right now</h2>
	      </div>
      </div>
      <div id="index">
      	<div class="left" style="width:470px;">
      		<div id="player">Loading the player ...</div>
      	</div>
      	<div class="right" style="width:470px;">
      	  <p class="justify">
      	  	<span id="kezako">PlanIT What's that ?</span>
      	  	PlanIT is a web tool allowing you to manage efficiently all your projects. You create separate teams for your different projects and define easily tasks time duration in order to know day by day how are doing your projects.
			<br /><br />
			It also offer diagrams representations of your current projects in order to manage easily the working charge of your teams, the projects deadlines and make prevision in order to optimize realisation times of all your current projects.
      	  </p>
      	</div>
      	<div class="clear" style="height:50px;"></div>
      	<?php if ( isset($error) ): ?>
      		<script>
      			var dialog = $('<div class="modals" style="display:none;"><p><?php echo $error ?></p></div>').appendTo("body");
      			dialog.dialog({
					close: function(event, ui) {
						dialog.remove();
					},
					buttons: { "Close": function() { $(this).dialog("close"); } },
					title: "Error while processing form",
					closeOnEscape: true,
					modal: true,
					minWidth: 600
				});
      		</script>
		<?php endif; ?>
    	<div class="left" style="width:470px;">
		<?php $view['slots']->output('login') ?>
		</div>
		<div class="right" style="width:470px;">
		<?php $view['slots']->output('register') ?>
		</div>
      </div>
      <?php echo $view->render('PlanITBundle::footer.html.php', array() ); ?>
      <script type="text/javascript">
      jwplayer("player").setup({ flashplayer: "<?php echo $view['assets']->getUrl('bundles/planit/video/player.swf') ?>", file: "<?php echo $view['assets']->getUrl('bundles/planit/video/video.mp4') ?>", height: 300, width: 470 });
      </script>
    </body>
</html>