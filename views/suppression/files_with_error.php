<table class="table">
	<thead>
		<tr>
			<th>File Name</th>
			<th>Number of Error Phone Numbers</th>
			<th>Download</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($this->items_with_error as  $files) { 
		$file_link = str_replace('/var/www/', '', $files->file_name);
		$display_link = str_replace('/var/www/uploads/dialer/', '', $files->file_name);
		$file_value = base64_encode($files->file_name);
	?>
		<tr>
			<td><?php echo $display_link;?></td>
			<td><?php echo $files->phone_number_total; ?></td>
			<td>
				<a href="<?php echo $this->set_url($file_link); ?>" target="_blank"><button class="btn btn-xs btn-small btn-default">Download</button></a>
				<a href="<?php echo $this->set_url("suppression/errorFiles/$file_value"); ?>" ><button class="btn btn-xs btn-small btn-warning">Phone Numbers</button></a>
				
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php
	if( isset($this->phone_with_error)) {
		?>
		<h3><?php echo str_replace('/var/www/uploads/dialer/', '', $this->file_name); ?></h3>
		<table class="table">
			<thead>
				<th>#</th>
				<th>Phone</th>
			</thead>
		<?php
		foreach($this->phone_with_error as $key => $phones){
			?>
			<tr>
				<td><?php echo $key+1; ?></td>
				<td><?php echo $phones->phone_number; ?></td>
			</tr>
			<?php
		} ?>
		</table>
	<?php
	}
?>