<?php $view->extend('PlanITBundle::index.html.php') ?>
<?php $view['slots']->start('login') ?>
  <h2 id="login">Login with your account</h2>
  <form action="<?php echo $view['router']->generate('PlanITBundle_login_check'); ?>" method="post" class="form">
    <table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width: 115px;">Your E-mail</td>
	    <td><input type="text" name="_username" /></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Your password</td>
	    <td><input type="password" name="_password" /></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2"><input type="submit" /></td>
	  </tr>
	</table>
  </form>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('register') ?>
  <h2 id="register">Create a new account</h2>
  <form action="<?php echo $view['router']->generate('PlanITBundle_register'); ?>" method="post" <?php echo $view['form']->enctype($form); ?> class="form">
    <table width="100%" border="0" cellspacing="5">
	  <tr>
	    <td style="width: 135px;">Your E-mail</td>
	    <td><input type="text" name="_username" /></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>New password</td>
	    <td><input type="password" name="_password" /></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>Confirm password</td>
	    <td><input type="password" name="confirm" /></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2"><input type="submit" /></td>
	  </tr>
	</table>
  </form>
<?php $view['slots']->stop() ?>