<?php
/* City Custom Post Type */
if( !function_exists( 'classiera_city_post_type' ) ){
    function classiera_city_post_type(){

      $labels = array(
        'name' => __( 'Cities', 'classiera-locations'),
        'singular_name' => __( 'Cities', 'classiera-locations'),
        'add_new' => __('Add New', 'classiera-locations'),
        'add_new_item' => __('Add New City', 'classiera-locations'),
        'edit_item' => __('Edit City', 'classiera-locations'),
        'new_item' => __('New City', 'classiera-locations'),
        'view_item' => __('View City', 'classiera-locations'),
        'search_items' => __('Search Cities', 'classiera-locations'),
        'not_found' =>  __('No City found', 'classiera-locations'),
        'not_found_in_trash' => __('No City found in Trash', 'classiera-locations'),
        'parent_item_colon' => ''
      );

      $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
		'show_in_menu' => 'edit.php?post_type=countries',
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 1,
        'exclude_from_search' => true,
        'supports' => array('title'),
        'rewrite' => array( 'slug' => __('cities', 'classiera-locations') ),
		'menu_icon' => ''
      );

      register_post_type('cities',$args);
    }
}
add_action('init', 'classiera_city_post_type');

add_action( 'add_meta_boxes', 'city_meta_box_add' );
function city_meta_box_add(){    
	add_meta_box( 'city-meta-box-id', __( 'Add Cities by selecting country and states', 'classiera-locations' ), 'city_meta_box_cb', 'cities', 'normal', 'high'  );
}

function city_meta_box_cb( $post )
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
	//print_r($values);exit;
    $selectedCountry = isset( $values['city_meta_box_country'] ) ?  $values['city_meta_box_country']: '';
    $selectedState = isset( $values['city_meta_box_state'] ) ?  $values['city_meta_box_state']: ''; 
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'city_meta_box_nonce', 'meta_box_nonce' );
	
	/* Country */
	$country_array = array( "" => __('Select Country','framework') );
	$country_posts = get_posts( array( 'post_type' => 'countries', 'posts_per_page' => -1) );
	if(!empty($country_posts)){
		foreach( $country_posts as $country_post ){
			$country_array[$country_post->ID] =$country_post->post_title;
		}
	}	
	/* State */
	$currentPost = $post->ID;	
	$currentState = get_post_meta($currentPost, "city_meta_box_state", true);
	
    ?>
    <p>
        <label for="city_meta_box_country"><strong><?php esc_html_e('Country', 'classiera-locations') ?>:</strong> </label>
    </p>
       <select name="city_meta_box_country" id="city_meta_box_country" class="required" required title="Please Select Country">
            <?php foreach($country_array as $key=>$val){?>
            <option value="<?php echo $key;?>" <?php selected( $selectedCountry[0], $key ); ?>><?php echo $val;?></option>
            <?php }?>
        </select>
	<p>
        <label for="city_meta_box_state"><strong><?php esc_html_e('State', 'classiera-locations') ?>:</strong> </label>
    </p>
        <select name="city_meta_box_state" id="city_meta_box_state" class="required" required  title="Please Select State">   
			<option value="<?php echo $currentState;?>" selected><?php echo $currentState;?></option>
		</select>
    <div class="state-city">
		<p><?php esc_html_e('Please paste your all city with comma. (Example : london,purley,redhill) Please dont put empty space or line break.', 'classiera-locations') ?></p>
		<textarea id="classiera-all-city" name="classiera-all-city" cols="90"><?php echo get_post_meta($post->ID, "classiera-all-city", true); ?></textarea>
	</div>
    <?php   
}

add_action( 'save_post', 'city_meta_box_save' );
function city_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'city_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    //if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    // Make sure your data is set before trying to save it
     if( isset( $_POST['city_meta_box_country'] ) )
        update_post_meta( $post_id, 'city_meta_box_country',  $_POST['city_meta_box_country'] );
	if( isset( $_POST['city_meta_box_state'] ) )
        update_post_meta( $post_id, 'city_meta_box_state',  $_POST['city_meta_box_state'] );
	if( isset( $_POST['classiera-all-city'] ) )
        update_post_meta( $post_id, 'classiera-all-city',  $_POST['classiera-all-city'] );
}


/* Add Custom Columns */
if( !function_exists( 'cities_edit_columns' ) ){
    function cities_edit_columns($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'City Title','classiera-locations' ),
            "state" => __( 'State','classiera-locations' ),
			"country1" => __( 'Country','classiera-locations' ),
			"date" => __( 'Publish Time','classiera-locations' )
        );

        return $columns;
    }
}
add_filter("manage_edit-cities_columns", "cities_edit_columns");

if( !function_exists( 'cities_custom_columns' ) ){
    function cities_custom_columns($column){
        global $post;
        switch ($column)
        {
			 case 'state':
				$ID = get_post_meta($post->ID,'city_meta_box_state',true);
				echo $ID;				
				break;
            case 'country1':
                $ID = get_post_meta($post->ID,'city_meta_box_country',true);
                echo get_the_title( $ID );				
                break;
        }
    }
}
add_action("manage_posts_custom_column", "cities_custom_columns");
?>