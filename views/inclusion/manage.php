<table class="table">
	<thead>
		<tr>
			<th>Title</th>
			<th>Question</th>
			<th>Group</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($this->q_inclusion as $key => $value) { ?>
		<tr>
			<td><?php echo $value->campaign; ?></td>
			<td><?php echo $value->question; ?></td>
			<td><?php echo $value->group; ?></td>
			<td><?php echo $value->date_modified; ?></td>
			<td><a href="<?php echo $this->set_url("inclusion/delete_group/{$value->id}"); ?>">Delete</a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>