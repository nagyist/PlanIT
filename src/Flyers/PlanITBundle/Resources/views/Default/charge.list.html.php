<table>
	<thead>
		<th>Task</th>
		<th>Description</th>
		<th>Worked on</th>
		<th>Duration</th>
		<th style="width:90px;">Actions</th>
	</thead>
	<tbody>
		<?php foreach( $charges as $charge) : ?>
		<tr>
			<td align="center"><?php echo $charge->getAssignment()->getName(); ?></td>
			<td align="center"><?php echo substr($charge->getDescription(), 0, 20); if ( strlen($charge->getDescription()) > 20 ) echo '...'; ?></td>
			<td align="center"><?php echo $charge->getDate()->format("d-m-Y"); ?></td>
			<td align="center"><?php echo $charge->getDuration(); ?></td>
			<td align="center">
				<a class="dialog" title="Edit an charge" rel="section" href="<?php echo $view['router']->generate('PlanITBundle_editCharge', array('idcharge' => $charge->getIdcharge())); ?>">Edit</a>
				&nbsp;|&nbsp;
				<a class="dialog" rel="help" title="Charge deleted" href="<?php echo $view['router']->generate('PlanITBundle_delCharge', array('idcharge' => $charge->getIdcharge())); ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php if ( count($charge) <= 0) : ?>
		<tr>
			<td colspan="5" align="center">No charges created for the moment</td>
		</tr>
		<?php endif; ?>
	</tbody>
	
</table>