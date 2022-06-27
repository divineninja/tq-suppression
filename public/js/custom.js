jQuery( document ).ready( function( $ ){
	
	$('.datepicker').datepicker();
	var modalContainer = $( '#modal_form' );
	var modalContent = modalContainer.find('.modal-body');
	
	function get_ids( ids ){
		var data = [];
		$.each( ids, function(key,value) {
			if($(this).attr('checked')){
				data.push($(this).val());
			}
		});
		return data;
	}
	
	function disable_all_inputs(){
		$('.crm-first-part').find('input').attr('disabled','disabled');
		$('.crm-first-part').find('select').attr('disabled','disabled');
		$('.crm-first-part').find('button').attr('disabled','disabled');
		$('.crm-first-part').find('.customer-phone').removeAttr('disabled');
	}
	
	function enable_all_inputs(){
		$('.crm-first-part').find('input').removeAttr('disabled');
		$('.crm-first-part').find('select').removeAttr('disabled');
		$('.crm-first-part').find('button').removeAttr('disabled');
	}
	
	// disable all inputs on ;load
	disable_all_inputs();
	
	
	$( '#show_add_item, .show_add_item' ).click( function(){
		modalContainer.modal( 'show' );
		modalContainer.find('.modal-body').html('Loading content please wait');
		var member_form_uri = $(this).data('url');
		var title = $(this).data('title');
		if(title==""){ title = "Register"; }else{ title = "Register " + title;}
		if( !title ){
			title = '';
		}	
			$.get( member_form_uri, function(response){
				modalContainer.find('.modal-title').html(title);
				modalContent.html( response );
			});
	});

	$( '.edit_item' ).click( function(){		
		
		var ids = get_ids( $('.item_id') );
		if( ids.length == 1 ){
			modalContainer.find('.modal-body').html('Loading content please wait');
			var member_form_uri = $(this).data('url')+'/'+ids['0'];
			modalContainer.modal( 'show' );
			$.get( member_form_uri, function(response){
				modalContainer.find('.modal-title').html('Edit');
				modalContent.html( response );
			});
		}else{
			alert('Please select only 1 item.')
		}
	});
	
	$( '.edit_calibration' ).click( function(){		
		
		var id = $(this).attr('id');
		modalContainer.find('.modal-body').html('Loading content please wait');
		var member_form_uri = $(this).data('url')+'/'+id;
		modalContainer.modal( 'show' );
		
		$.get( member_form_uri, function(response){
			modalContainer.find('.modal-title').html('Calibrate');
			modalContent.html( response );
		});
	});
	
	/*
	 * Delete Members
	 * 
	 */
	$( '.delete_item' ).click( function(){
		var ids = $('.item_id');		
		var delete_url = $(this).data('url');
		var data = get_ids(ids);

		// stop process if there is no selected item
		if( data.length < 1 ) return;

		// show confirm modal box
		var confirmation = confirm('Are You Sure you want to delete this items?');

		if( !confirmation ) return;

		$.ajax({
			url: delete_url,
			data: {ids: data},
			type: 'POST',
			success: function(response){
				$.each( data, function(key,value){
					$('#item-'+value).parent().parent().fadeOut( function(){
						$(this).remove();
					})
				});
			},
			done: function(done){
				console.log(done)
			},
			error: function(error){
				console.log(error)
			}
		})
	});

	$(document).on( 'click', '#save_setting_modal', function(){
		modalContent.find('form').submit();
	});
	
	$( document ).on( 'submit', '.modal-body form#submit', function(e){
		e.preventDefault();
		var error = 0;
		var inputs = $( this ).find('.required');
			$.each( inputs, function(key,value){
				if( $( this).val() == '' ){
					$( this ).addClass('error');
					error++;
				}else{
					$( this ).removeClass('error')
				}
			});
			
			if( error == 0 ){
				// submit to the form
				var url = $(this).attr('action');
				var data = $( this ).serialize();
				$('#save_setting_modal').html('Loading...');
				$.post( url, data, function( response ){
					alert( response.message );
					$('#save_setting_modal').html('Save Changes');
				},'json') ;
			}
	});
	
	$( document ).on( 'submit', '.form_submit', function(e){
		e.preventDefault();
		var url = $(this).attr('action');
		var data = $( this ).serialize();
		$('.login-message').html('').addClass('hide')
		$.post( url, data, function( response ){
			$('.login-message').html( response.message ).removeClass('hide');
			 if( response.code == 200 ){
				setTimeout( function(){
					window.location = response.redirect;
				}, 600 );
			 }
		},'json') ;
	});
	
	$( document ).on( 'submit', '.crm-submit', function(e){
		e.preventDefault();
		var url = $(this).attr('action');
		var data = $( this ).serialize();
		$.post( url, data, function( response ){
			 if(response.reload){
				setTimeout( function(){
					window.location.reload();
				}, 600 )
			 }else if(response.code == 200){
				if(response.redirect == false){
					// window.location.reload();
				}else{
					if(response.last == 0){
						window.location = response.redirect;
					}else{
						alert(response.message);
						self.close(); 
					}
					/* 
						alert(response.message);
						self.close(); 
					*/
				}
				alert(response.message);
			 }
		},'json') ;
	});
	
	
	$( document ).on( 'submit', '.crm-submit-item', function(e){
		e.preventDefault();
		var url = $(this).attr('action');
		var data = $( this ).serialize();
		$.post( url, data, function( response ){		
			console.log(response)
			 if(response.reload){
				setTimeout( function(){
					window.location.reload();
				}, 600 )
			 }else if(response.code == 200){
				if(response.redirect == false){
					// window.location.reload();
				}else{
					window.location = response.redirect;
				}
				alert(response.message);
			 }
		},'json') ;
	});
	
	$(document).on('click','.btn-disposition', function(e){
		e.preventDefault();
		var validate = confirm('Are you sure you want to dispose this application?');
		if(validate){
			$('.crm-submit').attr('action',$(this).attr('data-url'));
			$('.crm-submit').submit()
		}
	})

	$(document).on('change', '.first_name, .last_name', function(){
		$( '.display_name' ).val( $('.first_name').val() + ' ' +  $('.last_name').val())
	});
	
	var table = $('.dataTable');

	if( table.length ){
		$('.dataTable').dataTable({
        	"aLengthMenu": [[15, 20, -1], [15, 20, "All"]]
    	});
	}
	

    $(document).on('click','.btn-google', function(e){
		e.preventDefault();		
		window.location = google_url;
    });
	
	function closemodal(){
		$('.login-modal').fadeOut();
		$('.login-mask').fadeOut();
	}
	
	function showmodal(){
		$('.login-modal').fadeIn();
		$('.login-mask').fadeIn();
	}
	
    $('.show-login-form').click( function(e){
    	e.preventDefault();
			showmodal();
    	$.get( $(this).attr('href'), function(response){
    		$('.login-modal').html(response)
    	})
    });
	
	$('.login-mask').click( function(){
		closemodal();
	});
	
	$(document).on('mouseover','.crm-enlarge', function(){
		$(this).parent().prepend('<div class="large-question">'+$(this).html()+'</div>')
		var height = $('.large-question').height()
		$('.large-question').css('top',-20-height);
	})
	
	$(document).on('mouseleave','.crm-enlarge', function(){
		$('.large-question').remove();
	})
	
	$(document).on('change', '.select_answer', function(){
		if($(this).data('role') == 'parent'){
			var url = site_url  + 'survey/get_child/';
			var id = $(this).data('qid');
			var answer = $(this).val();
			
			$('.child_'+id+'_container').html('');
			if(answer == ""){return}
			$.ajax({
				url: url+id+'?answer='+answer,
				type: "GET",
				success: function(response){
					$('.child_'+id+'_container').html(response).addClass('highlight');
					setTimeout( function(){		
						$('.child_container').removeClass('highlight');			
					},400);	
				}
			});
		}
	});

	$(document).on('change', '.question-choices', function(){
		var selected = $(this).val();
		$('.conditional_answer').html('');
		$('.paid_response_answer').html('');
		var options = $('.question-choices').find('option');
			$('.conditional_answer').append('<option value="0">Any Answer</option>')
		$.each(options,function(){
			if( jQuery.inArray($(this).val(),selected) >= 0 ){
				$('.conditional_answer').append('<option value="'+$(this).val()+'">'+$(this).html()+'</option>')
				$('.paid_response_answer').append('<option value="'+$(this).val()+'">'+$(this).html()+'</option>')
			}
		})
	});
	
	$(document).on('click', '.btn-show-addition', function(e){
		e.preventDefault();
		$('.child-container-form').append($('.parent-container-form').html());
	});
	
	$(document).on('click', '.remove-parent-form', function(e){
		e.preventDefault();
		$(this).parent().parent().remove();
	});
	
	$('.btn-submit-form-configure').click( function(e){
		e.preventDefault();
		$('.crm-submit').submit();
	});
	
	$(document).on('change','.question-selected',function(){
		var id = $(this).val();
		var url = $(this).attr('data-url');
		var list = $(this).parent().parent().find('.choices-list');
		$(list).html("<option value=''>SELECT ANSWER</option>");
		$.ajax({
			url: url+'/'+id,
			type: 'GET',
			dataType:'json',
			success: function(response){
				$.each(response, function(){
					$(list).append('<option value="'+this.choices_id+'" >'+this.label+'</option>')
				})
			},
			done: function(done){
				console.log(done)
			},
			error: function(error){
				console.log(error)
			}
		})
	});
	
	$(document).on('click','.enable-manual',function(){
		enable_all_inputs();
	});
	$(document).on('click','.find-customer',function(){
		var id = $('.customer-phone').val();
		if(id == '') {alert('Phone Number is Required'); return;}
		var url = $(this).attr('data-url');
		var validate = $(this).attr('data-validate');
		var url = url+''+id;
		$.post(validate,{phone:$('.customer-phone').val()},function(response){
			if(response.code == 400){
				var confirmation = confirm(response.message);
				if(confirmation){
					populate_data(url);
				}
			}else{
				populate_data(url);
			}
			console.log(response);
		},'json');
		
	});
	
	function populate_data(url){
		
		$.ajax({
			url: url,
			type: 'GET',
			jsonp: "callback",
			jsonpCallback: "callback_function",
			dataType: "jsonp",
			success: function(crm_response){
			if(crm_response.code == "404"){
				alert("Phone number not found. Please input the customer info manually. \n\nThanks\nCRM Administrator");
				enable_all_inputs();
			}else{
				var response = crm_response.leads;
				$('input[name="post_code"]').val(response.postal_code);
				$('input[name="country"]').val(response.province);
				$('select[name="title"]').val(response.title);
				$('input[name="first_name"]').val(response.first_name);
				$('input[name="last_name"]').val(response.last_name);
				$('input[name="address1"]').val(response.address1);
				$('input[name="address2"]').val(response.address2);
				$('input[name="address3"]').val(response.address3);
				$('input[name="town"]').val(response.city);
				$('input[name="gender"]').val(response.gender);
				$('input[name="urn_original"]').val(response.comments);
				$('.post-code-text').html(response.postal_code);
				$('.first-name-text').html(response.first_name)
				$('.last-name-text').html(response.last_name);
				$('.address-text').html(response.address1);
				$('.county').html(response.province)
				enable_all_inputs();
				}
			},
			done: function(done){
				
			},
			error: function(error){
				console.log(error)
			}
		})
	}
	
	
	
	$(document).on('click','.show-question-list', function(e){	
		e.preventDefault();
		$('.question-form').slideToggle();
	});
	
	$(document).on('click','.btn-add-new-child-condition', function(e){	
		var parent_child = $('.parent-control-child-condition').html()
		$('.child-condition-list').append(parent_child);
	});
	
	$(document).on('change','.post-code-select', function(){
		if(!$(this).val()) return;
		$.ajax({
			url: $(this).val(),
			type: 'GET',
			success: function(response){
				$('.question-list').html(response);
			},
			done: function(done){
			},
			error: function(error){
				console.log(error)
			}
		})
		
	});
	
	$(document).on('click', '.delete-item', function(e){
		e.preventDefault();
		var confirmation = confirm("are your sure you want to delete?");		
		if(!confirmation) return;		
		var _this = $(this);
		var url = $(this).attr('href');
		$.post( url, function(response){
			$(_this).parent().parent().fadeOut(function(){
				$(this).remove();
			});
		},'json');
	});
	
	$(document).on('click', '.delete-condition-question', function(e){
		
		e.preventDefault();
		var confirmation = confirm("are your sure you want to delete?");		
		if(!confirmation) return;
		var _this = $(this);
		var url = $(this).attr('href');
		
		$.post( url, function(response){
			if(response.code == 200){
				$(_this).parent().parent().fadeOut(function(){
					$(this).remove();
				});
			}
		},'json');
	});
	
	$('.post-code').blur(function(){ 	$('.post-code-text').html($(this).val());		})
	$('.first-name').blur(function(){ 	$('.first-name-text').html($(this).val());		})
	$('.last-name').blur(function(){ 	$('.last-name-text').html($(this).val());		})
	$('.address').blur(function(){ 		$('.address-text').html($(this).val());			})
	
	$(document).on('click','.save_order', function(e){
		e.preventDefault();
		$('#question_order').submit();
	})
	
	$(document).on('submit','#question_order', function(e){
		e.preventDefault();
		var url = $(this).attr('action');
		var data = $(this).serialize();
		$.post(url,data, function(response){
			console.log(response);
		});
	});
	
	$(document).on('submit','.form-session', function(e){
		e.preventDefault();
		var data = $(this).serialize();
		console.log(data);
		window.retrieve_url = window.orig_url + '?' +data;
		retrieve_data(retrieve_url);
	});
	
	$(document).on('click','.show-survey',function(e){
		e.preventDefault();		
		window.open($(this).attr('href'),'Agent CRM', 'left=0,top=0,width='+$(document).width()+',height='+$(document).height()+',toolbar=1,resizable=1');
	});


	$(document).on('click', '.get_campaign', function(){
		var campaign = $(this).data('cmp');

		$('.get_campaign').removeClass('current');
		$(this).addClass('current');
		
		$('#current_campaign').val(campaign);
		var url = $('#fetch_url').val();
		
		url = url + '/' + campaign;

		$('.phone_display').find('.table tbody').html('Loading...');
		$('.pagination_text').html('<li>Loading...</li>');

		$.get(url, function(response) {		
			$('.pagination_text').html('')
			var pages = response.pages;
			var page = 0;
			for (var i = 0; i <= pages; i++) {
				page = i + 1;
				$('.pagination_text').append('<li><a href="#" class="page" data-page="'+page+'">'+page+'</a></li>');
			};

			$('.phone_display').find('.table tbody').html('')
			var table = $('.phone_display').find('.table');

			$.each(response.details, function(key, value){

				$(table).find('tbody').append('<tr><td>'+value.phone+'</td><td>'+value.question_id+'</td></tr>');
			});

		}, 'json');
	});

	$(document).on('click', '.page', function(){
		$('.page').removeClass('current');
		$(this).addClass('current');
		var campaign = $('#current_campaign').val();

		var page = $(this).data('page');

		var url = $('#fetch_url').val();
		
		url = url + '/' + campaign + '?page='+page;
		$('.phone_display').find('.table tbody').prepend('<tr><td colspan="2">Loading...</td></tr>');
		$.get(url, function(response) {

			$('.phone_display').find('.table tbody').html('')
			var table = $('.phone_display').find('.table');

			$.each(response.details, function(key, value){

				$(table).find('tbody').append('<tr><td>'+value.phone+'</td><td>'+value.question_id+'</td></tr>');
			});

		}, 'json');
	});
	
	
	
});

