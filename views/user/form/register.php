<?php echo $this->create_form( $this->set_url('user/save') ); ?>
<table class="table">
	<tr>
		<td>First Name: </td>
		<td><input type="text" name="first_name" class="required" required="required" /></td>
	</tr>
	<tr>
		<td>Last Name: </td>
		<td><input type="text" name="last_name" class="required"  required="required" /></td>
	</tr>	
	<tr>
		<td>Phone: </td>
		<td><input type="text" name="phone" class="required"  required="required" /></td>
	</tr>
	<tr>
		<td>Role: </td>
		<td><input type="text" name="role" class="required"  required="required" /></td>
	</tr>
	<tr>
		<td>Password: </td>
		<td><input type="password" name="password"/></td>
	</tr>
	<tr>
		<td>Verify Password: </td>
		<td><input type="password" name="vpassword"/></td>
	</tr>
</table>
<?php echo $this->end_form(); ?>