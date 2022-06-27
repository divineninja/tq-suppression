<?php echo $this->create_form( $this->set_url('campaign/update_object') ); ?>
<table class="table">
		<tr>
			<td>Campaign Name: </td>
			<td><input type="text" placeholder="crm Itech" name="name" class="required" required="required" value="<?php echo $this->item->name; ?>"/></td>
		</tr>
		<tr>
			<td>Database: </td>
			<td><input type="text" placeholder="crm" name="database" class="required" readonly="readonly"  required="required" value="<?php echo $this->item->database; ?>"/></td>
		</tr>
		<tr>
			<td>Username: </td>
			<td><input type="text" placeholder="root" name="username" class="required"  required="required" value="<?php echo $this->item->username; ?>"/></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td><input type="password" placeholder="null" name="password" value="<?php echo $this->item->password; ?>"/></td>
		</tr>
	</table>
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>">
<?php echo $this->end_form(); ?>