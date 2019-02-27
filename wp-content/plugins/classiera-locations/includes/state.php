<?php
/* State Custom Post Type */
if( !function_exists( 'classiera_state_post_type' ) ){
    function classiera_state_post_type(){

      $labels = array(
        'name' => __( 'States', 'classiera-locations'),
        'singular_name' => __( 'States', 'classiera-locations'),
        'add_new' => __('Add New', 'classiera-locations'),
        'add_new_item' => __('Add New State', 'classiera-locations'),
        'edit_item' => __('Edit State', 'classiera-locations'),
        'new_item' => __('New State', 'classiera-locations'),
        'view_item' => __('View State', 'classiera-locations'),
        'search_items' => __('Search States', 'classiera-locations'),
        'not_found' =>  __('No State found', 'classiera-locations'),
        'not_found_in_trash' => __('No State found in Trash', 'classiera-locations'),
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
        'rewrite' => array( 'slug' => __('states', 'classiera-locations') ),
		'menu_icon' => ''
      );

      register_post_type('states',$args);
    }
}
add_action('init', 'classiera_state_post_type');

add_action( 'add_meta_boxes', 'state_meta_box_add' );
function state_meta_box_add(){
	
   add_meta_box( 'state-meta-box-id', __( 'Add states by selecting country', 'classiera-locations' ), 'state_meta_box_cb', 'states', 'normal', 'high'  );
}

function state_meta_box_cb( $post )
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );	
    $selected = isset( $values['state_meta_box_country'] ) ?  $values['state_meta_box_country']: '';     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'state_meta_box_nonce', 'meta_box_nonce' );
	
	/* country */
	$country_array = array( "" => __('Select Country','framework') );
	$country_posts = get_posts( array( 'post_type' => 'countries', 'posts_per_page' => -1) );
	//print_r($country_posts);
	
	if(!empty($country_posts)){
		foreach( $country_posts as $country_post ){
			$country_array[$country_post->ID] =$country_post->post_title;
		}
	}	
    ?>
    <p>
        <label for="state_meta_box_country"><strong><?php esc_html_e('Country', 'classiera-locations') ?>: </strong></label></p>
        <select name="state_meta_box_country" id="state_meta_box_country" class="required" required title="Please Select Country">
            <?php foreach($country_array as $key=>$val){?>
            <option value="<?php echo $key;?>" <?php selected( $selected[0], $key ); ?>><?php echo $val;?></option>
            <?php }?>
        </select>
		<div class="state-meta">
			<p><?php esc_html_e('Please paste your all state with comma. (Example : london,purley,redhill) Please dont put empty space or line break.', 'classiera-locations') ?></p>
			<textarea id="classiera-all-states" name="classiera-all-states" cols="90"><?php echo get_post_meta($post->ID, "classiera-all-states", true); ?></textarea>
		</div>
    
    <?php   
}

add_action( 'save_post', 'state_meta_box_save' );
function state_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'state_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    //if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    // Make sure your data is set before trying to save it
     if( isset( $_POST['state_meta_box_country'] ) )
        update_post_meta( $post_id, 'state_meta_box_country',  $_POST['state_meta_box_country'] );
	
	/*Save states*/
	if(isset($_POST["classiera-all-states"]))
    {
        $classieraAllStates = $_POST["classiera-all-states"];
    }   
    update_post_meta($post_id, "classiera-all-states", $classieraAllStates);
	/*Save states*/
}


/* Add Custom Columns */
if( !function_exists( 'states_edit_columns' ) ){
    function states_edit_columns($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'State Title','classiera-locations' ),
            "country" => __( 'Country','classiera-locations' ),
			 "date" => __( 'Publish Time','classiera-locations' )
        );

        return $columns;
    }
}
add_filter("manage_edit-states_columns", "states_edit_columns");

if( !function_exists( 'states_custom_columns' ) ){
    function states_custom_columns($column){
        global $post;
        switch ($column)
        {
            case 'country':
                $ID = get_post_meta($post->ID,'state_meta_box_country',true);
                echo get_the_title( $ID );				
                break;
        }
    }
}
add_action("manage_posts_custom_column", "states_custom_columns");

?>