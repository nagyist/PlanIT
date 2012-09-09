<form action="<?php echo $action; ?>" method="post" <?php echo $view['form']->enctype($form); ?> name="project" class="form">
	<table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width: 250px;">Project Name</td>
	    <td>
	    	<?php echo $view['form']->widget($form['name']) ?>
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2">Project Description</td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $view['form']->widget($form['description']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Beginning date for the project</td>
	    <td><?php echo $view['form']->widget($form['begin'], 
	    					array('attr' => array('class' => 'datepick'))) ?></td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Ending time for the project</td>
	    <td><?php echo $view['form']->widget($form['end'], 
	    					array('attr' => array('class' => 'datepick'))) ?></td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	  </tr>
	</table>
	<?php echo $view['form']->rest($form) ?>
</form>