<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 1.0
 */

get_header(); ?>
<?php 
// Retrieve the URL variables (using PHP).
	global $redux_demo;
	$catSearchID = "";
	$minPrice = "";
	$maxPrice = "";
	$search_state = "";
	$search_country = "";
	$search_city = "";
	$main_cat = "";
	$price_range = "";
	$searchQueryCountry = "";
	$searchQueryState = "";
	$classieraAdsTypeSearch = "";
	$searchCondition = "";
	$searchQueryCustomFields = "";
	$emptyPost = 0;
	$featuredPosts = array();
	$classieraSearchStyle = $redux_demo['classiera_search_style'];	
	$classieraGoogleMAP = $redux_demo['classiera_map_on_search'];
	$classieraMAPPostType = $redux_demo['classiera_map_post_type'];	
	$classieraMAPStyle = $redux_demo['map-style'];	
	$locShownBy = $redux_demo['location-shown-by'];		
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];	
	$classieraAdsView = $redux_demo['home-ads-view'];
	$classiera_pagination = $redux_demo['classiera_pagination'];
	$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
	$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
	$postCurrency = $redux_demo['classierapostcurrency'];
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
	if($classieraMultiCurrency == 'multi'){
		$classieraPriceTagForSearch = classiera_Display_currency_sign($classieraTagDefault);
	}elseif(!empty($postCurrency) && $classieraMultiCurrency == 'single'){
		$classieraPriceTagForSearch = $postCurrency;
	}
	$classieraItemClass = "item-grid";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}	
	$keyword = $_GET['s'];
	if(isset($_GET['custom_fields'])){
		$custom_fields = $_GET['custom_fields'];
		$searchQueryCustomFields = classiera_CF_search_Query($custom_fields);
	}
	if(isset($_GET['sub_cat'])){
		$sub_cat = $_GET['sub_cat'];
	}	
	if(isset($_GET['category_name'])){
		$main_cat = $_GET['category_name'];
	}	
	if(isset($_GET['search_min_price'])){
		$minPrice = $_GET['search_min_price'];
	}
	if(isset($_GET['search_max_price'])){
		$maxPrice = $_GET['search_max_price'];
	}
	if(isset($_GET['price_range'])){
		$price_range = $_GET['price_range'];
	}	
	if(empty($maxPrice)){
		$string = $price_range;
	}else{
		$string = $minPrice.','.$maxPrice;
	}	
	$priceArray = explode(',', $string);
	if(!empty($priceArray)){		
		$searchQueryPrice = classiera_Price_search_Query($priceArray);
	}
	if(isset($_GET['post_location'])){
		$country = $_GET['post_location'];		
		$searchQueryCountry = classiera_Country_search_Query($country);		
	}	
	if(isset($_GET['post_state'])){
		$state = $_GET['post_state'];
		$searchQueryState = classiera_State_search_Query($state);		
	}	
	if(isset($_GET['post_city'])){
		$city = $_GET['post_city'];
		$searchQueryCity = classiera_City_search_Query($city);
	}
	if(isset($_GET['item-condition'])){
		$search_condition = $_GET['item-condition'];		
		$searchCondition = classiera_Condition_search_Query($search_condition);
	}
	if(isset($_GET['classiera_ads_type'])){
		$classieraAdsType = $_GET['classiera_ads_type'];		
		$classieraAdsTypeSearch = classiera_adstype_search_Query($classieraAdsType);
	}	
	if(empty($sub_cat) || $sub_cat == '-1'){		
		$category_name = $main_cat;
	}else{
		$category_name = $sub_cat;
	}	
	if(!empty($category_name)){
		if($category_name != "All" && $category_name != "-1") {
			$catSearchID = $category_name;				
		} else {
			$catSearchID = '-1';
		}
	}
	$iconPath = '';
	//Google MAP
	if($classieraGoogleMAP == true){
?>


<?php } get_template_part( 'templates/searchbar/searchstyle2' );?>

<section class="inner-page-content top-pad-50">
	<div class="container">
        <div class="row">
			<!--ContentArea-->
			<div class="col-lg-12">
				
				<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
					<div class="tab-divs">
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="">
										<?php
										global $paged, $wp_query, $wp;										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryCountry,						
												$searchQueryState,						
												// $searchQueryCity,
												$classieraAdsTypeSearch,
												$searchCondition,
												$searchQueryCustomFields,
												$adstypeQuery,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
											),
										);										
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$emptyPost++;
											$featuredPosts[] = $post->ID;
											get_template_part( 'templates/classiera-loops/loop-canary');
										endwhile;
										wp_reset_query();
										wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryCountry,						
												$searchQueryState,						
												// $searchQueryCity,
												$searchCondition,
												$classieraAdsTypeSearch,
												$searchQueryCustomFields,
												$adstypeQuery,
											),
										);
										$wp_query= null;										
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$emptyPost++;
											get_template_part( 'templates/classiera-loops/loop-canary');
										endwhile; ?>
									</div><!--row-->
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
				<!-- end advertisement style 4-->
				
			</div>
			<!--ContentArea-->
		</div><!--row-->
	</div><!--container-->	
</section>
<?php get_footer(); ?>