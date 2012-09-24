<?php $view->extend('PlanITBundle::base.html.php') ?>

<?php $view['slots']->start('body') ?>
    	<div id="content">
    		<form id="form_pert" action="<?php echo $view['router']->generate('PlanITBundle_pertFeedback'); ?>" method="post">
	    		<table width="100%" border="0" cellspacing="5">
		    		<tr>
		    			<td style="width: 150px;"><label for="idproject">Choose your project :</label></td>
		    			<td>
			    			<select id="idproject" name="idproject" class="autosubmit">
				    			<?php foreach ($projects as $p) : ?>
				    			<option <?php echo ($p->getIdproject() == $idproject) ? 'selected="selected"' : '' ;?> value="<?php echo $p->getIdproject(); ?>"><?php echo $p->getName(); ?></option>
				    			<?php endforeach; ?>
				    		</select>
		    			</td>
		    		</tr>
		    	</table>
    		</form>
    		
    		<div id="pert" style="height:550px;width:100%;overflow:auto;"></div>
    	</div>
    	<?php if (isset($graphic) && !empty($graphic)) : ?>
    	<script type="text/javascript">
    		var project = <?php echo $graphic; ?>;
    		Raphael('pert').pertChart(project,8);
    	</script>
    	<?php endif; ?>
<?php $view['slots']->stop() ?>