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
  
   function depended_scripts(){
   		wp_enqueue_script( 'ajax_user_search', plugins_url() . '/js/ajax_user_search.js', array( 'jquery' ), '20120206', true );
   }

   add_action( 'wp_enqueue_scripts', 'depended_scripts' );

   //video post type.
	add_action('init', 'video_post',2);

	     function video_post() {
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
	       'menu_position' => 20,
	       'supports' => array('title', 'editor', 'thumbnail','excerpt','page-attributes')
	     );
	  register_post_type('video post',$feature_args2);
	}

	add_action( 'add_meta_boxes', 'add_events_metaboxes' );
	
	function add_events_metaboxes(){
		add_meta_box('testbox', 'Team Hits (Note: do not drag to right hand side.)', 'video_distributor', 'video post', 'normal', 'high');
	}

	function video_distributor($post){
		
		/*$bio_post = new WP_Query( array( 'post_type' => 'bio','posts_per_page'=>-1) );
		$t = get_the_title();
		//$values = get_post_custom( $post->ID);
		$check_the_boxes = maybe_unserialize( get_post_meta($post->ID, "team", true) );
		
		
		while( $bio_post->have_posts() ){
			
			$bio_post->the_post();

			if($t == get_the_title() ){
				continue;
			}
			
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $bio_post->ID ), 'single-post-thumbnail' );
			$check = in_array(''.get_the_title().'+'.$image_url[0].'+'.get_permalink().'', (array) $check_the_boxes) ? 'checked="checked"' : '';
			
			echo '<input type="checkbox" name="team[]" value="'.get_the_title().'+'.$image_url[0].'+'.get_permalink().'"  '.$check.' /> '.get_the_title().'<br>';
			
		}*/
		//wp_reset_postdata();
		echo '<p>hey there</p>';
	}
	
	add_action( 'save_post', 'video_distributor_save',10,1);

	//save the meta box
	function video_distributor_save($post_id){   
		
		//$check_the_boxes2 = maybe_unserialize( get_post_meta($post->ID, "team", true) );
		
		// Bail if we're doing an auto save  
    	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
    		 return;
    	}
    	
    	 if ( isset($_POST['team']) ) { // if we get new data

        	update_post_meta($post_id, "team", $_POST['team'] );
			
   		}else{
   			update_post_meta($post_id, "team", "" );
   		}
    	
	}

	

  
?>