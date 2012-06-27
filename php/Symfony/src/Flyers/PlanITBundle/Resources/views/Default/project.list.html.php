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
			<td align="center"><?php echo $project->getName() ?></td>
			<td align="center"><?php echo $project->getDescription() ?></td>
			<td align="center"><?php echo $project->getBegin()->format("d-m-Y") ?></td>
			<td align="center"><?php echo $project->getEnd()->format("d-m-Y") ?></td>
			<td align="center"><a href="/planIT/project/delete/<?php echo $project->getIdproject() ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>