<form action="<?php echo $action; ?>" method="post" <?php echo $view['form']->enctype($form); ?> name="task" class="form">
	<table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width: 250px;">Description</td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $view['form']->widget($form['description']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Beginning date and time for the charge</td>
	    <td><?php echo $view['form']->widget($form['begin'], 
	    					array('attr' => array('class' => 'timepick'))) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Ending date and time for the charge</td>
	    <td><?php echo $view['form']->widget($form['end'], 
	    					array('attr' => array('class' => 'timepick'))) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>For task<br/><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_addTask'); ?>" title="Add a Task" class="dialog lower">Add a task</a></td>
	    <td><?php echo $view['form']->widget($form['assignment']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Charged persons<br/><a rel="section" href="<?php echo $view['router']->generate('PlanITBundle_addPerson'); ?>" title="Add a Person" class="dialog lower">Add a person</a></td>
	    <td><?php echo $view['form']->widget($form['persons']) ?></td>
	  </tr>
	</table>
	<?php echo $view['form']->rest($form) ?>
</form>