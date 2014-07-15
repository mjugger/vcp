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
  
   //Employee Bio post type.
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

  
?>