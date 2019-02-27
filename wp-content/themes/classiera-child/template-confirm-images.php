<?php
/**
 * Template name: Confirm Images
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

if ( !is_user_logged_in() ) { 
    global $redux_demo;
    $login = $redux_demo['login'];
    wp_redirect( $login ); exit;
}

global $redux_demo; 
$edit = $redux_demo['edit'];
$pagepermalink = get_permalink($post->ID);

global $current_user, $user_id;
$current_user = wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID;

if( isset($_POST['post-id'])){
    $dir = __DIR__ . "/ConfirmImages/";
    if( !file_exists($dir)){
        mkdir($dir, 0777);
    }
    $post_id = $_POST['post-id'];
    $arrPostIds = explode(",", $post_id);
    $filename = $_FILES["realUploadButton"]["tmp_name"];
    $path_parts = pathinfo($_FILES["realUploadButton"]["name"]);
    $type = $path_parts['extension'];
    $srcFile = __DIR__ . "/ConfirmImages/" . $_FILES["realUploadButton"]["name"];
    move_uploaded_file($filename,  $srcFile);
    foreach ($arrPostIds as $value) {
        copy($srcFile, __DIR__ . "/ConfirmImages/" . $value . "." . $type);
    }
    unlink($srcFile);
    update_post_meta( $post_id, "activate_post", 0);
    $message = "<p>New image uploaded for confirmation.</p>";
    $message .= "<p>" . $post_id . "</p>";
    $imgPath =  "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/wp-content/themes/classiera-child/ConfirmImages/" . $arrPostIds[0] . "." . $type;
    $message .= '<img src="' . $imgPath . '">';
    wp_mail("mareksvoicehs@gmail.com", "Hello.", $message);
}

function isConfirmedPost($_postId){
    $dir = __DIR__ . "/ConfirmImages/";
    if( !file_exists($dir)){
        mkdir($dir, 777);
    }
    $files = glob($dir . $_postId . ".*");
    if( $files) return true;
    return false;
}

    // $args = array(
    //     'post_type' => 'POST',
    //     'post_status' => 'publish',
    //     'posts_per_page' => -1,
    //     'author' => $user_ID
    // );

    // $wp_query1 = new WP_Query($args);
    // $is_Exist = false;
    // while ( $wp_query1->have_posts() ) : $wp_query1->the_post();
    //     $post_id = get_the_ID();
    //     if( isConfirmedPost($post_id) == true)
    //         continue;
    //     $is_Exist = true;
    // endwhile;
    // if( $is_Exist == false){
    //     $classieraProfileURL = $redux_demo['profile'];
    //     wp_redirect($classieraProfileURL); exit();
    // }
get_header();
?>
<?php

?>
<section class="user-pages">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
            <?php get_template_part( 'templates/profile/userabout' );?>
            </div><!--col-lg-3-->
            <div class="col-lg-9 col-md-8 user-content-height">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-uppercase"><?php esc_html_e("Confirm Images", 'classiera') ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="user-detail-section">
                            <h4 class="text-center"><?php esc_html_e('In order to confirm your images, please upload image with yourself holding paper in front of you with the current date and "Our Website Name"', 'classiera'); ?></h4>
                            <h4 class="text-center"><?php esc_html_e('You have to be clearly visible in the picture, no blur filter is allowed', 'classiera'); ?></h4>
                            <form action="" method="post" enctype="multipart/form-data">
                            	<din class="row">
                            		<div class="col-lg-12">
                            			<div class="checkbox">

                            			    <?php
                            			    	$user_id = get_current_user_id();
                            			    	$args = array(
                            			    	    'post_type' => 'POST',
                            			    	    'post_status' => 'publish',
                            			    	    'posts_per_page' => -1,
                            			    	    'author' => $user_id
                            			    	);                       

                            			    	$wp_query = new WP_Query($args);
                                                $is_Exist = false;
                            			    	while ( have_posts() ) : the_post();
                            			    		$post_id = get_the_ID(); 
                                                    if( isConfirmedPost($post_id))
                                                        continue;
                                                    $is_Exist = true;
                                                    ?>
                                                    <!-- <label><input type="checkbox" name="">aaa</label> -->
                            			    	    <label><input class="chkPost" type="checkbox" name="post-id-<?php echo $post_id ?>" value="<?php the_title(); ?>"><?php the_title(); ?></label><br>
                            			    	<?php endwhile;
                            			    ?>
                            			</div>
                            		</div>
                            	</din>
                            	<div class="row">
                            		<div class="col-lg-12">
                                        <input type="hidden" name="post-id">
                            			<input class="hidden" id="realUploadButton" name="realUploadButton" type="file">
                            			<button id="uploadButton" class="btn btn-primary" id="confirmImage" disabled><?php esc_html_e('Select Image', 'classiera'); ?></button>
                            		</div>
                            		<div class="col-lg-12">
                            			<img id="placeholder-image" src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder.jpeg" alt="" />
                            		</div>
                            		<div class="col-lg-12">
                            			<button class="btn btn-primary" id="submitImage" type="submit" disabled><?php esc_html_e('Submit', 'classiera'); ?></button>
                            		</div>
                            	</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!--col-lg-9-->
        </div><!--row-->
    </div><!--container-->
</section><!--user-pages-->

<script>
	$(document).ready(function(){
        $('#uploadButton').click(function(e) {
            e.preventDefault();
            $('#realUploadButton').click();
        });
        var isImageLoaded = false;
		function showImage(src,target) {
            var fr = new FileReader();
            // when image is loaded, set the src of the image where you want to display it
            fr.onload = function(e) { 
                target.src = this.result; 
                isImageLoaded = true;
                $("#submitImage").prop("disabled", false);
            };
            src.addEventListener("change",function() {
                // fill fr with image data    
                fr.readAsDataURL(src.files[0]);
            });
		}

		var src = document.getElementById("realUploadButton");
		var target = document.getElementById("placeholder-image");
		showImage(src,target);

        $(".chkPost").change(function() {
            $("input[name=post-id]").val("");
            var arrChks = $(".chkPost");
            var arrIds = [];
            $("#uploadButton").prop("disabled", true);
            $("#submitImage").prop("disabled", true);
            for( var i = 0; i < arrChks.length; i++){
                var curChk = arrChks.eq(i);
                if( curChk.prop("checked") == true){
                    var chkName = curChk.attr("name");
                    var id = chkName.replace("post-id-", "");
                    arrIds.push(id);
                    $("#uploadButton").prop("disabled", false);
                    if( isImageLoaded ){
                        $("#submitImage").prop("disabled", false);
                    }
                }
            }
            $("input[name=post-id]").val(arrIds.join(","));
        });
	});
</script>
 <?php get_footer(); ?>