<?php
	 /*
   Plugin Name: video custom post
   Plugin URI: https://github.com/mjugger/vcp
   Description: Creates a custom post type for videos
   Version: 1.0
   Author: Mukhtar Jugger
   Author URI: https://github.com/mjugger
   License: ???
   */
  
  require_once('helper_classes/wp_search_users.php');
  
   function depended_scripts(){
   		wp_register_style('vcp.css',plugins_url() .'/vcp/css/vcp.css');
   		wp_register_script( 'ajax_user_search', plugins_url() . '/vcp/js/ajax_user_search.js', array( 'jquery' ), '20120206', true );
   		wp_localize_script( 'ajax_user_search', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   		wp_enqueue_style('vcp.css');
   		wp_enqueue_script('ajax_user_search');
   		
   }

   add_action( 'init', 'depended_scripts' );
   add_action("wp_ajax_search_users", "search_users");
   

   //video post type.
	add_action('init', 'video_custom_post',2);

	     function video_custom_post() {
	       $feature_args2 = array(
	          'labels' => array(
	           'name' => __( 'video posts' ),
	           'singular_name' => __( 'video post' ),
	           'add_new' => __( 'Add New video post' ),
	           'add_new_item' => __( 'Add New video post' ),
	           'edit_item' => __( 'Edit video post' ),
	           'new_item' => __( 'New video post' ),
	           'view_item' => __( 'View video post' ),
	           'search_items' => __( 'Search video posts' ),
	           'not_found' => __( 'No video posts found' ),
	           'not_found_in_trash' => __( 'No video posts found in trash' )
	         ),
	       'public' => true,
	       'show_ui' => true,
	       'capability_type' => 'page',
	       'hierarchical' => false,
	       'rewrite' => true,
	       'menu_position' => 5,
	       'supports' => array('title', 'editor', 'thumbnail','excerpt','page-attributes')
	     );
	  register_post_type('video_post',$feature_args2);
	}

	function my_taxonomies_video_post() {
	  $labels = array(
	    'name'              => _x( 'video post Categories', 'taxonomy general name' ),
	    'singular_name'     => _x( 'video post Category', 'taxonomy singular name' ),
	    'search_items'      => __( 'Search video post Categories' ),
	    'all_items'         => __( 'All video post Categories' ),
	    'parent_item'       => __( 'Parent video post Category' ),
	    'parent_item_colon' => __( 'Parent video post Category:' ),
	    'edit_item'         => __( 'Edit video post Category' ), 
	    'update_item'       => __( 'Update video post Category' ),
	    'add_new_item'      => __( 'Add New video post Category' ),
	    'new_item_name'     => __( 'New video post Category' ),
	    'menu_name'         => __( 'video post Categories' ),
	  );
	  $args = array(
	    'labels' => $labels,
	    'hierarchical' => true,
	  );
	  register_taxonomy( 'video_post_category', 'video_post', $args );
	}
	add_action( 'init', 'my_taxonomies_video_post', 0 );
	
	
	function vcp_add_events_metaboxes(){
		add_meta_box('distributorBox', 'distributor |assignd by admin|', 'video_distributor', 'video_post', 'normal', 'high');
	}

	add_action( 'add_meta_boxes', 'vcp_add_events_metaboxes' );

	function video_distributor($post){
		
		echo '<div id="distributor_info">'.get_video_distributor($post->ID).'</div>';
		if(current_user_can('manage_options')){
			echo '<button type="button" id="show_user_search_model">search users</button>
 		<button type="button" id="remove_user_markup">remove</button>
 		<input type="hidden" id="distributor_info_save" name="distributor_info_save"/>';
		}
	}

	function get_video_distributor($post_id){
		$distributor_info = get_post_meta($post_id,'distributor_info',true);
		if($distributor_info != ''){
			$distributor_info = json_decode($distributor_info);
			return '<p>user name: '.$distributor_info->data->display_name.' | user email: '.$distributor_info->data->user_email.'</p>';
		}
		return '';
	}
	
	add_action( 'save_post', 'save_video_distributor',10,1);

	//save the meta box
	function save_video_distributor($post_id){   
		
		//$check_the_boxes2 = maybe_unserialize( get_post_meta($post->ID, "team", true) );
		
		// Bail if we're doing an auto save  
    	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
    		 return;
    	}
    	
    	 if ( isset($_POST['distributor_info_save'] ) && $_POST['distributor_info_save'] != 'remove' ) { // if we get new data

        	update_post_meta($post_id, "distributor_info", $_POST['distributor_info_save'] );
			
   		}else if($_POST['distributor_info_save'] == 'remove'){
   			update_post_meta($post_id, "distributor_info", "" );
   		}
    	
	}

	

  
?>