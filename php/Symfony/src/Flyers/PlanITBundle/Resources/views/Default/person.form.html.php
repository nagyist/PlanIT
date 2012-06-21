<form action="<?php echo $action; ?>" method="post" <?php echo $view['form']->enctype($form); ?> name="person" class="form">
	<table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width: 250px;">Firstname</td>
	    <td><?php echo $view['form']->widget($form['firstname']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Lastname</td>
	    <td><?php echo $view['form']->widget($form['lastname']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Email address</td>
	    <td><?php echo $view['form']->widget($form['mail']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Phone number</td>
	    <td><?php echo $view['form']->widget($form['phone']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Daily salary</td>
	    <td><?php echo $view['form']->widget($form['salary']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Job<br /><a rel="section" class="dialog lower" href="<?php echo $view['router']->generate('PlanITBundle_addJob'); ?>" title="Add a new job">Add a new job</a></td>
	    <td><?php echo $view['form']->widget($form['job']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Project<br /><a rel="section" class="dialog lower" href="<?php echo $view['router']->generate('PlanITBundle_addProject'); ?>" title="Add a new project">Add a new project</a></td>
	    <td><?php echo $view['form']->widget($form['projects']) ?></td>
	  </tr>
	</table>
	<?php echo $view['form']->rest($form) ?>
</form>