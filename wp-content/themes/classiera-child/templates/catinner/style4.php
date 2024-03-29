<?php
global $redux_demo;
$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
$classiera_pagination = $redux_demo['classiera_pagination'];
$classieraAdsView = $redux_demo['home-ads-view'];
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
if($classiera_ads_typeOn == 1){
	$adstypeQuery = array(
		'key' => 'classiera_ads_type',
		'value' => 'sold',
		'compare' => '!='
	);
}else{
	$adstypeQuery = null;
}
?>
<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
		<div class="tab-content section-gray-bg">
				<div class="container">
					<div class="">
						<!--FeaturedPosts-->
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}							
						$cat_id = get_queried_object_id();
						$temp = $wp_query;
						$featuredPosts = array();
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'paged' => $paged,								
							'cat' => $cat_id,
							'meta_query' => array(
								array(
									'key' => 'featured_post',
									'value' => '1',
									'compare' => '=='
								),
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							$featuredPosts[] = $post->ID;
							get_template_part( 'templates/classiera-loops/loop-canary');
						endwhile;
						wp_reset_postdata();
						wp_reset_query(); ?>
						<!--FeaturedPosts-->
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}							
						$cat_id = get_queried_object_id();
						$temp = $wp_query;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => -1,
							'post_status' => 'publish',
							'paged' => $paged,
							'post__not_in' => $featuredPosts,
							'cat' => $cat_id,
							'meta_query' => array(
								$adstypeQuery,
							),
						);						
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-canary');
						endwhile; ?>
					</div><!--row masonry-content-->
					<?php
						if($classiera_pagination == 'pagination'){
							classiera_pagination();
						}
					?>
				</div><!--container-->
				<?php
					if($classiera_pagination == 'infinite'){
						echo infinite($wp_query);
					}
				?>
				<?php wp_reset_query(); ?>

		</div><!--tab-content section-gray-bg-->
</section>