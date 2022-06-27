<div class="col-lg-12">
	<table class="table dataTable">
		<thead>
			<th>File Name</th>
			<th>Count</th>
			<th>Date Uploaded</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<?php foreach ($this->files as $key => $value) { ?>
				<tr>
					<td><?php echo $value->file_name; ?></td>
					<td><?php echo $value->count; ?></td>
					<td><?php echo $value->date_modified; ?></td>
					<td>
						<a class="delete-item" href="<?php echo $this->set_url("suppression/deleteUploadFile/{$value->id}"); ?>">Delete</a>
					</td>
				</tr>
			<?php } ?>		
		</tbody>
	</table>
</div>

<div class="col-lg-12">
	<form method="POST" class="supression_upload" action="<?php echo $this->set_url('suppression/saveSupression'); ?>" enctype="multipart/form-data">
		<div class="alert alert-warning">
			<span>Supression file must be ".txt", and only phone numbers are in the file.</span><br/>
			<span>Important to limit the one milion (1,000,000) phone numbers per file, to ensure that all phone numbers will be stored in the database. </span>
		</div>
		<div class="form-group">
			<label>Attach your .txt file here</label>
			<input type="hidden" class="form-control" name="question_id" required="required" value="<?php echo $this->question_id; ?>" />
			<input type="file" class="form-control" name="supression_file" required="required" accept=".txt" />
		</div>
			<button class="btn-small btn btn-default">Save</button>
			<!-- <a href="<?php echo $this->set_url('suppression/truncate'); ?>" class="btn-small btn btn-default btn-danger">Delete All Content</a> -->
	</form>
</div>