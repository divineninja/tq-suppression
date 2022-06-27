<div class="col-lg-3">
	<div class="form-group">
		<label>Choose campaign to show</label>
		<select name="campaign" class="form-control show-campaign-table" required="required">
				<option value=""> -- SELECT -- </option>
			<?php foreach ($this->campaigns as $key => $value) { ?>
				<option value="<?php echo $value['database']; ?>"><?php echo $value['name']; ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="col-lg-3"></div>
<div class="col-lg-12 table-list">
	<table class="table">
		<thead>
			<th>File Name</th>
			<th>Count</th>
			<th>Date Modified</th>
			<th>Actions</th>
		</thead>
		<tbody><tr><td colspan="4">Please select from the campaign to show the content here...</td></tr></tbody>
	</table>
</div>