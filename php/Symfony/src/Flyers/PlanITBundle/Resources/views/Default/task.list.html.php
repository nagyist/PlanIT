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
			
			<td><?php echo $task->getProject()->getName() ?></td>
			<td><?php if ( $task->getParent() ) { echo $task->getParent()->getName(); } ?></td>
			<td><?php echo $task->getName() ?></td>
			<td><?php echo $task->getDescription() ?></td>
			<td><?php echo $task->getBegin()->format("d-m-Y H:i:s") ?></td>
			<td><?php echo $task->getEnd()->format("d-m-Y H:i:s") ?></td>
			<td>
				<a class="dialog" title="Edit an employee" rel="section" href="<?php echo $view['router']->generate('PlanITBundle_editTask', array('idassignment' => $task->getIdassignment())); ?>">Edit</a>
				&nbsp;|&nbsp;
				<a href="<?php echo $view['router']->generate('PlanITBundle_delTask', array('idassignment' => $task->getIdassignment())); ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>