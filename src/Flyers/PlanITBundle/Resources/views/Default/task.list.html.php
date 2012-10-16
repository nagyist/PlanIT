<table>
	<thead>
		<th>Project</th>
		<th>Parent task</th>
		<th>Name</th>
		<th>Description</th>
		<th>Beginning</th>
		<th>Previsted End</th>
		<th style="width:90px;">Actions</th>
	</thead>
	<tbody>
		<?php foreach( $tasks as $task) : ?>
		<tr>
			
			<td align="center"><?php echo $task->getProject()->getName() ?></td>
			<td align="center"><?php if ( $task->getParent() ) { echo $task->getParent()->getName(); } ?></td>
			<td align="center"><?php echo $task->getName() ?></td>
			<td align="center"><?php echo substr($task->getDescription(), 0, 20); if ( strlen($task->getDescription()) > 20 ) echo '...'; ?></td>
			<td align="center"><?php echo $task->getBegin()->format("d-m-Y H:i") ?></td>
			<td align="center"><?php echo $task->getEnd()->format("d-m-Y H:i") ?></td>
			<td align="center">
				<a class="dialog" title="Edit an assignment" rel="section" href="<?php echo $view['router']->generate('PlanITBundle_editTask', array('idassignment' => $task->getIdassignment())); ?>">Edit</a>
				&nbsp;|&nbsp;
				<a class="dialog" rel="help" title="Task deleted" href="<?php echo $view['router']->generate('PlanITBundle_delTask', array('idassignment' => $task->getIdassignment())); ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php if ( count($tasks) <= 0) : ?>
		<tr>
			<td colspan="8" align="center">No tasks created</td>
		</tr>
		<?php endif; ?>
	</tbody>
	
</table>