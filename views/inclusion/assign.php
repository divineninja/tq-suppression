
<!-- Suppression insert new record form -->
<?php require_once dirname(__FILE__).'/assign/form.php'; ?>

<!-- inclusion tabled list -->
<?php require_once dirname(__FILE__).'/assign/list.php'; ?>

<script>
	jQuery(document).ready(function(){
		$('.inclusion_upload').submit( function(){
			$('.inclusion_upload').append('<div class="loading-text"><i class="fa fa-spin fa-spinner"></i> Loading time varies upon the size of the file uploaded...</div>');
		});

		$('.delete-button').click( function() {
			$('.inclusion_upload').append('<div class="loading-text-delete"><i class="fa fa-spin fa-spinner"></i> System is removing all data in the database.</div>');
		});

		$('.pop-questions').change( function(){
			var campaign = $(this).val();
			if(campaign == "") return;
			
			//CRM.questions_api.php
			var url = "<?php echo $this->set_url('inclusion/questions_api'); ?>";
			var data = {username: campaign};
			
			console.log(url);

			$('.questions-select').html('<option class="notif-load">Loading Questions Please wait.....</option>');

			$.ajax({
	            url: url,
	            type: 'POST',
	            data: data,
	            dataType:'json',
	            success: function(response){
	                $.each(response, function(key, value){
	                	$('.questions-select').append('<option value="'+value.id+'">'+value.code +" - "+ value.question+'</option>');
	                });
	            },
	            done: function(done){
	                console.log(done)
	                $('.notif-load').html('Select Question');
	            },
	            error: function(error){
	                console.log(error)
	            }
	        });

	        $('.notif-load').html('Select Question');
		});

		$(document).on('click', '.delete-qs', function(e){
			e.preventDefault();

			var confirmation = confirm("Are you sure you want to delete?");

			if(!confirmation) return false;

			var url = $(this).attr('href');

			var _this = this;

			$.get(url, function(response){

				if(response == "") {
					$(_this).parent().parent().hide(function(){
						$(this).remove();
					})	
				}
			});

		});

		$('.show-campaign-table').change( function(){
			var campaign = $(this).val();

			if(campaign == "") return;

			var url = "<?php echo $this->set_url('inclusion/get_inclusion_list'); ?>/"+campaign;
			
			$.ajax({
	            url: url,
	            type: 'GET',
	            success: function(response){
					$('.table-list').html(response);
	            }
	        });

		});
	});
</script>
