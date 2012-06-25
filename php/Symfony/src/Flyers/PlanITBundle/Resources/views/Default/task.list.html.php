<table>
	<thead>
		<th>Project</th>
		<th>Parent task</th>
		<th>Name</th>
		<th>Description</th>
		<th>Beginning</th>
		<th>Previsted End</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach( $tasks as $task) : ?>
		<tr>
			<td><?php echo $task->parent->name ?></td>
			<td><?php echo $task->project->name ?></td>
			<td><?php echo $task->name ?></td>
			<td><?php echo $task->description ?></td>
			<td><?php echo $task->begin ?></td>
			<td><?php echo $task->end ?></td>
			<td><a href="/planIT/task/delete/<?php echo $task->id ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>