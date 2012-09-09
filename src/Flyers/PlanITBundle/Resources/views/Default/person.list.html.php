<table>
	<thead>
		<th>Name</th>
		<th>Email address</th>
		<th>Phone number</th>
		<th>Salary</th>
		<th>Job(s)</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach( $persons as $person) : ?>
		<tr>
			<td align="center"><?php echo $person->getFirstname() ?> <?php echo $person->getLastname() ?></td>
			<td align="center"><?php echo $person->getMail() ?></td>
			<td align="center"><?php echo $person->getPhone() ?></td>
			<td align="center"><?php echo $person->getSalary() ?></td>
			<td align="center"><?php echo $person->getJob()->getName() ?></td>
			<td align="center">
				<a class="dialog" title="Edit an employee" rel="section" href="<?php echo $view['router']->generate('PlanITBundle_editPerson', array('idperson' => $person->getIdperson())); ?>">Edit</a>
				&nbsp;|&nbsp;
				<a href="<?php echo $view['router']->generate('PlanITBundle_delPerson', array('idperson' => $person->getIdperson())); ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php if ( count($persons) <= 0) : ?>
		<tr>
			<td colspan="6" align="center">No employees added</td>
		</tr>
		<?php endif; ?>
	</tbody>
	
</table>