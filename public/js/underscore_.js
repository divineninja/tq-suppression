jQuery(document).ready(function($){	
	var modalContainer = $( '#modal_form' );
	var modalContent = modalContainer.find('.modal-body');
	
	window.realtime_fetch = {
		populate: function(url){
			var template = $('#realtime_feeds').html();		
			$.get( url, function( response ){
				$(".realtime_content").html(_.template(template,{items:response}));
			},'json'); 
		},
		populate_raw_applications: function(url){
			var template = $('#raw_applications').html();		
			$.get( url, function( response ){
				$(".realtime_content").html(_.template(template,{items:response}));
			},'json'); 
		}
	}
	
	$('.execute_query').submit(function(e){
		e.preventDefault();
		var url = $(this).attr('action') +'?' + $(this).serialize()
		realtime_fetch.populate(url);
		window.status_url = url
		window.output_info = {
			'from_date': $('#from_date').val(),
			'from_time': $('#from_time').val(),
			'to_date': $('#end_date').val(),
			'to_time': $('#end_time').val()
		}
		revenue_interval.start_interval()
	});
	
	$('.get_raw_applications').submit(function(e){
		e.preventDefault();
		var url = $(this).attr('action') +'?' + $(this).serialize()
		realtime_fetch.populate_raw_applications(url);
		window.output_info = {
			'from_date': $('#from_date').val(),
			'from_time': $('#from_time').val(),
			'to_date': $('#end_date').val(),
			'to_time': $('#end_time').val()
		}
	});
	
	window.revenue_interval = {
		startInterval: setInterval(function(){
			if(typeof window.status_url != 'undefined'){
				realtime_fetch.populate(status_url);
			}
		},10000),
		
		start_interval: function(){
			this.startInterval = this.newInterval;
		},
		
		end_interval: function(){
			clearInterval(this.startInterval);
		}
	}
	
	$(document).on('click','.view-application', function(e){
		e.preventDefault();
		modalContainer.modal( 'show' );
		modalContainer.find('.modal-body').html('Loading content please wait');
		var member_form_uri = $(this).data('url');
		var title = $(this).data('title');
		var data = $.param(output_info);
		if(title==""){ title = "Register"; }
		$.get( member_form_uri+'&'+data, function(response){
			modalContainer.find('.modal-title').html(title);
			modalContent.html( response );
			$('#save_setting_modal').remove()
		});
	});	
	$(document).on('click','.view-user-applications', function(e){
		e.preventDefault();
		modalContainer.modal( 'show' );
		modalContainer.find('.modal-body').html('Loading content please wait');
		var member_form_uri = $(this).data('url');
		var title = $(this).data('title');
		if(title==""){ title = "Register"; }
		$.get( member_form_uri, function(response){
			modalContainer.find('.modal-title').html(title);
			modalContent.html( response );
			$('#save_setting_modal').remove()
		});
	});
	
});