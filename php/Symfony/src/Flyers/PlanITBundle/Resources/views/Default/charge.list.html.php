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
			<td><?php echo $charge->description ?></td>
			<td><?php echo $charge->begin ?></td>
			<td><?php echo $charge->end ?></td>
			<td><a href="/planIT/charge/delete/<?php echo $charge->id ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>