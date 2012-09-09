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
			<td align="center">
				<a title="Burndown of the project" href="<?php echo $view['router']->generate('PlanITBundle_burndownFeedback', array('idproject' => $project->getIdproject())); ?>">Burndown</a>
				&nbsp;|&nbsp;
				<a title="Gantt of the project" href="<?php echo $view['router']->generate('PlanITBundle_ganttFeedback', array('idproject' => $project->getIdproject())); ?>">Gantt</a>
				&nbsp;|&nbsp;
				<a title="PERT of the project" href="<?php echo $view['router']->generate('PlanITBundle_pertFeedback', array('idproject' => $project->getIdproject())); ?>">PERT</a>
				&nbsp;|&nbsp;
				<a class="dialog" title="Details of the project" rel="help" href="<?php echo $view['router']->generate('PlanITBundle_detailProject', array('idproject' => $project->getIdproject())); ?>">D&eacute;tails</a>
				&nbsp;|&nbsp;
				<a class="dialog" title="Edit a project" rel="section" href="<?php echo $view['router']->generate('PlanITBundle_editProject', array('idproject' => $project->getIdproject())); ?>">Edit</a>
				&nbsp;|&nbsp;
				<a class="dialog" rel="help" title="Delete project" href="<?php echo $view['router']->generate('PlanITBundle_delProject', array('idproject' => $project->getIdproject())); ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php if ( count($projects) <= 0) : ?>
		<tr>
			<td colspan="5" align="center">No project created</td>
		</tr>
		<?php endif; ?>
	</tbody>
	
</table>