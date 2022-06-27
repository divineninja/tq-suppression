<div class="col-lg-12">
	<form method="POST" class="inclusion_upload" action="<?php echo $this->set_url('inclusion/question_inclusion'); ?>">
	<div class="col-lg-3">
		<div class="form-group">
			<label>Campaign</label>
			<select name="campaign" class="form-control pop-questions" required="required">
					<option value=""> -- SELECT -- </option>
				<?php foreach ($this->campaigns as $key => $value) { ?>
					<option value="<?php echo $value['database']; ?>"><?php echo $value['name']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="form-group">
			<label>Questions</label>
			<select name="question" class="form-control questions-select" required="required">
				<option value=""> -- SELECT -- </option>
				<option value="0" disabled="disabled">Questions are empty....</option>
			</select>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<label>Suppression File</label>
			<select name="inclusion[]" class="form-control" multiple="multiple" required="required" style="height:200px">
				<option value="" disabled="disabled"> -- SELECT -- </option>
				<?php foreach ($this->inclusion_file as $key => $value) { ?>
					<option value="<?php echo $value->ID; ?>"><?php echo $value->file_name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-lg-offset-6 col-lg-3">
		<p><button class="btn btn-default btn-small" type="submit">Add To List</button></p>
	</div>
	</form>
</div>


<?php
 /*$params = array(
                'username' => 'telesolutions_energy_helpline',
                'phone' => '2086567918',
                'question' => '21'
            );
        echo base64_encode(json_encode($params));
*/
?>