<div class="admin-main-page">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h3>Accounts</h3>
		<ul>
			<li><a href="<?php echo $this->set_url('agent'); ?>"><i class="fa fa-eye-slash"></i> Agents</a></li>
			<li><a href="<?php echo $this->set_url('user'); ?>"><i class="fa fa-user"></i> Users</a></li>
			<li><a href="<?php echo $this->set_url('survey'); ?>" class="show-survey"><i class="fa fa-desktop"></i> Survey Page</a></li>
		</ul>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h3>Maintenance</h3>
		<ul>
			<li><a href="<?php echo $this->set_url('group'); ?>"><i class="fa fa-group"></i> Groups</a></li>
			<li><a href="<?php echo $this->set_url('postal'); ?>"><i class="fa fa-location-arrow"></i> Postal</a></li>
			<li><a href="<?php echo $this->set_url('questions'); ?>"><i class="fa fa-question"></i> Questions</a></li>
			<li><a href="<?php echo $this->set_url('choices'); ?>"><i class="fa fa-pencil"></i> Choices</a></li>
		</ul>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h3>Reports</h3>
		<ul>
			<li><a href="<?php echo $this->set_url('reports'); ?>"><i class="fa fa-puzzle-piece"></i> Application QA</a></li>
			<li><a href="<?php echo $this->set_url('agent/monitoring'); ?>"><i class="fa fa-bullseye"></i> Agent Monitoring</a></li>
			<li><a href="<?php echo $this->set_url('application'); ?>"><i class="fa fa-money"></i> Application Revenue</a></li>
			<li><a href="<?php echo $this->set_url('reports'); ?>"><i class="fa fa-tasks"></i> Raw Revenue</a></li>
		</ul>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h3>Profile</h3>
		<ul>	
			<li><a href="#">Account Information</a></li>
			<li><a href="#">Edit Account</a></li>
			<li><a href="<?php echo $this->set_url('user/logout'); ?>">Logout</a></li>
		</ul>
	</div>
</div>
