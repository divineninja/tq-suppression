<table class="table">
	<thead>
		<th>File Name</th>
		<th>Count</th>
		<th>Date</th>
		<th>Qcode</th>
		<th>Actions</th>
	</thead>
	<tbody>
	<?php if(count($this->campaigns)) { ?>
		<?php foreach ($this->campaigns as $key => $value) { ?>
			<tr>
				<td><?php echo $value->file_name; ?></td>
				<td><?php echo $value->count; ?></td>
				<td><?php echo $value->date_modified; ?></td>
				<td><?php echo $this->questions[$value->question]->code; ?></td>
				<td>
					<a class="delete-qs" href="<?php echo $this->set_url('suppression/delete_qs'); ?>/<?php echo $value->qsid; ?>">Delete</a>
					| <a target="_blank" href="<?php echo URL."uploads/suppression/{$value->file_name}"; ?>">Download</a>
				</td>
			</tr>
		<?php } ?>
	<?php }else{ ?>
		<tr><td colspan="4">No records found, Please select another campaign...</td></tr>
	<?php } ?>
	</tbody>
</table>