<?php
?>
<form id="contact" name="contact" method="post" class="form" action="<?php echo $view['router']->generate('PlanITBundle_contact'); ?>">
	<!--<table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td><label for="name">Your name</label></td>
	    <td>
	      <input type="text" name="name" id="name" />
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td><label for="email">Contact email</label></td>
	    <td>
	      <input type="text" name="email" id="email" /></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td><label for="subject">Subject of the message</label></td>
	    <td>
	      <input type="text" name="subject" id="subject" /></td>
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
	      <textarea name="message" id="message" cols="45" rows="5"></textarea></td>
	  </tr>
	  -->
	  <?php echo $view['form']->widget($form) ?>
	</table>
</form>