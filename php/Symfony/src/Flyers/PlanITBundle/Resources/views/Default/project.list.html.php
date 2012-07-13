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
				<a class="dialog" title="Details of the project" rel="help" href="<?php echo $view['router']->generate('PlanITBundle_detailProject', array('idproject' => $project->getIdproject())); ?>">D&eacute;tails</a>
				&nbsp;|&nbsp;
				<a class="dialog" title="Edit a project" rel="section" href="<?php echo $view['router']->generate('PlanITBundle_editProject', array('idproject' => $project->getIdproject())); ?>">Edit</a>
				&nbsp;|&nbsp;
				<a href="<?php echo $view['router']->generate('PlanITBundle_delProject', array('idproject' => $project->getIdproject())); ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>