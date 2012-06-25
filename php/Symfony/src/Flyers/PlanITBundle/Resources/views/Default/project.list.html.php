<table>
	<thead>
		<th>Name</th>
		<th>Description</th>
		<th>Beginning</th>
		<th>Previsted End</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach( $projects as $project) : ?>
		<tr>
			<td><?php echo $project->name ?></td>
			<td><?php echo $project->description ?></td>
			<td><?php echo $project->begin ?></td>
			<td><?php echo $project->end ?></td>
			<td><a href="/planIT/project/delete/<?php echo $project->id ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>