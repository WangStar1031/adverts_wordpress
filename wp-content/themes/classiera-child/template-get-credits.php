<?php
/**
 * Template name: Get Credits
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
get_header();
?>
<section class="user-pages">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
            <?php get_template_part( 'templates/profile/userabout' );?>
            </div><!--col-lg-3-->
<?php

//I added this code
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1
);

$wp_query = new WP_Query($args);
$redux_demo = get_option('redux_demo');
//I added this code

global $woocommerce;
if(WC()->cart->cart_contents_count == 0)
{
    $className=0;

}else
{
    $className=1;
}
?>            
            <div class="col-lg-9 col-md-8 user-content-height">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-uppercase"><?php esc_html_e("Get Credits", 'classiera') ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="user-detail-section">
                            <div class="getCreditRow">
                                <!-- Get credits heading text -->
                                <h4 class="text-center">
                                    <?php
                                        if(isset($redux_demo['get-credits-heading']) && !empty($redux_demo['get-credits-heading'])){
                                        esc_html_e($redux_demo['get-credits-heading'],'classiera');
                                        } 
                                    ?>
                                </h4>
                                <!-- /Get credits heading text -->
                                <!-- Get credits body text -->
                                <p class="redux-body">
                                    <?php 
                                    if(isset($redux_demo['get-credits-body-text']) && !empty($redux_demo['get-credits-body-text'])){
                                        esc_html_e($redux_demo['get-credits-body-text'],'classiera');
                                    } 
                                    ?>
                                </p>
                                <!-- / Get credits body text -->
                            </div>
                            <!-- favorite ads -->
                            <!--  WooCommerce Product -->
                            <!-- Products container -->                 
                            <div class="row credit-packages" <?php if($className==1) echo 'style="display:none;"';?>>
                            <?php
                                $i=0;
                                if ( $wp_query->have_posts() ) :
                                    while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
                                        $i++;
                                        if($i%4==0)
                                        {
                                            // echo '</div><div class="row">';
                                        }
                            ?>
                            <div class="col-sm-12 col-md-3">
                                <div class="thumbnail">
                                    <?php echo get_the_post_thumbnail(); ?>
                                  <div class="caption">
                                    <h3><?php the_title();?></h3>
                                    <p><?php the_excerpt();?></p>
                                    <p><a href="javascript:void(0)" id="<?php echo get_the_id();?>" class="btn btn-primary add_to_cart_ajax get-credits-button" role="button"><?php _e('Buy Now', 'classiera'); ?></a></p>
                                  </div>
                                </div>
                            </div>
                            
                            <!-- <?php  //echo woocommerce_get_product_thumbnail($thumbnail); ?> -->
                                            
                            <?php endwhile; endif; ?>

                            </div>
                            <!-- / Products container -->
                            <!-- / WooCommerce Product -->
                            <!-- WooCommerce Cart  -->
                            <div class="gc_woocommercr_cart">
                                <?php 
                                    if($className==1): 
                                        echo do_shortcode('[woocommerce_cart]');
                                    endif;
                                ?>
                            </div>
                            <?php //echo do_shortcode('[woocommerce_cart]');?>
                            <!-- WooCommerce Cart -->

                            <!-- WooCommerce Checkout  -->
                            <div class="gc_woocommercr_checkout">
                            </div>
                            <?php //echo do_shortcode('[woocommerce_checkout]');?>
                            <!-- WooCommerce Checkout  -->
                        </div><!--user-detail-->
                    </div>
                </div>
            </div><!--col-lg-9-->
        </div><!--row-->
    </div><!--container-->
</section><!--user-pages-->
<script type="text/javascript">
    jQuery('.add_to_cart_ajax').click(function(e){
        var product_id=jQuery(this).attr('id');
        //alert(product_id);
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action':'add_to_cart_ajax',
                'productid':product_id,
            },
            success: function (response) {
                jQuery('.gc_woocommercr_cart').html(response);
                jQuery('.getCreditRow').hide();
                jQuery('.credit-packages').hide();

            },
            error: function (errorThrown) {

            }
        });
    });

    jQuery("a.checkout-button").click( function(event) {
        event.preventDefault();
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action':'add_to_cart_ajax',
                'checkout_active':'1',
            },
            success: function (response) {
               console.log(response);
                jQuery('.gc_woocommercr_checkout').html(response);
                jQuery('.gc_woocommercr_cart').hide();
                jQuery('.getCreditRow').hide();

            },
            error: function (errorThrown) {

            }
        });  
       // return false;  
    });
</script>
 <?php get_footer(); ?>