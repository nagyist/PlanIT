<form action="<?php echo $action; ?>" method="post" <?php echo $view['form']->enctype($form); ?> name="job" class="form">
	<table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width: 250px;">Job name</td>
	    <td><?php echo $view['form']->widget($form['name']) ?></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2">Job description</td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $view['form']->widget($form['description']) ?></td>
	  </tr>
	</table>
	<?php echo $view['form']->rest($form) ?>
</form>