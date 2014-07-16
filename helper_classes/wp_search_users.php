<?php
	
	function search_users(){
		if(isset( $_POST['user'] )){
			$user_query = new WP_User_Query( array( 'search' => $_POST['user'] ));
			echo json_encode($user_query);
		}
		die();
	}

?>