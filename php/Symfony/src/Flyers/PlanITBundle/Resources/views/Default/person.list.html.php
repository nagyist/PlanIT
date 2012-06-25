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
			<td><?php echo $person->firstname ?> <?php echo $person->lastname ?></td>
			<td><?php echo $person->mail ?></td>
			<td><?php echo $person->phone ?></td>
			<td><?php echo $person->salary ?></td>
			<td>
				<?php foreach ($person->jobs as $job) : ?>
					<?php echo $job->name; ?>
				<?php endforeach; ?>
			</td>
			<td><a href="/planIT/person/delete/<?php echo $person->id ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>