<?php 
	$_age = "";
	// if( isset( $_GET['age'])) $_age = $_GET['age'];
	// echo "string";
	$_search= "";
	// if( isset( $_GET['Search'])) $_search = $_GET['Search'];
	// print_r($_sKeyword);
if( $_age != ""){
	// $_age = "";
	// if( isset( $_GET['age'])) $_age = $_GET['age'];
	$_category = "";
	if( isset( $_GET['category'])) $_category = $_GET['category'];
	$_nat_lang = "";
	if( isset( $_GET['nat_lang'])) $_nat_lang = $_GET['nat_lang'];
	$_hair = "";
	if( isset( $_GET['hair'])) $_hair = $_GET['hair'];
	$_eyes = "";
	if( isset( $_GET['eyes'])) $_eyes = $_GET['eyes'];
	$_ethnicity = "";
	if( isset( $_GET['ethnicity'])) $_ethnicity = $_GET['ethnicity'];
	$_weight = "";
	if( isset( $_GET['weight'])) $_weight = $_GET['weight'];
	$_waist = "";
	if( isset( $_GET['waist'])) $_waist = $_GET['waist'];
	$_hips = "";
	if( isset( $_GET['hips'])) $_hips = $_GET['hips'];
	$_dress = "";
	if( isset( $_GET['dress'])) $_dress = $_GET['dress'];
	$_shoe = "";
	if( isset( $_GET['shoe'])) $_shoe = $_GET['shoe'];
	$_pubic = "";
	if( isset( $_GET['pubic'])) $_pubic = $_GET['pubic'];
	$_smoker = "";
	if( isset( $_GET['smoker'])) $_smoker = $_GET['smoker'];
	$_friendly = "";
	if( isset( $_GET['friendly'])) $_friendly = $_GET['friendly'];
	$_drink = "";
	if( isset( $_GET['drink'])) $_drink = $_GET['drink'];
	$_showers = "";
	if( isset( $_GET['showers'])) $_showers = $_GET['showers'];
	$_travel = "";
	if( isset( $_GET['travel'])) $_travel = $_GET['travel'];
	$_tags = "";
	if( isset($_GET['tags'])) $_tags = $_GET['tags'];
	$_cost = "";
	if( isset($_GET['cost'])) $_cost = $_GET['cost'];
	$_gender = "";
	if( isset($_GET['gender'])) $_gender = $_GET['gender'];
	$_nationality = "";
	if( isset($_GET['nationality'])) $_nationality = $_GET['nationality'];
	$_metaQuery = array();
	if( $_age != ""){
		$arrAge = explode(",", $_age);
		$cri_Age = array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'		=> 'user_age',
					'value'		=> $arrAge[0],
					'compare'	=> '>=',
				),
				array(
					'key'   => 'user_age',
					'value'=> $arrAge[1],
					'compare' => '<=',
				)
			),
			array('relation' => 'AND',
				array(
					'key'		=> 'user_age_1',
					'value'		=> $arrAge[0],
					'compare'	=> '>=',
				),
				array(
					'key'   => 'user_age_1',
					'value'=> $arrAge[1],
					'compare' => '<=',
				)
			)
		);
		$_metaQuery[] = $cri_Age;
	}
	if( $_cost != ""){
		$arrCosts = explode(",", $_cost);
		$cri_cost = array('relation' => 'AND',
			array(
				'key'		=> 'ads_cost',
				'value'		=> $arrCosts[0],
				'compare'	=> '>='
			),
			array(
				'key'		=> 'ads_cost',
				'value'		=> $arrCosts[1],
				'compare'	=> '<='
			)
		);
		$_metaQuery[] = $cri_cost;
	}
	if( $_tags != ""){
		$cri_Tags = array(
			'key'		=> 'tags',
			'value'		=> $_tags,
			'compare'	=> 'like'
		);
		$_metaQuery[] = $cri_Tags;
	}
	// if( $_category != ""){
	// 	$cri_category = array(
	// 		'key'		=> 'categorySelect',
	// 		'value'		=> $_category,
	// 		'compare'	=> '='
	// 	);
	// 	$_metaQuery[] = $cri_category;
	// }
	if( $_nat_lang != ""){
		$cri_nat_lang = array(
			'key'		=> 'native_language',
			'value'		=> $_nat_lang,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_nat_lang;
	}
	if( $_hair != ""){
		$cri_hair = array('relation' => 'OR',
			array(
				'key'		=> 'hair_color',
				'value'		=> $_hair,
				'compare'	=> '='
			),
			array(
				'key'		=> 'hair_color_1',
				'value'		=> $_hair,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_hair;
	}
	if( $_eyes != ""){
		$cri_eyes = array('relation' => 'OR',
			array(
				'key'		=> 'eyes_color',
				'value'		=> $_eyes,
				'compare'	=> '='
			),
			array(
				'key'		=> 'eyes_color_1',
				'value'		=> $_eyes,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_eyes;
	}
	if( $_ethnicity != ""){
		$cri_ethnicity = array( 'relation' => 'OR',
			array(
				'key'		=> 'ethnicity',
				'value'		=> $_ethnicity,
				'compare'	=> '='
			),
			array(
				'key'		=> 'ethnicity_1',
				'value'		=> $_ethnicity,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_ethnicity;
	}
	if( $_weight != ""){
		$arrWeight = explode(",", $_weight);
		$cri_weight = array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'		=> 'weight',
					'value'		=> $arrWeight[0],
					'compare'	=> '>='
				),
				array(
					'key'		=> 'weight',
					'value'		=> $arrWeight[1],
					'compare'	=> '<='
				)
			),
			array('relation' => 'AND',
				array(
					'key'		=> 'weight_1',
					'value'		=> $arrWeight[0],
					'compare'	=> '>='
				),
				array(
					'key'		=> 'weight_1',
					'value'		=> $arrWeight[1],
					'compare'	=> '<='
				)
			)
		);
		$_metaQuery[] = $cri_weight;
	}
	if( $_waist != ""){
		$arrWaist = explode(",", $_waist);
		$cri_waist = array( 'relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'		=> 'waist_size',
					'value'		=> $arrWaist[0],
					'compare'	=> '>='
				),
				array(
					'key'		=> 'waist_size',
					'value'		=> $arrWaist[1],
					'compare'	=> '<='
				)
			),
			array('relation' => 'AND',
				array(
					'key'		=> 'waist_size_1',
					'value'		=> $arrWaist[0],
					'compare'	=> '>='
				),
				array(
					'key'		=> 'waist_size_1',
					'value'		=> $arrWaist[1],
					'compare'	=> '<='
				)
			)
		);
		$_metaQuery[] = $cri_waist;
	}
	if( $_hips != ""){
		$arrHips = explode(",", $_hips);
		$cri_hips = array( 'relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'		=> 'hips_size',
					'value'		=> $arrHips[0],
					'compare'	=> '>='
				),
				array(
					'key'		=> 'hips_size',
					'value'		=> $arrHips[1],
					'compare'	=> '<='
				)
			),
			array('relation' => 'AND',
				array(
					'key'		=> 'hips_size_1',
					'value'		=> $arrHips[0],
					'compare'	=> '>='
				),
				array(
					'key'		=> 'hips_size_1',
					'value'		=> $arrHips[1],
					'compare'	=> '<='
				)
			)
		);
		$_metaQuery[] = $cri_hips;
	}
	if( $_dress != ""){
		$cri_dress = array( 'relation' => 'OR',
			array(
				'key'		=> 'dress_size',
				'value'		=> $_dress,
				'compare'	=> '='
			),
			array(
				'key'		=> 'dress_size_1',
				'value'		=> $_dress,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_dress;
	}
	if( $_shoe != ""){
		$cri_shoe = array( 'relation' => 'OR',
			array(
				'key'		=> 'shoe_size',
				'value'		=> $_shoe,
				'compare'	=> '='
			),
			array(
				'key'		=> 'shoe_size_1',
				'value'		=> $_shoe,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_shoe;
	}
	if( $_pubic != ""){
		$cri_pubic = array(
			'key'		=> 'pubic_area',
			'value'		=> $_pubic,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_pubic;
	}
	if( $_smoker != ""){
		$cri_smoker = array( 'relation' => 'OR',
			array(
				'key'		=> 'smoker',
				'value'		=> $_smoker,
				'compare'	=> '='
			),
			array(
				'key'		=> 'smoker_1',
				'value'		=> $_smoker,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_smoker;
	}
	if( $_friendly != ""){
		$cri_friendly = array(
			'key'		=> 'disabled_friendly',
			'value'		=> $_friendly,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_friendly;
	}
	if( $_drink != ""){
		$cri_drink = array(
			'key'		=> 'drinks_supplied',
			'value'		=> $_drink,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_drink;
	}
	if( $_showers != ""){
		$cri_showers = array(
			'key'		=> 'showers_available',
			'value'		=> $_showers,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_showers;
	}
	if( $_travel != ""){
		$cri_travel = array(
			'key'		=> 'can_travel',
			'value'		=> $_travel,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_travel;
	}
	if( $_gender != ""){
		$cri_gender = array( 'relation' => 'OR',
			array(
				'key'		=> 'gender',
				'value'		=> $_gender,
				'compare'	=> '='
			),
			array(
				'key'		=> 'gender_1',
				'value'		=> $_gender,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_gender;
	}
	if( $_nationality != ""){
		$cri_nationality = array( 'relation' => 'OR',
			array(
				'key'		=> 'nationality',
				'value'		=> $_nationality,
				'compare'	=> '='
			),
			array(
				'key'		=> 'nationality_1',
				'value'		=> $_nationality,
				'compare'	=> '='
			)
		);
		$_metaQuery[] = $cri_nationality;
	}
	print_r($_metaQuery);
	$arags = array(
		'post_type' => 'post',
		'meta_query' => $_metaQuery,
	);
	$wsp_query = new WP_Query($arags);
	?>
	<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
		<div class="tab-divs">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active">
					<div class="container">
						<div class="row standard_type_size">
							<div class="col-lg-12">
								<div class="grid">
	<?php
		while ($wsp_query->have_posts()) : $wsp_query->the_post();
			if($_category != ""){
	            $curCatSel = get_the_category($post->ID);
	            $curCategory = $curCatSel[0]->term_id;
	            if($curCategory != $_category)
	            	continue;
			}
			$featuredPosts[] = $post->ID;
			// print_r($post);
			get_template_part( 'templates/classiera-loops/loop-canary');
		endwhile;
		wp_reset_postdata();
	?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
} else if( $_search != ""){

	global $redux_demo;
	$locShownBy = $redux_demo['location-shown-by'];

	$_sKeyword = "";
	if( isset( $_GET['sKeyword'])) $_sKeyword = $_GET['sKeyword'];
	$_catName = "";
	if( isset($_GET['cat_name'])) $_catName = $_GET['cat_name'];
	$_location = "";
	if( isset($_GET[$locShownBy])) $_location = $_GET[$locShownBy];
	$_metaQuery = array();
	if( $_location != ""){
		$cri_location = array(
			'key'		=> $locShownBy,
			'value'		=> $_location,
			'compare'	=> '='
		);
		$_metaQuery[] = $cri_location;
	}

	$arags = array(
		'post_type' => 'post',
		'meta_query' => $_metaQuery,
	);

	$wsp_query = new WP_Query($arags);
	// print_r($wsp_query);
	?>
	<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
		<div class="tab-divs">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active">
					<div class="container">
						<div class="row standard_type_size">
							<div class="col-lg-12">
								<div class="grid">
	<?php
	// echo("Search functions.<br>\n");
	while( $wsp_query->have_posts()) : $wsp_query->the_post();
		if( $_catName != 1 && $_catName != ""){
			$curCatSel = get_the_category($post->ID);
			$curCategory = $curCatSel[0]->term_id;
			if( $curCategory != $_catName) continue;
		}
		if( $_sKeyword != ""){
			$_postName = get_post_field('post_title', $post->ID);
			$_postContents = get_post_field('post_content', $post->ID);
			if( stripos($_postName, $_sKeyword) === false && stripos($_postContents, $_sKeyword) === false) continue;
		}
		$featuredPosts[] = $post->ID;
		get_template_part( 'templates/classiera-loops/loop-canary');
	endwhile;
		wp_reset_postdata();
	?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
} else{
	global $redux_demo;	

	$classieraAdsSecDesc = $redux_demo['ad-desc'];

	$ads_counter = $redux_demo['home-ads-counter'];

	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];

	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];

	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];

	$classieraAdsView = $redux_demo['home-ads-view'];

	$classieraItemClass = "item-masonry";

	if($classieraAdsView == 'list'){

		$classieraItemClass = "item-list";

	}

	$category_icon_code = "";

	$category_icon_color = "";

	$catIcon = "";

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
	$bumpAds=array('relation' => 'OR',
		array(
			'kay'=>'bump_ads',
			'value'=>'1',
			'compare'=>'=',
		),
		array(
			'kay'=>'bump_ads',
			'compare'=>'NOT EXISTS',
		));
	$adsTypeMetaDouble= array('relation' => 'OR',
	    array(
	        'key'     => 'ads_type_selected',
	        'value'	=>'standard_top',
	        'compare' => '=',
	    	),
		array(
            'key'   => 'ads_type_selected',
            'value'=>'double_top',
            'compare' => '=',
        ),
        // array(
        //     'key'   => 'ads_type_selected',
        //     'compare' => 'NOT EXISTS',
        // ),

	);
	$adsTypeMetaSec=array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'value'=>'1',
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
				),
			),
		);

	$adsTypeMetaFirst=array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'value'=>'1',
					'compare'=>'=',
				),
				array('relation' => 'OR',
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

	$adsTypeMeta= array('relation' => 'OR',
	    array(
	        'key'     => 'ads_type_selected',
	        'value'	=>'standard',
	        'compare' => '=',
	    	),
		array(
            'key'   => 'ads_type_selected',
            'value'	=>'double_sec',
            'compare' => '=',
        ),
        array(
            'key'   => 'ads_type_selected',
            'compare' => 'NOT EXISTS',
        ),

	);

?>

<section class="classiera-advertisement advertisement-v4 section-pad-top-100">

	<div class="tab-divs">

		<div class="tab-content">

			<div role="tabpanel" class="tab-pane fade in active" id="all">

				<div class="container">

					<div class="row double_size">
						
						<div class="col-lg-12">

							<div class="grid">

								<?php
								global $paged, $wp_query, $wp;
								$args = wp_parse_args($wp->matched_query);

								if( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}

								$featuredPosts = array();
								$arags = array(
									'post_type' => 'post',
									'posts_per_page' => $classieraFeaturedAdsCounter,
									'paged' => $paged,
									'meta_query' => array(
										$bumpAds,
										$adsTypeMetaDouble,
										// array(
										// 	'key' => 'featured_post',
										// 	'value' => '1',
										// 	'compare' => '=='
										// ),
										$adstypeQuery,
									),

									'meta_key' => 'bump_ads',
									'orderby' =>  array( 
										'meta_value' => 'DESC',
										'date' => 'DESC'
									),
									'order' => 'DESC',
								);

								$wsp_query = new WP_Query($arags);
								// echo '</pre>';
								// print_r($wsp_query);
								// echo '</pre>';
								while ($wsp_query->have_posts()) : $wsp_query->the_post();
									$featuredPosts[] = $post->ID;
									get_template_part( 'templates/classiera-loops/loop-canary');
								endwhile;
								wp_reset_postdata();
								wp_reset_query(); ?>

								<?php 

								global $paged, $wp_query, $wp;

								$args = wp_parse_args($wp->matched_query);
								if ( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}

								$arags = array(
									'post_type' => 'post',
									'posts_per_page' => $ads_counter,
									'paged' => $paged,
									'post__not_in' => $featuredPosts,
									'meta_query' => array(
										$bumpAds,
										$adstypeQuery,
										$adsTypeMetaDouble,
									),
									'orderby' => 'date',
								);

								$wsp_query = new WP_Query($arags);
								while ($wsp_query->have_posts()) : $wsp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-canary');
								endwhile;

								wp_reset_postdata(); ?>	
							</div>

						</div>

					</div><!-- / Row Double_size -->

					<div class="row standard_type_size">

						<div class="col-lg-12">

							<div class="grid">

								<?php 
								global $paged, $wp_query, $wp;
								$args = wp_parse_args($wp->matched_query);
								if ( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}
								$featuredPosts = array();
								$arags = array(
									'post_type' => 'post',
									'posts_per_page' => $classieraFeaturedAdsCounter,
									'paged' => $paged,
									'meta_query' => array(
										$bumpAds,
										$adsTypeMeta,
										// array(
										// 	'key' => 'featured_post',
										// 	'value' => '1',
										// 	'compare' => '=='
										// ),
										$adstypeQuery
									),
									'meta_key' => 'bump_ads',
									'orderby' =>  array(
										'meta_value' => 'DESC',
										'date' => 'DESC'
									),
									'order' => 'DESC',
								);

								$wsp_query = new WP_Query($arags);
								// echo '</pre>';
								// print_r($wsp_query);
								// echo '</pre>';
								while ($wsp_query->have_posts()) : $wsp_query->the_post();
								$featuredPosts[] = $post->ID;
								get_template_part( 'templates/classiera-loops/loop-canary');
								endwhile;

								wp_reset_postdata();

								wp_reset_query(); ?>

								<!--FeaturedAds-->

								<?php 
								global $paged, $wp_query, $wp;
								$args = wp_parse_args($wp->matched_query);
								if ( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}

								$arags = array(
									'post_type' => 'post',
									'posts_per_page' => $ads_counter,
									'paged' => $paged,
									'post__not_in' => $featuredPosts,
									'meta_query' => array(
										$bumpAds,
										$adstypeQuery,
										$adsTypeMeta,
									),
									'orderby' => 'date',
								);

								$wsp_query = new WP_Query($arags);
								while ($wsp_query->have_posts()) : $wsp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-canary');
								endwhile;

								wp_reset_postdata(); ?>
							</div><!-- / Grid -->

						</div>

					</div><!--row-->

				</div><!--container-->

			</div><!--tabpanel-->

		</div><!--tab-content-->

	</div><!--tab-divs-->

</section>
<?php
}
?>