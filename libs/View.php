<?php

class View extends Database{
	var $super_admin = array(
	    'developer',
	    'admin',
	    'Admin'
	);
    function __construct() {
       // echo 'this is the view <br />';
    }
	
    public function render($name, $noInclude = false, $sidebar = false ){
        if($noInclude == true){            
            require 'views/' . $name . '.php';            
        }else{            
            require 'views/header.php';
			
			if( $sidebar ){
					echo '<div class="col-lg-2">';
				require 'views/left.php';
					echo '</div><div class="col-lg-10 '.$name.' ">';
				require 'views/' . $name . '.php';
					echo '</div>';
			}else{
				require 'views/' . $name . '.php';
			}
			
            require 'views/footer.php';
        }
    }
	
	/*
	 * Create a open form
	 * 
	 */
	public function create_form( $action = '', $class="submit", $method = 'POST', $enctype = false ){
		$type = ( $enctype == true ) ? 'enctype="multipart/form-data"': '';
		return "<form action='$action' id='submit' class='$class' method='$method' $type >";
	}
	/*
	 * end form
	 *
	 */
	 
	public function end_form(){
		return '</form>';
	}
	
	public function get_active(){
		return $_GET['url'];
	}
	
	/*for questions*/
	public function setup_children($children){
		foreach($children as $child){
			?>
			<div data-condition="<?php echo $child->condition; ?>" data-answer="<?php echo $child->expected_answer; ?>" class="child_question child_answer_<?php echo $child->expected_answer; ?> data_condition_<?php echo $child->condition; ?>  question_<?php echo $child->id; ?>">
				<div class="survey-start">
					<p class="crm-enlarge col-lg-9"><?php echo $child->question; ?></p>
					<div class="input-group col-lg-3">
						<input type="hidden" name="question[]" value="<?php echo $child->id; ?>" />
						<?php if($child->choices){ ?>
						<select data-condition="<?php echo $child->condition; ?>" data-conditional-answer="<?php echo $child->condition_answer; ?>" class="form-control select_answer" name="answer[]">
							<option value="">--Select--</option>
							<?php foreach($child->choices as $choice){ ?>
								<option value="<?php echo $choice->choices_id; ?>"><?php echo $choice->label; ?></option>
							<?php } ?>
						</select>
						
						<?php }else{ ?>
							<input type="text" name="answer[]" class="form-control"/>
						<?php } ?>
					</div>
					<?php 	
					if($child->child){
						$this->setup_children($child->child);
					} ?>
				</div>
			</div>
			<?php
		}
	}
	/*for questions*/
	
	public function set_up_postal_codes($postal,$codes,$count = 0){	
		$class = ($count == 0)?'col-lg-12':'col-lg-4';
		$count++;
		foreach($postal as $item){
			$parent = ($item->children)?'parent':'not-parent';
			$active = (in_array($item->postal_id,$codes))?'checked="checked"':'';
			?>
			<div class="<?php echo $class; ?>">
				<?php  ?>
				<p><input type="checkbox" <?php echo $active; ?> class="<?php echo $parent; ?>" name="postal[]" value="<?php echo $item->postal_id; ?>"/> <label><?php echo $item->name; ?></label></p>
				<?php
					if($item->children){ 
						$this->set_up_postal_codes($item->children,$codes,$count);
					} 
				?>
			</div>
			<?php
		}
	}
	
	
	/*for set the active state*/
	public function set_selected($param1,$param2){
		if($param1 == $param2){
			return 'selected="selected"';
		}
		return '';
	}
	public function set_checked($param1,$param2){
		if($param1 == $param2){
			return 'checked="checked"';
		}
		return '';
	}
	
	public function compare_by_array($str, $array){
		var_dump(in_array($str,$array));
		if(in_array($str,$array)){
			return 'selected="selected"';
		}
		return '';
	}
	
	
	public function show_status($status){	
		if($status == 1){
			return "Enabled";
		}else if($status == 0){
			return "Disabled";
		}else if($status == 2){
			return "Hidden";
		}else if($status == 3){
			return "Forced";
		}
	}

}
