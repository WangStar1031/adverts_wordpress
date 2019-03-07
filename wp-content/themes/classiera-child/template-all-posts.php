<?php
/**
 * Template name: All Ads
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
 get_header(); ?>
 <?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	global $redux_demo;	
	$classieraSearchStyle = $redux_demo['classiera_search_style'];	
	$classieraAdsView = $redux_demo['home-ads-view'];	
	$classieraAllAdsCount = $redux_demo['classiera_no_of_ads_all_page'];
	$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];
	$classiera_pagination = $redux_demo['classiera_pagination'];
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
	$adsTypeMetaTop=
	    array(
	        'key'     => 'ads_type_selected',
	        'value'	=>'standard_top',
	        'compare' => '==',

	);
    $bumpAds=array('relation' => 'OR',
	array(
		'key'=>'bump_ads',
		'compare'=>'=',
	),
	array(
		'key'=>'bump_ads',
		'compare'=>'NOT EXISTS',
	));
	$adsTypeMetaTop2= 
	    array(
            'key'   => 'ads_type_selected',
            'value'=>'double_top',
            'compare' => '==',
	);
	$adsTypeMeta=array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'compare'=>'=',
				),
				array('relation' => 'OR',
					array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_top',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'standard_top',
		            'compare' => '=',
		       	 	),
		       	 	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'standard',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_sec',
		            'compare' => '=',
		        	),
				),
				
			), 
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'compare'=>'NOT EXISTS',
				),
				array('relation' => 'OR',
					array(
			            'key'   => 'ads_type_selected',
			            'value'=>'standard_top',
			            'compare' => '=',
			        ),
			        array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_top',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_sec',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'standard',
		            'compare' => '=',
		        	),
				),
			),
		);
?>
<?php get_template_part( 'templates/searchbar/searchstyle2' ); ?>
<!--Content-->
<section class="inner-page-content top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
					<div class="tab-divs">
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="">
										<div class="grid">
											<!--  Running Ads Type -->
										<!-- <div class=" <?php if($classieraAdsView == 'grid'){ echo "masonry-content"; }?>"> -->
											<?php									
											global $paged, $wp_query, $wp;
											$args = wp_parse_args($wp->matched_query);
											if ( !empty ( $args['paged'] ) && 0 == $paged ){
												$wp_query->set('paged', $args['paged']);
												$paged = $args['paged'];
											}
											$cat_id = get_cat_ID(single_cat_title('', false));
											$temp = $wp_query;
											$wp_query= null;										
											$arags = array(
												'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => $classieraAllAdsCount,
												'paged' => $paged,
												'meta_query' => array(
													$adstypeQuery,
													$adsTypeMeta,
												),
											'orderby' => array('meta_value_num'=>'DESC', 'date'=> 'DESC'),
											// 'order' => 'DESC',
											);
											$wp_query = new WP_Query($arags);									
											while ($wp_query->have_posts()) : $wp_query->the_post();
												get_template_part( 'templates/classiera-loops/loop-canary');
											endwhile; ?>
										</div><!--row-->
									</div>
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
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
			</div><!--col-md-8 col-lg-9-->
		</div><!--row-->
	</div><!--container-->
</section>
<!--Content-->
<?php get_footer(); ?>