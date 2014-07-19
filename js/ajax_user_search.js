jQuery(function($){

	var ajax_search_timer,
		array_of_users,
		distributor_info,
		distributor_info_save,
		model_overlay,
		model,
		close_model,
		model_search_field,
		ajax_spinner,
		model_search_results;

	function search_wp_users(search_for){
		
		$.ajax({
			url:myAjax.ajaxurl,
			type:'post',
			data:{
				action:'search_users',
				user:search_for
			},
			beforeSend:function(){
				show_hide_ajax_spinner('show');
			},
			success:function(responce){
				array_of_users = JSON.parse(responce);
				var users_html = create_search_results_markup( array_of_users );
				model_search_results.html(users_html);
			},
			error:function(err){
				console.log(err);
			},
			complete:function(){
				show_hide_ajax_spinner('hide');
			}
		});
	
	}

	function show_hide_overlay(show_or_hide){
		if(show_or_hide == 'show'){
			model_overlay.fadeIn(500);
		}else if(show_or_hide == 'hide'){
			model_overlay.fadeOut(500);
		}
	}

	function show_hide_ajax_spinner(show_or_hide){
		if(show_or_hide == 'show'){
			ajax_spinner.show();
		}else if(show_or_hide == 'hide'){
			ajax_spinner.hide();
		}
	}

	function create_search_results_markup(user_json){
		var display_markup = [];
		$.each(user_json.results,function(i,user){
			display_markup.push( user_display_markup(user) );
		});
		return display_markup.join('');
	}

	function user_display_markup(user){
		return [
				'<div class="user_info">',
					'<p class="user_info_userName">user name: '+user.data.display_name+' | email: '+user.data.user_email+'</p>',
				'</div>'
			].join('')
	}

	distributor_info_save = $('#distributor_info_save');
	
	distributor_info = $('#distributor_info');

	$('#show_user_search_model').on('mouseup',function(){
		show_hide_overlay('show');
	});

	$('#remove_user_markup').on('mouseup',function(){
		distributor_info.html('');
		//tells vcp.php to remove distributor_info metadata
		distributor_info_save.val('remove');
	});

	model_overlay = $('<div id="model_overlay"></div>');

	model = $('<div id="model" class="padding_left_10px"></div>');

	close_model = $('<span></span>',{
		id:'close_model',
		html:'&times;',
		mouseup:function(){
			show_hide_overlay('hide');
		}
	});

	ajax_spinner = $('<img src="../wp-admin/images/spinner.gif" id="ajax_spinner"/>');

	model_search_results = $('<div id="model_search_results"></div>');

	model_search_results.on('mouseup','div.user_info',function(){
		//index of .user_info div matches the index of the same
		//data from the search results array
		var this_user = array_of_users.results[ $(this).index() ];
		
		//saves user info object to hidden field
		distributor_info_save.val( JSON.stringify(this_user) );
		
		//adds selected user display html to metabox
		distributor_info.html( user_display_markup(this_user) );
		
		show_hide_overlay('hide');
	});

	model_search_field = $('<input/>',{
		id:'model_search_field',
		addClass:'padding_left_10px',
		keyup:function(){
			//wildcard search does a search that contains the string
			//vs an exact match of the string.
			var wildcard_search = '*'+model_search_field.val()+'*';
			ajax_search_timer = setTimeout(function(){
				search_wp_users( wildcard_search );
			},500);
		},
		keydown:function(){
			clearTimeout(ajax_search_timer);
		}
	});

	//assemble the model view
	model.append('<h3 class="model_header">Search for user by display name or email</h3>')
		.append(model_search_field)
		.append(close_model)
		.append(ajax_spinner)
		.append(model_search_results);
	model_overlay.append(model);
	$('#wpbody').prepend(model_overlay);

});