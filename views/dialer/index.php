<form action="<?php echo $this->set_url('dialer/upload'); ?>" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label>Select Leads</label>
		<input type="file" name="leads" class="form-input input" />
	</div>

	<div class="form-group">
		<button class="btn btn-small btn-default">Upload</button>
	</div>


</form>

<div class="col-lg-12">

	<?php if($this->count > 0) { ?>
		<p class="alert">There are <?php echo $this->count; ?> Records found, Do you wish to remove them all?</p>

		<a href="<?php echo $this->set_url('dialer/delete_dialer'); ?>" class="btn btn-small btn-danger warning">Remove all Content</a>
	<?php } else { ?>
		<p class="alert">There are <?php echo $this->count; ?> Record found.</p>
	<?php } ?>
</div>

<script type="text/javascript">
	
	jQuery('document').ready(function($){

		$('.warning').click( function(e) {
			e.preventDefault();

			var warning = confirm('Are you sure you want to delete all the content?');

			if(warning) {
				window.location = $(this).attr('href');
			}
		})
	})
	
</script>