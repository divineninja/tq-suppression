<?php $summary = (ARRAY)$this->summary; ?>
<form action="<?php echo $this->set_url('dialer/uploadV2'); ?>" method="POST" enctype="multipart/form-data">
	<div class="form-group col-lg-9">
		<input type="file" name="leads" class="form-input input file-upload" />
	</div>
	<div class="form-group col-lg-3">
		<button class="btn btn-small btn-default">Upload</button>
	</div>
</form>

<br />
<hr />
<br />
<div class="col-lg-12">
	<p class="alert alert-warning">Files are uploaded by batch. If you wish to remove a dialer record, all records with same file name will be removed.</p>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th></th>
				<th>Path</th>
				<th>Total</th>
				<th>Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

			<tr>
				<td></td>
				<td colspan="3" style="text-align: right;"><strong>TOTAL</strong></td>
				<td><?php echo number_format(array_sum(array_column($summary, 'total'))); ?></td>
			</tr>

			<?php foreach($this->summary as $key => $value): ?>
				<?php $file = base64_encode($value->file_name); ?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $value->file_name; ?></td>
					<td><?php echo $value->total; ?></td>
					<td><?php echo $value->date_added; ?></td>
					<td><a href='<?php echo $this->set_url("dialer/remove_record/$file"); ?>'>Remove</a> | <a href='<?php echo $this->set_url("dialer/view_record/{$file}"); ?>'>View</a></td>
				</tr>
			<?php endforeach; ?>
		
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td colspan="3" style="text-align: right;"><strong>TOTAL</strong></td>
				<td><?php echo number_format(array_sum(array_column($summary, 'total'))); ?></td>
			</tr>
		</tfoot>
	</table>
</div>


<?php if($this->count > 0) { ?>
	<div class="col-lg-9">
		<p class="alert alert-danger">There are <?php echo number_format($this->count); ?> Records found, Do you wish to remove them all?</p>
	</div>
	<div class="col-lg-3">
		<a href="<?php echo $this->set_url('dialer/delete_dialer'); ?>" class="btn btn-small btn-danger warning">Remove all Content</a>
	</div>
<?php } else { ?>
	<p class="alert">There are <?php echo number_format($this->count); ?> Record[s] found.</p>
<?php } ?>

<script type="text/javascript">
	jQuery('document').ready(function($){
		
		// $('.data-table').dataTable();

		$('.warning').click( function(e) {
			e.preventDefault();

			var warning = confirm('Are you sure you want to delete all the content?');

			if(warning) {
				window.location = $(this).attr('href');
			}
		});		
	});
</script>