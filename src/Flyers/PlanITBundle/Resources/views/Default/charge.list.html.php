<table>
	<thead>
		<th>Description</th>
		<th>Beginning</th>
		<th>End</th>
	</thead>
	<tbody>
		<?php foreach( $charges as $charge) : ?>
		<tr>
			<td><?php echo $charge->getDescription() ?></td>
			<td><?php echo $charge->getBegin()->format("d-m-Y H:i:s") ?></td>
			<td><?php echo $charge->getEnd()->format("d-m-Y H:i:s") ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>