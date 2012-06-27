<table>
	<thead>
		<th>Description</th>
		<th>Beginning</th>
		<th>End</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach( $charges as $charge) : ?>
		<tr>
			<td><?php echo $charge->getDescription() ?></td>
			<td><?php echo $charge->getBegin()->format("d-m-Y H:i:s") ?></td>
			<td><?php echo $charge->getEnd()->format("d-m-Y H:i:s") ?></td>
			<td><a href="/planIT/charge/edit/<?php echo $charge->getIdcharge() ?>">Edit</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>