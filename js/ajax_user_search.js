var search_users_input_field = $('#search_users_input_field');

$('#search_users').on('mouseup',function(){
	search_wp_users(search_users_input_field.val());
});

function search_wp_users(search_for){
	$.ajax('/helper_classes/wp_search_users.php',{
		type:'post',
		data:search_for,
		success:function(status,data){
			console.log( Boolean(data) );
		},
		error:function(status,err){
			console.log(err);
		}
	});
}