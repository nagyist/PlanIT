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
	    <td>When employee have worked on the task?</td>
	    <td><?php echo $view['form']->widget($form['date'], 
	    					array('attr' => array('class' => 'datepick'))) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Duration in days<br/><span class="helper">you can use floats for hours</span></td>
	    <td><?php echo $view['form']->widget($form['duration']) ?></td>
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