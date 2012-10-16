<?php $view->extend('PlanITBundle::base.html.php') ?>

<?php $view['slots']->start('body') ?>
    	<div id="content">
    		<form id="form_burndown" action="<?php echo $view['router']->generate('PlanITBundle_burndownFeedback'); ?>" method="post">
	    		<table width="100%" border="0" cellspacing="5">
		    		<tr>
		    			<td style="width: 150px;"><label for="idproject">Choose your project :</label></td>
		    			<td>
			    			<select id="idproject" name="idproject" class="autosubmit">
				    			<?php foreach ($projects as $p) : ?>
				    				<?php if ($p->getIdproject() == $idproject) $current_project = clone $p; ?>
				    			<option <?php echo ($p->getIdproject() == $idproject) ? 'selected="selected"' : '' ;?> value="<?php echo $p->getIdproject(); ?>"><?php echo $p->getName(); ?></option>
				    			<?php endforeach; ?>
				    		</select>
		    			</td>
		    		</tr>
		    	</table>
    		</form>
    		
    		<div id="chartdiv" style="height:550px;width:100%;"></div>
    	</div>
    	<?php if (isset($graphic) && !empty($graphic)) : ?>
    	<script type="text/javascript">
    		var data = <?php echo $graphic ?>;
    		if ( data ) {
	    		$.jqplot('chartdiv', <?php echo $graphic; ?>, {
	    			axes:{
	    				xaxis:{
	    					min: '<?php echo $current_project->getBegin()->format("Y-m-d"); ?>',
	    					max: '<?php echo $current_project->getEnd()->format("Y-m-d"); ?>',
	    					renderer:$.jqplot.DateAxisRenderer,
	    					tickRenderer: $.jqplot.CanvasAxisTickRenderer,
	    					tickInterval:'2 day',
	    				},
	    				yaxis:{
	    					min: 0,
	    					tickOptions:{
				            	formatString:'%.1f days'
				            }
	    				}
	    			},
	    			series:[{
		    				
	    				},
	    				{
	    					showMarker:false
						}],
	    			highlighter: {
	    				show: true
	    			},
	    			fillBetween: {
			            // series1: Required, if missing won't fill.
			            series1: 0,
			            // series2: Required, if  missing won't fill.
			            series2: 1,
			            // color: Optional, defaults to fillColor of series1.
			            color: "rgba(227, 167, 111, 0.7)",
			        },
	    		});
    		}
    	</script>
    	<?php endif; ?>
<?php $view['slots']->stop() ?>