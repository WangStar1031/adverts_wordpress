<?php 
	global $redux_demo;
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraItemClass = "item-masonry";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}
	$ads_type_selected = get_post_meta($post->ID, 'ads_type_selected', true);
	$largeAds='';
	if($ads_type_selected=='double_sec' || $ads_type_selected=='double_top')
	{
		$largeAds='grid-item--width2';
		$image_size='advert_double';
	}
	else
	{
		$largeAds='grid-item';
		$image_size='advert';
	}
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$category = get_the_category();
	$catID = $category[0]->cat_ID;
	$isNew = false;
	$diff = date_diff( date_create(date("Y/m/d", strtotime("-3 day"))), date_create(get_the_date("Y/m/d")));
	$diffDate = $diff->format("%R%a");
	if( $diffDate < 0){
		$isNew = false;
	} else{
		$isNew = true;
	}
	if ($category[0]->category_parent == 0) {
		$tag = $category[0]->cat_ID;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}elseif(isset($category[1]->category_parent) && $category[1]->category_parent == 0){
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}else{
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}
	if(!empty($category_icon_code)) {
		$category_icon = stripslashes($category_icon_code);
	}
	if(!empty($category_icon_color)) {
		$category_icon_color = $primaryColor;
	}
	$post_price = get_post_meta($post->ID, 'post_price', true);
	$post_phone = get_post_meta($post->ID, 'post_phone', true);
	$fifteen_min_euro = get_post_meta($post->ID, 'fifteen_min_euro', true);
	$fifteen_min_pound = get_post_meta($post->ID, 'fifteen_min_pound', true);
	$thirty_min_euro = get_post_meta($post->ID, 'thirty_min_euro', true);
	$thirty_min_pound = get_post_meta($post->ID, 'thirty_min_pound', true);
	$fourty_five_min_euro = get_post_meta($post->ID, 'fourty_five_min_euro', true);
	$fourty_five_min_pound = get_post_meta($post->ID, 'fourty_five_min_pound', true);
	$one_hour_euro = get_post_meta($post->ID, 'one_hour_euro', true);
	$one_hour_pound = get_post_meta($post->ID, 'one_hour_pound', true);
	$full_day_euro = get_post_meta($post->ID, 'full_day_euro', true);
	$full_day_pound = get_post_meta($post->ID, 'full_day_pound', true);
	$business_date_euro = get_post_meta($post->ID, 'business_date_euro', true);
	$business_date_pound = get_post_meta($post->ID, 'business_date_pound', true);
	$theTitle = get_the_title();
	$partner_name =  get_post_meta($post->ID, 'partner_name', true);
	$postCatgory = get_the_category( $post->ID );
	$categoryLink = get_category_link($catID);
	$classieraPostAuthor = $post->post_author;
	$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
	$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
	$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
	$classiera_ads_statustime = get_post_meta($post->ID, 'classiera_ads_statustime', true);
	$current_time = date("Y-m-d H:i:s");
	if($current_time >= $classiera_ads_statustime){ ?>

	<div class="<?php echo $largeAds;?>">
		<div class="classiera-box-div classiera-box-div-v4">
			<figure class="clearfix">
				<?php
						if($isNew){
					?>
						<div class="newSection">
							<!-- <img src="<?php echo get_stylesheet_directory_uri();?>/img/new-arrival.svg" alt=""> -->
							<span class="new-arrival text-uppercase"><?php _e('New', 'classiera'); ?></span>
						</div>
					<?php } ?>
				<div class="premium-img">
					
					<div class="premium-img-inner">
					<!-- Get the image -->	
					<?php
						// $imageurl = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $image_size);
						// $thumb_id = get_post_thumbnail_id($post->ID);
						$posttype = get_post_meta($post->ID, "ads_type_selected");
						$post_type = $posttype[0];
						if( strpos($post_type, 'standard') === false ){
							$realUrl = get_post_meta($post->ID, "croppedImg_Path_double");
						} else {
							$realUrl = get_post_meta($post->ID, "croppedImg_Path");
						}
						if( count($realUrl) != 0){
						?>
						<img class="img-responsive" src="<?php echo esc_url($realUrl[0]); ?>" alt="<?php echo esc_html($theTitle); ?>" postID="<?=$post->ID?>" posttype="<?=$post_type?>">
						<?php
						} else{
						?>
						<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png'; ?>" alt="<?php echo esc_html($theTitle); ?>" postID="<?=$post->ID?>" posttype="<?=$post_type?>">
						<?php
						}
					?>

					<?php
						$discount_per = get_post_meta($post->ID, 'discount_percentage', true);
						if(!empty($discount_per) && $discount_per > 0)
						{ ?>
							<div class="discount_per_parent">
								<span class="discount_per">
									<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" style="width: 45px;">
									  <defs>
									    <style>
									      .cls-1 {
									        fill: #c60303;
									      }

									      .cls-2 {
									        font-size: 32.27797px;
									        fill: #fff;
									        font-family: MyriadPro-Regular, Myriad Pro;
									      }
									    </style>
									  </defs>
									  <title>corner</title>
									  <polygon class="cls-1" points="0 0 100 100 100 0 0 0"/>
									  <text class="cls-2 discount-inner" transform="translate(32.05145 19.44904) rotate(45)"><?php esc_html_e('-' . $discount_per .'%', 'classiera' );?></text>
									</svg>
								</span>
							</div>
							
					<?php } ?>
					<!-- / Get the Image -->
						<!-- Hover content -->
						<a href="<?php the_permalink(); ?>">
							<span class="hover-posts">
								<div class="row">

									<div class="col-lg-12">
										<h4 style="color: white; max-width: 70%; margin: 10px auto;">
											<!-- Display advert name -->
											<?php if(in_category(array('couple', 'duo'))) { ?>
												<?php echo esc_html($theTitle); ?> &amp; <?php echo esc_html($partner_name); ?>
											<?php } else { ?>
												<?php echo esc_html($theTitle); ?>
											<?php } ?>
										</h4>
									</div>

									<div class="col-lg-12">
										<?php
											$_isNoPrice = true;
										?>

										<!-- <span style="color: white"><?php echo esc_html_e($current_time); ?></span> -->

										<div class="table-responsive">
											<table style="width: 100%">
												<?php if (!empty($fifteen_min_euro || $fifteen_min_pound || $thirty_min_euro || $thirty_min_pound || $fourty_five_min_euro || $fourty_five_min_pound)) { ?>
													<tr>
														<td>Time</td>
														<td>Price in &euro;</td>
														<td>Price in &pound;</td>
													</tr>
												<?php } ?>
												<?php if (!empty($fifteen_min_euro)) { $_isNoPrice = false; ?>
													<tr>
														<td><?php esc_html_e('15 Min', 'classiera'); ?></td>
														<td><?php echo esc_html($fifteen_min_euro); ?> &euro;</td>
														<td><?php echo esc_html($fifteen_min_pound); ?> &pound;</td>
													</tr>
												<?php } ?>
												<?php if (!empty($thirty_min_euro)) { $_isNoPrice = false; ?>
													<tr>
														<td><?php esc_html_e('30 Min', 'classiera'); ?></td>
														<td><?php echo esc_html($thirty_min_euro); ?> &euro;</td>
														<td><?php echo esc_html($thirty_min_pound); ?> &pound;</td>
													</tr>
												<?php } ?>
												<?php if (!empty($fourty_five_min_euro)) { $_isNoPrice = false; ?>
													<tr>
														<td><?php esc_html_e('45 Min', 'classiera'); ?></td>
														<td><?php echo esc_html($fourty_five_min_euro); ?> &euro;</td>
														<td><?php echo esc_html($fourty_five_min_pound); ?> &pound;</td>
													</tr>
												<?php } ?>
												<!-- <?php if (!empty($one_hour_euro)) { $_isNoPrice = false; ?>
													<tr>
														<td><?php esc_html_e('1 Hour', 'classiera'); ?></td>
														<td><?php echo esc_html($one_hour_euro); ?> &euro;</td>
														<td><?php echo esc_html($one_hour_pound); ?> &pound;</td>
													</tr>
												<?php } ?>
												<?php if (!empty($full_day_euro)) { $_isNoPrice = false; ?>
													<tr>
														<td><?php esc_html_e('Full Day', 'classiera'); ?></td>
														<td><?php echo esc_html($full_day_euro); ?> &euro;</td>
														<td><?php echo esc_html($full_day_pound); ?> &pound;</td>
													</tr>
												<?php } ?>
												<?php if (!empty($business_date_euro)) { $_isNoPrice = false; ?>
													<tr>
														<td><?php esc_html_e('Business Date', 'classiera'); ?></td>
														<td><?php echo esc_html($business_date_euro); ?> &euro;</td>
														<td><?php echo esc_html($business_date_pound); ?> &pound;</td>
													</tr>
												<?php } ?> -->
												<?php if( $_isNoPrice == true){?>
													<div class="col-lg-12">
														<span><?php esc_html_e('No prices provided', 'classiera'); ?></span>
													</div>
												<?php }?>
											</table>
										</div>
									</div>
								</div>
							</span>
						</a>
						<!-- / Hover Content -->
						<div class="category clearfix">
							<a href="<?php echo esc_url($categoryLink); ?>"><?php echo esc_html($postCatgory[0]->name); ?></a>							
							<!-- <a class="pull-right" style="margin-right: 10px;" href="tel:<?php echo esc_html($post_phone); ?>"><?php echo esc_html($post_phone); ?></a> -->
						</div><!--category-->
					</div><!--premium-img-inner-->
				</div><!--premium-img-->
			</figure>
		</div><!--row-->
	</div>
<?php } ?><!--item item-grid item-masonry-->

