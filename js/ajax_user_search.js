jQuery(function(){
	var search_users_input_field = jQuery('#search_users_input_field');
	
	jQuery('#search_users').on('mouseup',function(e){
		search_wp_users(search_users_input_field.val());
		//e.preventDefault();
	});

	function search_wp_users(search_for){
		jQuery.ajax({
			url:myAjax.ajaxurl,
			type:'post',
			data:{
				action:'search_users',
				user:search_for
			},
			success:function(data,status){
				console.log( status,data );
			},
			error:function(status,err){
				console.log(err);
			}
		});
	}
});