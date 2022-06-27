<?php  echo $this->create_form( $this->set_url('campaign/save') ); ?>
	<table class="table">
		<tr>
			<td>Campaign Name: </td>
			<td><input type="text" placeholder="crm Itech" name="name" class="required" required="required" /></td>
		</tr>
		<tr>
			<td>Database: </td>
			<td><input type="text" placeholder="crm" name="database" class="required"  required="required" /></td>
		</tr>
		<tr>
			<td>Username: </td>
			<td><input type="text" placeholder="root" name="username" class="required"  required="required" /></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td><input type="password" placeholder="null" name="password" class="required"  required="required" /></td>
		</tr>
	</table>
<?php echo $this->end_form(); ?>