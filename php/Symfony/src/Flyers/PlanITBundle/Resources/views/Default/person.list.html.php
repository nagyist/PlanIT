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
			<td align="center"><a href="/planIT/person/delete/<?php echo $person->getIdperson() ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>