<div class="campaign_list col-lg-3">
	<ul>
	<?php
	foreach ($this->campaign as $value) {
	?>
		<li><a class="get_campaign" data-cmp="<?php echo $value->campaign; ?>" href="#"><?php echo str_replace('_', ' ', $value->campaign); ?></a></li>
	<?php
	}
	?>
	</ul>
</div>

<input type="hidden" id="fetch_url" value="<?php echo $this->set_url('inclusion/fetch'); ?>">
<input type="hidden" id="current_campaign" value="">
<div class="page-wrapper col-lg-6">
	<ul class="pagination_text"></ul>
	<div class="search-form-phone">
		<form class="form-inline">
			<div class="form-group">
				<input type="search" name="phone-search" class="form-control"/>
			</div>
				<button class="btn btn-default btn-small">Search</button>
		</form>
	</div>
</div>
<div class="phone_display col-lg-3">
	<table class="table data-table table-stripe">
		<thead>
			<th>Phone</th>
			<th>Question</th>
		</thead>
		<tbody>
			<tr>
				<td>Please select a campaign</td>
			</tr>
		</tbody>
	</table>
</div>