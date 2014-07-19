<?php
	
	

	function search_users(){

		$search_params = array(
			'search' => $_POST['user'],
			'search_columns' => array( 'user_nicename', 'user_email' )
		);

		if(isset( $_POST['user'] )){
			$user_query = new WP_User_Query( $search_params );
			echo json_encode($user_query);
		}
		die();
	}

?>