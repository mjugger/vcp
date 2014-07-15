<?php
	 /*
   Plugin Name: video custom post
   Plugin URI: http://my-awesomeness-emporium.com
   Description: a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Mr. Awesome
   Author URI: http://mrtotallyawesome.com
   License: GPL2
   */
  
   //Employee Bio post type.
	add_action('init', 'employee_bio',2);

	     function employee_bio() {
	       $feature_args2 = array(
	          'labels' => array(
	           'name' => __( 'Employee Bios' ),
	           'singular_name' => __( 'Employee Bio' ),
	           'add_new' => __( 'Add New Bio' ),
	           'add_new_item' => __( 'Add New Bio' ),
	           'edit_item' => __( 'Edit Bio' ),
	           'new_item' => __( 'New Bio' ),
	           'view_item' => __( 'View Bio' ),
	           'search_items' => __( 'Search Employee Bios' ),
	           'not_found' => __( 'No Employee Bio found' ),
	           'not_found_in_trash' => __( 'No Employee Bio found in trash' )
	         ),
	       'public' => true,
	       'show_ui' => true,
	       'capability_type' => 'page',
	       'hierarchical' => false,
	       'rewrite' => true,
	       'menu_position' => 20,
	       'supports' => array('title', 'editor', 'thumbnail','excerpt','page-attributes')
	     );
	  register_post_type('bio',$feature_args2);
	}

  
?>