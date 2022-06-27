<?php

$page = isset($_GET['page']) ? $_GET['page']: 1;
$phone = isset($_GET['phone']) ? $_GET['phone']: '';
$file = explode('/', $this->file);
?>
	<div class="col-lg-12">
		<p style="text-align: right;"><a href="<?php echo $this->set_url('dialer/indexv2'); ?>"><< Back</a> / FILE: <strong><?php echo $file[6]; ?></strong></p>
	</div>
	<div class="col-lg-12" style="margin-bottom: 10px;">
		<div class="col-lg-6">
			<form method="get" action="/">
				<input type="hidden" name="url" value="<?php echo $_GET['url'] ?>" class="form-control" placeholder="search for phone number" />
				<input type="text" name="phone" value="<?php echo $phone ?>" class="form-control" placeholder="search for phone number" />
			</form>
		</div>
		<div class="col-lg-6">
			<form method="get" action="/">
				<input type="hidden" name="url" value="<?php echo $_GET['url'] ?>" class="form-control" placeholder="search for phone number" />
				<select name="page" class="select-page form-control" style="width: 20%; float: right; text-align: center;">
					<?php for($i=0; $i < $this->pages; $i++) { ?>
						<option <?php echo ($i+1 == $page) ? 'selected': ''; ?>><?php echo $i+1; ?></option>
					<?php } ?>
				</select>
			</form>
		</div>
	</div>
	<br />
	<hr />

<div class="col-lg-12">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th></th>
				<th>Phone</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Address 1</th>
				<th>City</th>
				<th>Province</th>
				<th>Postal Code</th>
				<th>email</th>
				<th>Company Name</th>
				<!-- <th>Website</th>
				<th>Position</th> -->
				<th>Product Category</th>
				<th>Date Addedd</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>#</td>
				<td colspan="10" style="text-align: right;">Total</td>
				<td><?php echo number_format( $this->total ); ?></td>
			</tr>
			<?php foreach($this->records as $key => $value): ?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $value->phone_number; ?></td>
					<td><?php echo $value->first_name; ?></td>
					<td><?php echo $value->last_name; ?></td>
					<td><?php echo $value->address1; ?></td>
					<td><?php echo $value->city; ?></td>
					<td><?php echo $value->province; ?></td>
					<td><?php echo $value->postal_code; ?></td>
					<td><?php echo $value->email; ?></td>
					<td><?php echo $value->company; ?></td>
					<!-- <td><?php echo $value->website; ?></td>
					<td><?php echo $value->position; ?></td> -->
					<td><?php echo $value->product_category; ?></td>
					<td><?php echo $value->date_added; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>




<script>
	console.log(jQuery)
	jQuery(document).ready(function(){
		$(document).on('change', '.select-page', function(){
			
			$(this).parent().trigger('submit')
		});
	})
</script>