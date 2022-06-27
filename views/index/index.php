<?php if( !isset($_SESSION['logged_in'] ) ){ ?>
    <div class="col-lg-6 col-lg-offset-2">
    	<div class="col-lg-4">
    		<a class="show-login-form btn btn-large btn-default" href="<?php echo $this->set_url('user/user_login') ?>">Campaign User</a>
        </div>
        <div class="col-lg-8">  
            <div class="content">
                <p><b>Site Administrator</b> Login has been remove, It is now accessible using your current login and can be found right before logout button.</p>
            </div>
        </div>
	</div>
<?php }else{ ?>
	<div style="text-align:center;">
		<p>You are currently logged in as <strong>"<?php echo $_SESSION['user_data']->role; ?>"</strong></p>
		<h1>Welcome <?php echo $_SESSION['user_data']->first_name.' '.$_SESSION['user_data']->last_name; ?></h1>
        <div class="admin-main-page">
            <div class="col-lg-12 col-md-12col-sm-12 col-xs-12">
                <h3>Accounts</h3>
                <ul>
                <?php if(in_array(strtolower($_SESSION['role']), $this->super_admin)) { ?>
                    <li><a href="<?php echo $this->set_url('suppression') ?>"><i class="fa fa-list"></i> Suppression</a></li>
                <?php } ?>
                    <li><a href="<?php echo $this->set_url('user/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </div>
        </div>
	</div>
<?php } ?>