<script>
	var discountDiv = $(".premium-img .discount_per_parent");
	for( var i = 0; i < discountDiv.length; i++){
		var imgDiv = discountDiv.eq(i).parent().find(".premium-img-inner").eq(0);
		discountDiv.eq(i).css("left", imgDiv.width());
		// discountDiv.eq(i).css("top", "1px");
		discountDiv.eq(i).show();
	}
	$(document).ready(function(){
		
		// anime({
		//   targets: '.discount-inner',
		//   easing: 'easeInOutSine',
		//   duration: 500,
		//   translateX: [
		//     {
		//       value: 3,
		//     },
		//     {
		//       value: -3,
		//     },
		//     {
		//       value: 3,
		//     },
		//     {
		//       value: -3,
		//     },
		//   ],
		//   rotate: [
		//     {
		//       value: 70,
		//     },
		//     {
		//       value: 20,
		//     },
		//     {
		//       value: 70,
		//     },
		//     {
		//       value: 20,
		//     },
		//   ],
		//   duration: 400,
		//   scale: {
		//   	value: 4,
		//   	easing: 'easeInOutQuart',
		//   },
		//   loop: true,
		//   direction: 'alternate',
		//   delay: 2000, 
		// });

		// anime({
		//   targets: '.dashed-line',
		//   rotate: {
		//     value: 360,
		//     duration: 1800,
		//     // easing: 'easeInOutSine'
		//   },
		//   loop: true,
		//   direction: 'alternate',
		// });
	});

</script>