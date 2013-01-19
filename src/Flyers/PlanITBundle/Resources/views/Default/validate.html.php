<!DOCTYPE html>
<html>
	<head>
		<?php foreach ($view['assetic']->stylesheets(
		    	array(
		    		'bundles/planit/planit-style.css',
		    	),
		    	array('cssrewrite','yui_css'),
		    	array('output'=>'css/planIT.css')
		      ) as $url): ?>
			<link rel="stylesheet" href="<?php echo $view->escape($url) ?>" type="text/css" media="screen" />
		<?php endforeach; ?>
	</head>
	<body>
		<h1>Account validated</h1>
		<p>Your account have just been updated successfully. You will be redirected to the <a href="">home page</a></p>
		<script>
			setTimeout(function() {
			   window.location.href = "<?php echo $view['router']->generate('PlanITBundle_index'); ?>";
			}, 30000);
		</script>
	</body>
</html>