<?php
/* Country Custom Post Type */
if( !function_exists( 'classiera_country_post_type' ) ){
    function classiera_country_post_type(){

      $labels = array(
        'name' => __( 'Countries', 'classiera-locations'),
        'singular_name' => __( 'Countries', 'classiera-locations'),
		'menu_name'           => __( 'Locations JW', 'classiera-locations'),
		'all_items'           => __( 'Countries', 'classiera-locations'),
        'add_new' => __('Add New', 'classiera-locations'),
        'add_new_item' => __('Add New Country', 'classiera-locations'),
        'edit_item' => __('Edit Country', 'classiera-locations'),
        'new_item' => __('New Country', 'classiera-locations'),
        'view_item' => __('View Country', 'classiera-locations'),
        'search_items' => __('Search Countries', 'classiera-locations'),
        'not_found' =>  __('No Country found', 'classiera-locations'),
        'not_found_in_trash' => __('No Country found in Trash', 'classiera-locations'),
        'parent_item_colon' => ''
      );

      $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,		
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,        
        'exclude_from_search' => true,
        'supports' => array('title','thumbnail','editor'),
        'rewrite' => array( 'slug' => __('countries', 'classiera-locations') ),
		'menu_icon' => 'dashicons-location'
      );

      register_post_type('countries',$args);
    }
}
add_action('init', 'classiera_country_post_type');

/* Add Custom Columns */
if( !function_exists( 'countries_edit_columns' ) ){
    function countries_edit_columns($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Country Title','classiera-locations' ),
			"date" => __( 'Publish Time','classiera-locations' )
        );

        return $columns;
    }
}
add_filter("manage_edit-countries_columns", "countries_edit_columns");
?>