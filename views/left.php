<?php 

/**
 * Left navigation
 *
 *
 */

?>

<ul class="nav nav-pills nav-stacked">
    <li>DIALER</li>
	<!-- <li><a href="<?php echo $this->set_url('dialer'); ?>">Dialer</a></li> -->
	<li><a href="<?php echo $this->set_url('dialer/indexv2'); ?>">Upload</a></li>

    <li>-----------------------------------------</li>
    <li>SUPPRESSION</li>
    <li><a href="<?php echo $this->set_url('suppression'); ?>">Upload</a></li>
    <li><a href="<?php echo $this->set_url('suppression/assign'); ?>">Assign</a></li>
    <li><a href="<?php echo $this->set_url('suppression/files_with_error'); ?>">Files With Error</a></li>


    <li>-----------------------------------------</li>
    <li>INCLUSION</li>
    <li><a href="<?php echo $this->set_url('inclusion'); ?>">Upload</a></li>
    <li><a href="<?php echo $this->set_url('inclusion/assign'); ?>">Assign</a></li>
    <li><a href="<?php echo $this->set_url('inclusion/files_with_error'); ?>">Files With Error</a></li>

    <li>-----------------------------------------</li>
    <li><a href="<?php echo $this->set_url('user/logout'); ?>">Logout</a></li>
</ul>
