<?php $view->extend('PlanITBundle::base.html.php') ?>

<?php $view['slots']->start('body') ?>
    	<div id="content">
    		<form id="form_gantt" action="<?php echo $view['router']->generate('PlanITBundle_ganttFeedback'); ?>" method="post">
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
    		
    		<br /><br />
    		
	    	<div id="gantt"></div>
	    </div>
	    <?php if (isset($idproject)) : ?>
	    <script type="text/javascript">
		    $("#gantt").gantt({
				source: "<?php echo $view['router']->generate('PlanITBundle_jsongantt', array("idproject" => $idproject)); ?>", 
				navigate: 'scroll', 
				scale: 'hours', 
				maxScale: 'weeks', 
				minScale: 'hours', 
				hollydays: ["\/Date(1293836400000)\/","\/Date(1294268400000)\/","\/Date(1303596000000)\/","\/Date(1306274400000)\/","\/Date(1304200800000)\/","\/Date(1304373600000)\/","\/Date(1307829600000)\/","\/Date(1308780000000)\/","\/Date(1313359200000)\/","\/Date(1320105600000)\/","\/Date(1320966000000)\/","\/Date(1324767600000)\/","\/Date(1324854000000)\/","\/Date(1325372400000)\/","\/Date(1325804400000)\/","\/Date(1333836000000)\/","\/Date(1336514400000)\/","\/Date(1335823200000)\/","\/Date(1335996000000)\/","\/Date(1338069600000)\/","\/Date(1339020000000)\/","\/Date(1344981600000)\/","\/Date(1351724400000)\/","\/Date(1352588400000)\/","\/Date(1356390000000)\/","\/Date(1356476400000)\/"]
			});
	    </script>
	    <?php endif; ?>
<?php $view['slots']->stop() ?>