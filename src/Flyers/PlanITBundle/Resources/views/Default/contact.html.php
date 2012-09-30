<?php
?>
<form id="contact" name="contact" method="post" class="form" action="<?php echo $view['router']->generate('PlanITBundle_contact'); ?>">
	<table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width:25%;"><label for="name">Your name</label></td>
	    <td>
	      <?php echo $view['form']->widget($form['name']) ?>
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td><label for="email">Contact email</label></td>
	    <td>
	      <?php echo $view['form']->widget($form['email']) ?>
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td><label for="subject">Subject of the message</label></td>
	    <td>
	      <?php echo $view['form']->widget($form['subject']) ?>
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2"><label for="message">Message</label></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2">
	      <?php echo $view['form']->widget($form['message']) ?>
	    </td>
	  </tr>
	</table>
</form>