<table width="100%" border="0" cellspacing="5">
  <tr>
    <td>Number of tasks</td>
    <td><?php echo (isset($ntasks)) ? $ntasks : ''; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Number of persons working on it</td>
    <td><?php echo (isset($npersons)) ? $npersons : ''; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Estimated cost of project</td>
    <td><?php echo (isset($cost)) ? $cost.' $' : ''; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Beginning date</td>
    <td><?php echo (isset($pbegin)) ? $pbegin : ''; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Wanted ending date</td>
    <td><?php echo (isset($pend)) ? $pend : ''; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Real ending date</td>
    <td><?php echo (isset($tend)) ? $tend : ''; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Team occupation in percent</td>
    <td><?php echo (isset($toccupy)) ? $toccupy.' %' : ''; ?></td>
  </tr>
</table>